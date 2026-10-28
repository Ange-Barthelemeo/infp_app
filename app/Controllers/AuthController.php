<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $session = session();
        $model   = new \App\Models\UtilisateurModel();

        $im       = trim($this->request->getPost('immutilisateur') ?? '');
        $password = $this->request->getPost('motdepasse') ?? '';

        if (empty($im) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Veuillez remplir tous les champs.');
        }

        $user = $model->where('IMMUTILISATEUR', $im)->first();

        if ($user) {
            // Vérifier si le compte est actif
            if (isset($user['ACTIF']) && (int)$user['ACTIF'] === 0) {
                return redirect()->back()->with('error', 'Votre compte est actuellement inactif ou bloqué. Contactez l\'administrateur.');
            }

            // Vérification du mot de passe
            if (password_verify($password, $user['MOTDEPASSE'])) {

                // Succès : Réinitialiser le compteur de tentatives échouées
                $model->update($user['IMMUTILISATEUR'], ['TENTATIVES_ECHOUEES' => 0]);

                $sessionData = [
                    'immutilisateur' => $user['IMMUTILISATEUR'],
                    'nom'            => $user['NOM'] ?? '',
                    'prenoms'        => $user['PRENOMS'] ?? '',
                    'profil'         => $user['PROFIL'],
                    'logged_in'      => true
                ];
                $session->set($sessionData);

                $profil = $user['PROFIL'];

                // L'administrateur n'est JAMAIS soumis au processus de première connexion
                if ($profil !== 'ADMIN' && isset($user['PREMIERE_CONNEXION']) && (int)$user['PREMIERE_CONNEXION'] === 1) {
                    return redirect()->to('/changer-mot-de-passe-initial');
                }

                // Aiguillage normal selon le profil métier
                // Aiguillage normal selon le profil métier
                switch ($profil) {
                    case 'ADMIN':
                        return redirect()->to('/dashboard'); // ou /admin/dashboard selon votre configuration admin
                    case 'GESTIONNAIRE_CENTRAL':
                        return redirect()->to('/central/dashboard');
                    case 'GESTIONNAIRE_CENTRE':
                    case 'RESPONSABLE_CENTRE':
                        return redirect()->to('/gestionnaire/dashboard');
                    default:
                        return redirect()->to('/dashboard');
                }
            } else {
                // Échec du mot de passe : Incrémenter les tentatives échouées
                $maxAttempts = (int) get_setting('max_login_attempts', 5);
                $attempts = (int)($user['TENTATIVES_ECHOUEES'] ?? 0) + 1;

                if ($attempts >= $maxAttempts) {
                    // Blocage automatique du compte
                    $model->update($user['IMMUTILISATEUR'], [
                        'TENTATIVES_ECHOUEES' => $attempts,
                        'ACTIF' => 0
                    ]);
                    return redirect()->back()->withInput()->with('error', 'Votre compte a été bloqué suite à un nombre trop élevé de tentatives infructueuses.');
                } else {
                    // Mise à jour du compteur d'échecs
                    $model->update($user['IMMUTILISATEUR'], [
                        'TENTATIVES_ECHOUEES' => $attempts
                    ]);
                    return redirect()->back()->withInput()->with('error', 'Matricule ou mot de passe incorrect. (Tentative ' . $attempts . '/' . $maxAttempts . ')');
                }
            }
        }

        return redirect()->back()->withInput()->with('error', 'Matricule ou mot de passe incorrect.');
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
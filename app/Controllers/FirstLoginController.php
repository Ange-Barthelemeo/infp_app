<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class FirstLoginController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('auth/first_password_change', [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms')
        ]);
    }

    public function update()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $newPassword     = $this->request->getPost('nouveau_motdepasse');
        $confirmPassword = $this->request->getPost('confirm_motdepasse');

        if (strlen($newPassword) < 8) {
            return redirect()->back()->with('error', 'Le mot de passe doit comporter au moins 8 caractères.');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Les deux mots de passe ne correspondent pas.');
        }

        $im = $session->get('immutilisateur');
        $db = \Config\Database::connect();

        // Mise à jour directe et garantie en base de données
        $db->table('UTILISATEUR')
           ->where('IMMUTILISATEUR', $im)
           ->update([
               'MOTDEPASSE'         => password_hash($newPassword, PASSWORD_BCRYPT),
               'PREMIERE_CONNEXION' => 0
           ]);

        $profil = $session->get('profil');

        // Redirection adaptée selon le profil métier
        switch ($profil) {
            case 'ADMIN':
                return redirect()->to('/dashboard')->with('success', 'Votre mot de passe a été personnalisé avec succès.');
            case 'GESTIONNAIRE_CENTRAL':
                return redirect()->to('/central/dashboard')->with('success', 'Votre mot de passe a été personnalisé avec succès.');
            case 'GESTIONNAIRE_CENTRE':
            case 'RESPONSABLE_CENTRE':
                return redirect()->to('/centre/dashboard')->with('success', 'Votre mot de passe a été personnalisé avec succès.');
            default:
                return redirect()->to('/dashboard')->with('success', 'Votre mot de passe a été personnalisé avec succès.');
        }
    }
}
<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class AdminProfileController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new UtilisateurModel();
        $admin = $model->where('IMMUTILISATEUR', $session->get('immutilisateur'))->first();

        return view('admin/profile/index', [
            'immutilisateur' => $session->get('immutilisateur'),
            'admin'          => $admin
        ]);
    }

    public function update()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new UtilisateurModel();
        $im = $session->get('immutilisateur');
        $admin = $model->find($im);

        $nom             = trim($this->request->getPost('nom'));
        $prenoms         = trim($this->request->getPost('prenoms'));
        $email           = trim($this->request->getPost('email'));
        $ancienPassword  = $this->request->getPost('ancien_motdepasse');
        $nouveauPassword = $this->request->getPost('nouveau_motdepasse');
        $confirmPassword = $this->request->getPost('confirm_motdepasse');

        $data = [
            'NOM'     => $nom,
            'PRENOMS' => $prenoms,
            'EMAIL'   => $email
        ];

        // Traitement sécurisé du mot de passe s'il est renseigné
        if (!empty($nouveauPassword)) {
            // 1. Vérification de l'ancien mot de passe
            if (empty($ancienPassword) || !password_verify($ancienPassword, $admin['MOTDEPASSE'])) {
                return redirect()->back()->withInput()->with('error', 'L\'ancien mot de passe est incorrect.');
            }

            // 2. Vérification de la correspondance des deux nouveaux mots de passe
            if ($nouveauPassword !== $confirmPassword) {
                return redirect()->back()->withInput()->with('error', 'Les nouveaux mots de passe ne correspondent pas.');
            }

            // 3. Validation de la longueur minimale
            if (strlen($nouveauPassword) < 8) {
                return redirect()->back()->withInput()->with('error', 'Le nouveau mot de passe doit contenir au moins 8 caractères.');
            }

            $data['MOTDEPASSE'] = password_hash($nouveauPassword, PASSWORD_BCRYPT);
        }

        $model->update($im, $data);

        // Mettre à jour les données en session
        $session->set([
            'nom'     => $nom,
            'prenoms' => $prenoms
        ]);

        return redirect()->to('/admin/profile')->with('success', 'Profil administrateur mis à jour avec succès.');
    }
}
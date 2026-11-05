<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CentralProfileController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $im = $session->get('immutilisateur');

        $utilisateur = $db->table('UTILISATEUR')
            ->where('IMMUTILISATEUR', $im)
            ->get()
            ->getRowArray();

        $data = [
            'immutilisateur' => $im,
            'nom'            => $utilisateur['NOM'] ?? $session->get('nom'),
            'prenoms'        => $utilisateur['PRENOMS'] ?? $session->get('prenoms'),
            'email'          => $utilisateur['EMAIL'] ?? '',
            'utilisateur'    => $utilisateur
        ];

        return view('gestionnaire/profile/index', $data);
    }

    public function update()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $request = service('request');
        $im = $session->get('immutilisateur');

        $nom = trim($request->getPost('NOM'));
        $prenoms = trim($request->getPost('PRENOMS'));
        $email = trim($request->getPost('EMAIL'));

        $ancienMdp = $request->getPost('ANCIEN_MDP');
        $nouveauMdp = $request->getPost('NOUVEAU_MDP');
        $confirmerMdp = $request->getPost('CONFIRMER_MDP');

        $utilisateur = $db->table('UTILISATEUR')
            ->where('IMMUTILISATEUR', $im)
            ->get()
            ->getRowArray();

        $updateData = [
            'NOM'     => $nom,
            'PRENOMS' => $prenoms,
            'EMAIL'   => $email
        ];

        // Gestion de la modification du mot de passe si rempli
        if (!empty($ancienMdp) || !empty($nouveauMdp) || !empty($confirmerMdp)) {
            if (empty($ancienMdp) || empty($nouveauMdp) || empty($confirmerMdp)) {
                return redirect()->back()->withInput()->with('error', 'Veuillez remplir tous les champs de mot de passe pour effectuer une modification.');
            }

            if (!password_verify($ancienMdp, $utilisateur['MOTDEPASSE'])) {
                return redirect()->back()->withInput()->with('error', 'L\'ancien mot de passe est incorrect.');
            }

            if (strlen($nouveauMdp) < 8) {
                return redirect()->back()->withInput()->with('error', 'Le nouveau mot de passe doit contenir au moins 8 caractères.');
            }

            if ($nouveauMdp !== $confirmerMdp) {
                return redirect()->back()->withInput()->with('error', 'Les nouveaux mots de passe ne correspondent pas.');
            }

            $updateData['MOTDEPASSE'] = password_hash($nouveauMdp, PASSWORD_DEFAULT);
        }

        $db->table('UTILISATEUR')
            ->where('IMMUTILISATEUR', $im)
            ->update($updateData);

        // Mettre à jour les données de session
        $session->set([
            'nom'     => $nom,
            'prenoms' => $prenoms
        ]);

        return redirect()->to('/gestionnaire/profile')->with('success', 'Profil mis à jour avec succès.');
    }
}
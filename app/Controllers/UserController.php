<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class UserController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        
        $search         = trim($this->request->getGet('search') ?? '');
        $filtreProfil    = $this->request->getGet('profil');
        $filtreCentre    = $this->request->getGet('centre');
        $filtreDirection = $this->request->getGet('direction');

        $builder = $db->table('UTILISATEUR');
        $builder->select('UTILISATEUR.*, DIRECTION.NOMDIRECTION, CENTRE.NOMCENTRE');
        $builder->join('DIRECTION', 'DIRECTION.CODEDIRECTION = UTILISATEUR.CODEDIRECTION', 'left');
        $builder->join('CENTRE', 'CENTRE.CODECENTRE = UTILISATEUR.CODECENTRE', 'left');
        $builder->where('UTILISATEUR.PROFIL !=', 'ADMIN');

        // Recherche intelligente (IM, Nom seul, Prénom seul, ou Nom + Prénom combinés dans n'importe quel ordre)
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('UTILISATEUR.IMMUTILISATEUR', $search)
                    ->orLike('UTILISATEUR.NOM', $search)
                    ->orLike('UTILISATEUR.PRENOMS', $search)
                    ->orLike("CONCAT(UTILISATEUR.NOM, ' ', UTILISATEUR.PRENOMS)", $search)
                    ->orLike("CONCAT(UTILISATEUR.PRENOMS, ' ', UTILISATEUR.NOM)", $search)
                    ->groupEnd();
        }

        if (!empty($filtreProfil)) {
            $builder->where('UTILISATEUR.PROFIL', $filtreProfil);
        }
        if (!empty($filtreCentre)) {
            $builder->where('UTILISATEUR.CODECENTRE', $filtreCentre);
        }
        if (!empty($filtreDirection)) {
            $builder->where('UTILISATEUR.CODEDIRECTION', $filtreDirection);
        }

        $builder->orderBy('UTILISATEUR.IMMUTILISATEUR', 'DESC');
        $users = $builder->get()->getResultArray();

        $directions = $db->table('DIRECTION')->get()->getResultArray();
        $centres    = $db->table('CENTRE')->get()->getResultArray();

        $data = [
            'immutilisateur'  => $session->get('immutilisateur'),
            'nom'             => $session->get('nom'),
            'prenoms'         => $session->get('prenoms'),
            'users'           => $users,
            'directions'      => $directions,
            'centres'         => $centres,
            'search'          => $search,
            'filtreProfil'    => $filtreProfil,
            'filtreCentre'    => $filtreCentre,
            'filtreDirection' => $filtreDirection
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $directions = $db->table('DIRECTION')->get()->getResultArray();
        $centres    = $db->table('CENTRE')->get()->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'directions'     => $directions,
            'centres'        => $centres
        ];

        return view('admin/users/create', $data);
    }

    public function store()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UtilisateurModel();

        $rawIm   = trim($this->request->getPost('immutilisateur'));
        $nom     = trim($this->request->getPost('nom'));
        $prenoms = trim($this->request->getPost('prenoms'));
        $email   = trim($this->request->getPost('email'));
        $profil  = $this->request->getPost('profil');
        
        $chiffres = preg_replace('/\D/', '', $rawIm);
        
        if (strlen($chiffres) !== 6) {
            return redirect()->back()->withInput()->with('error', 'Le matricule (IM) doit comporter exactement 6 chiffres.');
        }

        $lettreProfil = 'C';
        if ($profil === 'ADMIN') {
            $lettreProfil = 'A';
        } elseif ($profil === 'GESTIONNAIRE_CENTRAL') {
            $lettreProfil = 'C';
        } elseif ($profil === 'GESTIONNAIRE_CENTRE') {
            $lettreProfil = 'B';
        } elseif ($profil === 'RESPONSABLE_CENTRE') {
            $lettreProfil = 'R';
        }

        $imFinal = substr($chiffres, 0, 3) . ' ' . substr($chiffres, 3, 3) . '-' . $lettreProfil;

        $codedirection = null;
        $codecentre    = null;

        if ($profil === 'GESTIONNAIRE_CENTRAL') {
            $codedirection = $this->request->getPost('codedirection') ?: null;
        } else {
            $codecentre = $this->request->getPost('codecentre') ?: null;
        }

        if ($userModel->find($imFinal)) {
            return redirect()->back()->withInput()->with('error', 'Ce matricule (IM) existe déjà dans la base.');
        }

        // Vérification de l'unicité de l'e-mail lors de la création
        if (!empty($email) && $userModel->where('EMAIL', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Cette adresse e-mail est déjà utilisée par un autre compte. Veuillez en saisir une autre.');
        }

        // Définition du mot de passe par défaut à "1234"
        $defaultPassword = '1234';

        $data = [
            'IMMUTILISATEUR'     => $imFinal,
            'NOM'                => $nom,
            'PRENOMS'            => $prenoms,
            'CODEDIRECTION'      => $codedirection,
            'CODECENTRE'         => $codecentre,
            'EMAIL'              => $email,
            'PROFIL'             => $profil,
            'MOTDEPASSE'         => password_hash($defaultPassword, PASSWORD_BCRYPT),
            'ACTIF'              => 1,
            'PREMIERE_CONNEXION' => 1
        ];

        $userModel->insert($data);

        // Journalisation de la création du compte
        enregistrer_log($session->get('immutilisateur'), "Création du compte utilisateur : " . $imFinal . " (" . $nom . " " . $prenoms . ")");

        return redirect()->to('/utilisateurs')->with('success', 'Compte créé avec succès.');
    }

    public function edit($im)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $imDecoded = urldecode($im);

        $userModel = new UtilisateurModel();
        $userToEdit = $userModel->find($imDecoded);

        if (!$userToEdit) {
            return redirect()->to('/utilisateurs')->with('error', 'Utilisateur introuvable.');
        }

        $directions = $db->table('DIRECTION')->get()->getResultArray();
        $centres    = $db->table('CENTRE')->get()->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'userToEdit'     => $userToEdit,
            'directions'     => $directions,
            'centres'        => $centres
        ];

        return view('admin/users/edit', $data);
    }

    public function update($im)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UtilisateurModel();
        $imDecoded = urldecode($im);
        $currentUser = $userModel->find($imDecoded);

        if (!$currentUser) {
            return redirect()->to('/utilisateurs')->with('error', 'Utilisateur introuvable.');
        }

        $nom     = trim($this->request->getPost('nom'));
        $prenoms = trim($this->request->getPost('prenoms'));
        $email   = trim($this->request->getPost('email'));

        // Vérification de l'unicité de l'e-mail lors de la modification (excluant l'utilisateur actuel)
        if (!empty($email)) {
            $existingEmailUser = $userModel->where('EMAIL', $email)->where('IMMUTILISATEUR !=', $imDecoded)->first();
            if ($existingEmailUser) {
                return redirect()->back()->withInput()->with('error', 'Cette adresse e-mail appartient déjà à un autre utilisateur. Modification refusée.');
            }
        }

        $codedirection = null;
        $codecentre    = null;

        if ($currentUser['PROFIL'] === 'GESTIONNAIRE_CENTRAL') {
            $codedirection = $this->request->getPost('codedirection') ?: null;
        } else {
            $codecentre = $this->request->getPost('codecentre') ?: null;
        }

        $updateData = [
            'NOM'           => $nom,
            'PRENOMS'       => $prenoms,
            'CODEDIRECTION' => $codedirection,
            'CODECENTRE'    => $codecentre,
            'EMAIL'         => $email
        ];

        $userModel->update($imDecoded, $updateData);

        // Journalisation de la modification du compte
        enregistrer_log($session->get('immutilisateur'), "Modification du compte utilisateur : " . $imDecoded);

        return redirect()->to('/utilisateurs')->with('success', 'Informations de l\'utilisateur mises à jour avec succès.');
    }

    public function toggleStatus($im)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UtilisateurModel();
        $imDecoded = urldecode($im);
        $user = $userModel->find($imDecoded);

        if ($user) {
            $newStatus = $user['ACTIF'] ? 0 : 1;
            $userModel->update($imDecoded, ['ACTIF' => $newStatus]);
            
            // Journalisation du changement de statut (Activation / Désactivation)
            $statusLabel = $newStatus ? 'Activation' : 'Désactivation';
            enregistrer_log($session->get('immutilisateur'), "$statusLabel du compte utilisateur : " . $imDecoded);

            return redirect()->to('/utilisateurs')->with('success', 'Statut du compte mis à jour.');
        }

        return redirect()->to('/utilisateurs')->with('error', 'Utilisateur introuvable.');
    }
}
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

        $profilConnecte = $session->get('profil');
        $centreConnecte = $session->get('codecentre');

        if ($profilConnecte === 'GESTIONNAIRE_CENTRE') {
            $builder->where('UTILISATEUR.CODECENTRE', $centreConnecte);
        } else {
            $builder->where('UTILISATEUR.PROFIL !=', 'ADMIN');
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('UTILISATEUR.IMMUTILISATEUR', $search)
                    ->orLike('UTILISATEUR.NOM', $search)
                    ->orLike('UTILISATEUR.PRENOMS', $search)
                    ->orLike('UTILISATEUR.TELEPHONE', $search)
                    ->orLike("CONCAT(UTILISATEUR.NOM, ' ', UTILISATEUR.PRENOMS)", $search)
                    ->orLike("CONCAT(UTILISATEUR.PRENOMS, ' ', UTILISATEUR.NOM)", $search)
                    ->groupEnd();
        }

        if (!empty($filtreProfil)) {
            $builder->where('UTILISATEUR.PROFIL', $filtreProfil);
        }
        if (!empty($filtreCentre) && $profilConnecte !== 'GESTIONNAIRE_CENTRE') {
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
            'profilConnecte'  => $profilConnecte,
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

        $profilConnecte = $session->get('profil');
        $db = \Config\Database::connect();
        
        // Récupération uniquement des directions actives (STATUT = 1)
        $directions = $db->table('DIRECTION')
                         ->where('STATUT', 1)
                         ->get()
                         ->getResultArray();
        
        // Récupération uniquement des centres actifs (STATUT = 1)
        $centres = $db->table('CENTRE')
                      ->where('STATUT', 1)
                      ->get()
                      ->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'profilConnecte' => $profilConnecte,
            'centreConnecte' => $session->get('codecentre'),
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

        $profilConnecte = $session->get('profil');
        $userModel = new UtilisateurModel();

        $rawIm     = trim($this->request->getPost('immutilisateur'));
        $nom       = trim($this->request->getPost('nom'));
        $prenoms   = trim($this->request->getPost('prenoms'));
        $email     = trim($this->request->getPost('email'));
        $telephone = trim($this->request->getPost('telephone'));
        $profil    = $this->request->getPost('profil');

        // Validation stricte de la hiérarchie des créations de comptes selon le rôle connecté
        $autorise = false;
        if ($profilConnecte === 'ADMIN' && in_array($profil, ['GESTIONNAIRE_CENTRAL', 'GESTIONNAIRE_CENTRE'])) {
            $autorise = true;
        } elseif ($profilConnecte === 'GESTIONNAIRE_CENTRAL' && $profil === 'GESTIONNAIRE_CENTRE') {
            $autorise = true;
        } elseif ($profilConnecte === 'GESTIONNAIRE_CENTRE' && $profil === 'RESPONSABLE_CENTRE') {
            $autorise = true;
        }

        if (!$autorise) {
            return redirect()->back()->withInput()->with('error', 'Vous n\'avez pas les droits nécessaires pour créer un utilisateur avec ce rôle.');
        }
        
        // Validation stricte de l'IM (exactement 6 chiffres collés)
        $chiffresIm = preg_replace('/\D/', '', $rawIm);
        if (strlen($chiffresIm) !== 6) {
            return redirect()->back()->withInput()->with('error', 'Le matricule (IM) doit comporter exactement 6 chiffres.');
        }
        $imFinal = $chiffresIm; // Stocké sans espace pour faciliter le login (ex: 001007)

        // Unicité de l'IM
        if ($userModel->find($imFinal)) {
            return redirect()->back()->withInput()->with('error', 'Cet IM (' . $imFinal . ') est déjà attribué à un autre utilisateur.');
        }

        // Validation et normalisation sécurisée du téléphone (+261)
        $telephoneNormalise = null;
        if (!empty($telephone)) {
            $telephoneNettoye = preg_replace('/\s+/', '', $telephone);

            if (preg_match('/^(32|33|34|37|38)\d{7}$/', $telephoneNettoye)) {
                $telephoneNormalise = '+261' . $telephoneNettoye;
            } elseif (preg_match('/^\+261(32|33|34|37|38)\d{7}$/', $telephoneNettoye)) {
                $telephoneNormalise = $telephoneNettoye;
            }

            if (!$telephoneNormalise || !preg_match('/^\+261(32|33|34|37|38)\d{7}$/', $telephoneNormalise)) {
                return redirect()->back()->withInput()->with('error', 'Le numéro de téléphone est invalide. Format attendu : 34 XX XXX XX.');
            }

            // Unicité du téléphone
            if ($userModel->where('TELEPHONE', $telephoneNormalise)->first()) {
                return redirect()->back()->withInput()->with('error', 'Ce numéro de téléphone est déjà utilisé par un autre compte.');
            }
        }

        // Unicité de l'e-mail
        if (!empty($email) && $userModel->where('EMAIL', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Cette adresse e-mail est déjà utilisée par un autre compte.');
        }

        $codedirection = null;
        $codecentre    = null;

        if ($profil === 'GESTIONNAIRE_CENTRAL') {
            $codedirection = $this->request->getPost('codedirection') ?: null;
        } else {
            if ($profilConnecte === 'GESTIONNAIRE_CENTRE') {
                $codecentre = $session->get('codecentre');
            } else {
                $codecentre = $this->request->getPost('codecentre') ?: null;
            }
        }

        $tempPassword = '12345678';
        
        // else {
        //     $codecentre = $this->request->getPost('codecentre') ?: null;
        // }

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
            'TELEPHONE'          => $telephoneNormalise,
            'CODEDIRECTION'      => $codedirection,
            'CODECENTRE'         => $codecentre,
            'EMAIL'              => $email,
            'PROFIL'             => $profil,
            'MOTDEPASSE'         => password_hash($defaultPassword, PASSWORD_BCRYPT),
            'ACTIF'              => 1,
            'PREMIERE_CONNEXION' => 1
        ];

        $userModel->insert($data);

        enregistrer_log($session->get('immutilisateur'), "Création du compte utilisateur : " . $imFinal . " (" . $nom . " " . $prenoms . ")");

        if (!empty($email)) {
            $emailService = \Config\Services::email();
            $emailService->setTo($email);
            $emailService->setSubject('INFP Madagascar — Création de votre compte utilisateur');
            
            $message = "Bonjour " . esc($prenoms) . " " . esc($nom) . ",\n\n";
            $message .= "Votre compte utilisateur a été créé avec succès sur la plateforme INFP Madagascar.\n";
            $message .= "Votre identifiant de connexion (Matricule IM) est : " . $imFinal . "\n\n";
            $message .= "Lors de votre première connexion, il vous sera demandé de modifier votre mot de passe provisoire.\n\n";
            $message .= "Cordialement,\nL'Administration Technique - INFP Madagascar";

            $emailService->setMessage($message);
            @$emailService->send();
        return redirect()->to('/utilisateurs')->with('success', 'Compte créé avec succès.');
     }
    }


    public function edit($im)
{
    $session = session();
    if (!$session->get('logged_in')) {
        return redirect()->to('/login');
    }

    $userModel = new UtilisateurModel();
    $imDecoded = urldecode($im);
    $user = $userModel->find($imDecoded);

    if (!$user) {
        return redirect()->to('/utilisateurs')->with('error', 'Utilisateur introuvable.');
    }

    // Transmettre les données de l'utilisateur à la vue d'édition
    return view('admin/users/edit', ['user' => $user]);
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
            
            $statusLabel = $newStatus ? 'Activation' : 'Désactivation';
            enregistrer_log($session->get('immutilisateur'), "$statusLabel du compte utilisateur : " . $imDecoded);

            return redirect()->to('/utilisateurs')->with('success', 'Statut du compte mis à jour avec succès.');
        }

        return redirect()->to('/utilisateurs')->with('error', 'Utilisateur introuvable.');
    }
}
<?php

namespace App\Controllers\GestionnaireCentre;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class ResponsableController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        $db = \Config\Database::connect();
        $search = trim($this->request->getGet('search') ?? '');

        $builder = $db->table('UTILISATEUR');
        $builder->select('UTILISATEUR.*, CENTRE.NOMCENTRE');
        $builder->join('CENTRE', 'CENTRE.CODECENTRE = UTILISATEUR.CODECENTRE', 'left');
        
        // Restriction stricte au centre du gestionnaire et au profil responsable
        $builder->where('UTILISATEUR.PROFIL', 'RESPONSABLE_CENTRE');
        if ($codeCentre) {
            $builder->where('UTILISATEUR.CODECENTRE', $codeCentre);
        }

        // Recherche multicritère : IM, Nom, Prénom, Email
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('UTILISATEUR.IMMUTILISATEUR', $search)
                    ->orLike('UTILISATEUR.NOM', $search)
                    ->orLike('UTILISATEUR.PRENOMS', $search)
                    ->orLike('UTILISATEUR.EMAIL', $search)
                    ->orLike("CONCAT(UTILISATEUR.NOM, ' ', UTILISATEUR.PRENOMS)", $search)
                    ->orLike("CONCAT(UTILISATEUR.PRENOMS, ' ', UTILISATEUR.NOM)", $search)
                    ->groupEnd();
        }

        $builder->orderBy('UTILISATEUR.IMMUTILISATEUR', 'DESC');
        $responsables = $builder->get()->getResultArray();

        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'responsables'   => $responsables,
            'centre'         => $centre,
            'search'         => $search
        ];

        return view('gestionnaire/gestionnaire_centre/responsables/index', $data);
    }

    public function create()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        $db = \Config\Database::connect();
        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'centre'         => $centre
        ];

        return view('gestionnaire/gestionnaire_centre/responsables/create', $data);
    }

    public function store()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        if (!$codeCentre) {
            return redirect()->back()->withInput()->with('error', 'Aucun centre n\'est rattaché à votre compte gestionnaire.');
        }

        $rawIm   = trim($this->request->getPost('immutilisateur'));
        $nom     = trim($this->request->getPost('nom'));
        $prenoms = trim($this->request->getPost('prenoms'));
        $email   = trim($this->request->getPost('email'));

        $chiffres = preg_replace('/\D/', '', $rawIm);

        if (strlen($chiffres) !== 6) {
            return redirect()->back()->withInput()->with('error', 'Le matricule (IM) doit comporter exactement 6 chiffres.');
        }

        $imFinal = substr($chiffres, 0, 3) . ' ' . substr($chiffres, 3, 3) . '-R';

        if ($userModel->find($imFinal)) {
            return redirect()->back()->withInput()->with('error', 'Ce matricule (IM) existe déjà dans la base.');
        }

        if (!empty($email) && $userModel->where('EMAIL', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Cette adresse e-mail est déjà utilisée par un autre compte.');
        }

        $defaultPassword = '1234';

        $data = [
            'IMMUTILISATEUR'     => $imFinal,
            'NOM'                => $nom,
            'PRENOMS'            => $prenoms,
            'CODEDIRECTION'      => null,
            'CODECENTRE'         => $codeCentre,
            'EMAIL'              => $email,
            'PROFIL'             => 'RESPONSABLE_CENTRE',
            'MOTDEPASSE'         => password_hash($defaultPassword, PASSWORD_BCRYPT),
            'ACTIF'              => 1,
            'PREMIERE_CONNEXION' => 1
        ];

        $userModel->insert($data);

        if (function_exists('enregistrer_log')) {
            enregistrer_log($session->get('immutilisateur'), "Création du compte responsable de centre : " . $imFinal . " (" . $nom . " " . $prenoms . ")");
        }

        return redirect()->to('/gestionnaire/responsables')->with('success', 'Compte responsable créé avec succès.');
    }

    public function toggleStatus($im)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        $imDecoded = urldecode($im);
        $user = $userModel->where('IMMUTILISATEUR', $imDecoded)
                          ->where('PROFIL', 'RESPONSABLE_CENTRE')
                          ->where('CODECENTRE', $codeCentre)
                          ->first();

        if ($user) {
            $newStatus = $user['ACTIF'] ? 0 : 1;
            $userModel->update($imDecoded, ['ACTIF' => $newStatus]);
            
            $statusLabel = $newStatus ? 'Activation' : 'Désactivation';
            if (function_exists('enregistrer_log')) {
                enregistrer_log($session->get('immutilisateur'), "$statusLabel du compte responsable : " . $imDecoded);
            }

            return redirect()->to('/gestionnaire/responsables')->with('success', 'Statut du responsable mis à jour.');
        }

        return redirect()->to('/gestionnaire/responsables')->with('error', 'Responsable introuvable ou non autorisé.');
    }

    public function delete($im)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        $imDecoded = urldecode($im);
        $user = $userModel->where('IMMUTILISATEUR', $imDecoded)
                          ->where('PROFIL', 'RESPONSABLE_CENTRE')
                          ->where('CODECENTRE', $codeCentre)
                          ->first();

        if ($user) {
            $userModel->delete($imDecoded);

            if (function_exists('enregistrer_log')) {
                enregistrer_log($session->get('immutilisateur'), "Suppression du compte responsable : " . $imDecoded);
            }

            return redirect()->to('/gestionnaire/responsables')->with('success', 'Compte responsable supprimé avec succès.');
        }

        return redirect()->to('/gestionnaire/responsables')->with('error', 'Responsable introuvable ou non autorisé.');
    }
}
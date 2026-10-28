<?php

namespace App\Controllers\GestionnaireCentre;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class EleveCentreController extends BaseController
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

        $builder = $db->table('ELEVEMAITRE');
        $builder->select('ELEVEMAITRE.*, CLASSE.NOMCLASSE, CENTRE.NOMCENTRE');
        $builder->join('CLASSE', 'CLASSE.CODECLASSE = ELEVEMAITRE.CODECLASSE');
        $builder->join('CENTRE', 'CENTRE.CODECENTRE = CLASSE.CODECENTRE');
        
        // Restriction stricte au centre du gestionnaire connecté
        if ($codeCentre) {
            $builder->where('CLASSE.CODECENTRE', $codeCentre);
        }

        // Recherche multicritère : Matricule, Nom, Prénom, N° CIN ou Téléphone
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('ELEVEMAITRE.MATRICULEELEVE', $search)
                    ->orLike('ELEVEMAITRE.NOMELEVE', $search)
                    ->orLike('ELEVEMAITRE.PRENOMELEVE', $search)
                    ->orLike('ELEVEMAITRE.NUMCINELEVE', $search)
                    ->orLike('ELEVEMAITRE.TELEPHONEELEVE', $search)
                    ->orLike("CONCAT(ELEVEMAITRE.NOMELEVE, ' ', ELEVEMAITRE.PRENOMELEVE)", $search)
                    ->orLike("CONCAT(ELEVEMAITRE.PRENOMELEVE, ' ', ELEVEMAITRE.NOMELEVE)", $search)
                    ->groupEnd();
        }

        $builder->orderBy('ELEVEMAITRE.MATRICULEELEVE', 'DESC');
        $eleves = $builder->get()->getResultArray();

        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'eleves'         => $eleves,
            'centre'         => $centre,
            'search'         => $search
        ];

        return view('gestionnaire/gestionnaire_centre/eleves/index', $data);
    }

    public function create()
    {
        $session = session();
        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        $db = \Config\Database::connect();
        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;
        
        // Récupérer uniquement les classes du centre pour l'affectation
        $classes = $codeCentre ? $db->table('CLASSE')->where('CODECENTRE', $codeCentre)->get()->getResultArray() : [];

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'centre'         => $centre,
            'classes'        => $classes
        ];

        return view('gestionnaire/gestionnaire_centre/eleves/create', $data);
    }

    public function store()
    {
        $session = session();
        $db = \Config\Database::connect();

        $matricule   = trim($this->request->getPost('matriculeeleve'));
        $codeClasse  = trim($this->request->getPost('codeclasse'));
        $numCin      = trim($this->request->getPost('numcineleve'));
        $nom         = trim($this->request->getPost('nomeleve'));
        $prenoms     = trim($this->request->getPost('prenomeleve'));
        $dateNais    = trim($this->request->getPost('datenaissance'));
        $lieuNais    = trim($this->request->getPost('lieunaissance'));
        $sexe        = trim($this->request->getPost('sexe'));
        $nationalite = trim($this->request->getPost('nationalite') ?: 'Malagasy');
        $bachelier   = $this->request->getPost('est_bachelier') ? 1 : 0;
        $adresse     = trim($this->request->getPost('adresseeleve'));
        $telephone   = trim($this->request->getPost('telephoneeleve'));

        // 1. VÉRIFICATION DE L'ÂGE (>= 18 ans)
        if (!empty($dateNais)) {
            $birthDate = new \DateTime($dateNais);
            $today = new \DateTime('today');
            $age = $birthDate->diff($today)->y;

            if ($age < 18) {
                return redirect()->back()->withInput()->with('error', 'L\'élève doit avoir au moins 18 ans pour être enregistré.');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'La date de naissance est obligatoire.');
        }

        // 2. VÉRIFICATION UNICITÉ DU MATRICULE ÉLÈVE
        if ($db->table('ELEVEMAITRE')->where('MATRICULEELEVE', $matricule)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('error', 'Ce matricule élève existe déjà.');
        }

        // 3. VÉRIFICATION UNICITÉ DU CIN ENTRE ÉLÈVES
        if ($db->table('ELEVEMAITRE')->where('NUMCINELEVE', $numCin)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('error', 'Ce numéro CIN / Pièce existe déjà pour un autre élève.');
        }

        // 4. VÉRIFICATION : Le CIN de l'élève ne doit pas appartenir à un Formateur
        if ($db->table('FORMATEUR')->where('NUMCINFORM', $numCin)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('error', 'Erreur : Ce numéro CIN est déjà utilisé par un formateur.');
        }

        $data = [
            'MATRICULEELEVE'  => $matricule,
            'CODECLASSE'      => $codeClasse,
            'NUMCINELEVE'     => $numCin,
            'NOMELEVE'        => $nom,
            'PRENOMELEVE'     => $prenoms,
            'DATENAISSANCE'   => $dateNais ?: null,
            'LIEUNAISSANCE'   => $lieuNais,
            'SEXE'            => $sexe,
            'NATIONALITE'     => $nationalite,
            'EST_BACHELIER'   => $bachelier,
            'ADRESSEELEVE'    => $adresse,
            'TELEPHONEELEVE'  => $telephone,
            'STATUTEXAMEN'    => 'Autorisé',
            'STATUTFINAL'     => 'En cours',
            'CUMULABSENCE'    => 0.00
        ];

        $db->table('ELEVEMAITRE')->insert($data);

        if (function_exists('enregistrer_log')) {
            enregistrer_log($session->get('immutilisateur'), "Création de l'élève : " . $matricule . " (" . $nom . " " . $prenoms . ")");
        }

        return redirect()->to('/gestionnaire/eleves')->with('success', 'Élève enregistré avec succès.');
    }

    public function edit($matricule)
    {
        $session = session();
        $db = \Config\Database::connect();
        
        $matDecoded = urldecode($matricule);
        $eleve = $db->table('ELEVEMAITRE')->where('MATRICULEELEVE', $matDecoded)->get()->getRowArray();

        if (!$eleve) {
            return redirect()->to('/gestionnaire/eleves')->with('error', 'Élève introuvable.');
        }

        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;
        $classes = $codeCentre ? $db->table('CLASSE')->where('CODECENTRE', $codeCentre)->get()->getResultArray() : [];

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'eleve'          => $eleve,
            'centre'         => $centre,
            'classes'        => $classes
        ];

        return view('gestionnaire/gestionnaire_centre/eleves/edit', $data);
    }

    public function update($matricule)
    {
        $session = session();
        $db = \Config\Database::connect();
        $matDecoded = urldecode($matricule);

        $codeClasse  = trim($this->request->getPost('codeclasse'));
        $numCin      = trim($this->request->getPost('numcineleve'));
        $nom         = trim($this->request->getPost('nomeleve'));
        $prenoms     = trim($this->request->getPost('prenomeleve'));
        $dateNais    = trim($this->request->getPost('datenaissance'));
        $lieuNais    = trim($this->request->getPost('lieunaissance'));
        $sexe        = trim($this->request->getPost('sexe'));
        $nationalite = trim($this->request->getPost('nationalite'));
        $bachelier   = $this->request->getPost('est_bachelier') ? 1 : 0;
        $adresse     = trim($this->request->getPost('adresseeleve'));
        $telephone   = trim($this->request->getPost('telephoneeleve'));
        $statutEx    = trim($this->request->getPost('statutexamen'));
        $statutFin   = trim($this->request->getPost('statutfinal'));

        // 1. VÉRIFICATION DE L'ÂGE (>= 18 ans)
        if (!empty($dateNais)) {
            $birthDate = new \DateTime($dateNais);
            $today = new \DateTime('today');
            $age = $birthDate->diff($today)->y;

            if ($age < 18) {
                return redirect()->back()->withInput()->with('error', 'L\'élève doit avoir au moins 18 ans.');
            }
        }

        // 2. VÉRIFICATION UNICITÉ DU CIN AVEC UN AUTRE ÉLÈVE (excluant l'élève actuel)
        $existeAutreEleve = $db->table('ELEVEMAITRE')
                               ->where('NUMCINELEVE', $numCin)
                               ->where('MATRICULEELEVE !=', $matDecoded)
                               ->countAllResults();
        if ($existeAutreEleve > 0) {
            return redirect()->back()->withInput()->with('error', 'Ce numéro CIN est déjà attribué à un autre élève.');
        }

        // 3. VÉRIFICATION : Le CIN modifié ne doit pas appartenir à un Formateur
        if ($db->table('FORMATEUR')->where('NUMCINFORM', $numCin)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('error', 'Erreur : Ce numéro CIN est déjà enregistré pour un formateur.');
        }

        $data = [
            'CODECLASSE'      => $codeClasse,
            'NUMCINELEVE'     => $numCin,
            'NOMELEVE'        => $nom,
            'PRENOMELEVE'     => $prenoms,
            'DATENAISSANCE'   => $dateNais ?: null,
            'LIEUNAISSANCE'   => $lieuNais,
            'SEXE'            => $sexe,
            'NATIONALITE'     => $nationalite,
            'EST_BACHELIER'   => $bachelier,
            'ADRESSEELEVE'    => $adresse,
            'TELEPHONEELEVE'  => $telephone,
            'STATUTEXAMEN'    => $statutEx,
            'STATUTFINAL'     => $statutFin
        ];

        $db->table('ELEVEMAITRE')->where('MATRICULEELEVE', $matDecoded)->update($data);

        if (function_exists('enregistrer_log')) {
            enregistrer_log($session->get('immutilisateur'), "Modification de l'élève : " . $matDecoded);
        }

        return redirect()->to('/gestionnaire/eleves')->with('success', 'Informations de l\'élève mises à jour avec succès.');
    }

    public function delete($matricule)
    {
        $session = session();
        $db = \Config\Database::connect();
        $matDecoded = urldecode($matricule);

        $eleve = $db->table('ELEVEMAITRE')->where('MATRICULEELEVE', $matDecoded)->get()->getRowArray();

        if ($eleve) {
            $db->table('ELEVEMAITRE')->where('MATRICULEELEVE', $matDecoded)->delete();

            if (function_exists('enregistrer_log')) {
                enregistrer_log($session->get('immutilisateur'), "Suppression de l'élève : " . $matDecoded);
            }

            return redirect()->to('/gestionnaire/eleves')->with('success', 'Élève supprimé avec succès.');
        }

        return redirect()->to('/gestionnaire/eleves')->with('error', 'Élève introuvable.');
    }
}
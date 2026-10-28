<?php

namespace App\Controllers\GestionnaireCentre;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class SeanceController extends BaseController
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
        
        // Récupération des filtres GET
        $search = trim($this->request->getGet('search') ?? '');
        $filtreClasse = trim($this->request->getGet('classe') ?? '');
        $filtreDate = trim($this->request->getGet('date') ?? '');

        $builder = $db->table('SEANCE');
        $builder->select('SEANCE.*, CLASSE.NOMCLASSE, ELEMCONST.NOMEC, FORMATEUR.NOMFORMATEUR, FORMATEUR.PRENOMFORMATEUR, CENTRE.NOMCENTRE');
        $builder->join('CLASSE', 'CLASSE.CODECLASSE = SEANCE.CODECLASSE');
        $builder->join('CENTRE', 'CENTRE.CODECENTRE = CLASSE.CODECENTRE');
        $builder->join('ELEMCONST', 'ELEMCONST.CODEEC = SEANCE.CODEEC', 'left');
        $builder->join('FORMATEUR', 'FORMATEUR.NUMCINFORM = SEANCE.NUMCINFORM', 'left');
        
        // Restriction stricte au centre du gestionnaire connecté
        if ($codeCentre) {
            $builder->where('CLASSE.CODECENTRE', $codeCentre);
        }

        // Filtre par Classe spécifique (select)
        if (!empty($filtreClasse)) {
            $builder->where('SEANCE.CODECLASSE', $filtreClasse);
        }

        // Filtre par Date spécifique (input date)
        if (!empty($filtreDate)) {
            $builder->where('SEANCE.DATESEANCE', $filtreDate);
        }

        // Recherche multicritère globale (texte libre)
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('CLASSE.NOMCLASSE', $search)
                    ->orLike('ELEMCONST.NOMEC', $search)
                    ->orLike('FORMATEUR.NOMFORMATEUR', $search)
                    ->orLike('FORMATEUR.PRENOMFORMATEUR', $search)
                    ->orLike('SEANCE.DATESEANCE', $search)
                    ->groupEnd();
        }

        $builder->orderBy('SEANCE.DATESEANCE', 'DESC');
        $builder->orderBy('SEANCE.HEUREDEBUT', 'ASC');
        $seances = $builder->get()->getResultArray();

        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;
        
        // Récupérer la liste des classes du centre pour alimenter le filtre déroulant
        $classes = $codeCentre ? $db->table('CLASSE')->where('CODECENTRE', $codeCentre)->get()->getResultArray() : [];

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'seances'        => $seances,
            'centre'         => $centre,
            'classes'        => $classes,
            'search'         => $search,
            'filtreClasse'   => $filtreClasse,
            'filtreDate'     => $filtreDate
        ];

        return view('gestionnaire/gestionnaire_centre/seances/index', $data);
    }

    public function create()
    {
        $session = session();
        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        $db = \Config\Database::connect();
        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;
        
        $classes = $codeCentre ? $db->table('CLASSE')->where('CODECENTRE', $codeCentre)->get()->getResultArray() : [];
        $elemconsts = $db->table('ELEMCONST')->get()->getResultArray();
        $formateurs = $codeCentre ? $db->table('FORMATEUR')->where('CODECENTRE', $codeCentre)->get()->getResultArray() : [];

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'centre'         => $centre,
            'classes'        => $classes,
            'elemconsts'     => $elemconsts,
            'formateurs'     => $formateurs
        ];

        return view('gestionnaire/gestionnaire_centre/seances/create', $data);
    }

    public function store()
    {
        $session = session();
        $db = \Config\Database::connect();

        $codeClasse  = trim($this->request->getPost('codeclasse'));
        $codeEc      = trim($this->request->getPost('codeec'));
        $numCinForm  = trim($this->request->getPost('numcinform'));
        $dateSeance  = trim($this->request->getPost('dateseance'));
        $heureDebut  = trim($this->request->getPost('heuredebut'));
        $heureFin    = trim($this->request->getPost('heurefin'));

        if (empty($codeClasse) || empty($codeEc) || empty($numCinForm) || empty($dateSeance) || empty($heureDebut) || empty($heureFin)) {
            return redirect()->back()->withInput()->with('error', 'Tous les champs obligatoires doivent être remplis.');
        }

        if ($heureDebut >= $heureFin) {
            return redirect()->back()->withInput()->with('error', 'L\'heure de début doit être antérieure à l\'heure de fin.');
        }

        $data = [
            'CODECLASSE' => $codeClasse,
            'CODEEC'     => $codeEc,
            'NUMCINFORM' => $numCinForm,
            'DATESEANCE' => $dateSeance,
            'HEUREDEBUT' => $heureDebut,
            'HEUREFIN'   => $heureFin
        ];

        $db->table('SEANCE')->insert($data);

        if (function_exists('enregistrer_log')) {
            enregistrer_log($session->get('immutilisateur'), "Planification d'une séance pour la classe : " . $codeClasse);
        }

        return redirect()->to('/gestionnaire/seances')->with('success', 'Séance planifiée avec succès.');
    }

    public function edit($id)
    {
        $session = session();
        $db = \Config\Database::connect();
        
        $numSeance = intval($id);
        $seance = $db->table('SEANCE')->where('NUMSEANCE', $numSeance)->get()->getRowArray();

        if (!$seance) {
            return redirect()->to('/gestionnaire/seances')->with('error', 'Séance introuvable.');
        }

        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;
        $classes = $codeCentre ? $db->table('CLASSE')->where('CODECENTRE', $codeCentre)->get()->getResultArray() : [];
        $elemconsts = $db->table('ELEMCONST')->get()->getResultArray();
        $formateurs = $codeCentre ? $db->table('FORMATEUR')->where('CODECENTRE', $codeCentre)->get()->getResultArray() : [];

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'seance'         => $seance,
            'centre'         => $centre,
            'classes'        => $classes,
            'elemconsts'     => $elemconsts,
            'formateurs'     => $formateurs
        ];

        return view('gestionnaire/gestionnaire_centre/seances/edit', $data);
    }

    public function update($id)
    {
        $session = session();
        $db = \Config\Database::connect();
        $numSeance = intval($id);

        $codeClasse  = trim($this->request->getPost('codeclasse'));
        $codeEc      = trim($this->request->getPost('codeec'));
        $numCinForm  = trim($this->request->getPost('numcinform'));
        $dateSeance  = trim($this->request->getPost('dateseance'));
        $heureDebut  = trim($this->request->getPost('heuredebut'));
        $heureFin    = trim($this->request->getPost('heurefin'));

        if ($heureDebut >= $heureFin) {
            return redirect()->back()->withInput()->with('error', 'L\'heure de début doit être antérieure à l\'heure de fin.');
        }

        $data = [
            'CODECLASSE' => $codeClasse,
            'CODEEC'     => $codeEc,
            'NUMCINFORM' => $numCinForm,
            'DATESEANCE' => $dateSeance,
            'HEUREDEBUT' => $heureDebut,
            'HEUREFIN'   => $heureFin
        ];

        $db->table('SEANCE')->where('NUMSEANCE', $numSeance)->update($data);

        if (function_exists('enregistrer_log')) {
            enregistrer_log($session->get('immutilisateur'), "Modification de la séance N° " . $numSeance);
        }

        return redirect()->to('/gestionnaire/seances')->with('success', 'Séance mise à jour avec succès.');
    }

    public function delete($id)
    {
        $session = session();
        $db = \Config\Database::connect();
        
        $numSeance = intval($id);
        $seance = $db->table('SEANCE')->where('NUMSEANCE', $numSeance)->get()->getRowArray();

        if ($seance) {
            $db->table('SEANCE')->where('NUMSEANCE', $numSeance)->delete();

            if (function_exists('enregistrer_log')) {
                enregistrer_log($session->get('immutilisateur'), "Suppression de la séance N° " . $numSeance);
            }

            return redirect()->to('/gestionnaire/seances')->with('success', 'Séance supprimée avec succès.');
        }

        return redirect()->to('/gestionnaire/seances')->with('error', 'Séance introuvable.');
    }
}
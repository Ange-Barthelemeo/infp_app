<?php

namespace App\Controllers\GestionnaireCentre;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class NoteCentreController extends BaseController
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
        $filtreClasse = trim($this->request->getGet('classe') ?? '');

        // Récupération des notes et des élèves du centre
        $builder = $db->table('AVOIRNOTE');
        $builder->select('AVOIRNOTE.*, ELEVEMAITRE.NOMELEVE, ELEVEMAITRE.PRENOMELEVE, ELEVEMAITRE.STATUTFINAL, ELEVEMAITRE.STATUTEXAMEN, CLASSE.NOMCLASSE, ELEMCONST.NOMEC');
        $builder->join('ELEVEMAITRE', 'ELEVEMAITRE.MATRICULEELEVE = AVOIRNOTE.MATRICULEELEVE');
        $builder->join('CLASSE', 'CLASSE.CODECLASSE = ELEVEMAITRE.CODECLASSE');
        $builder->join('CENTRE', 'CENTRE.CODECENTRE = CLASSE.CODECENTRE');
        $builder->join('ELEMCONST', 'ELEMCONST.CODEEC = AVOIRNOTE.CODEEC');

        if ($codeCentre) {
            $builder->where('CLASSE.CODECENTRE', $codeCentre);
        }

        if (!empty($filtreClasse)) {
            $builder->where('CLASSE.CODECLASSE', $filtreClasse);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('ELEVEMAITRE.MATRICULEELEVE', $search)
                    ->orLike('ELEVEMAITRE.NOMELEVE', $search)
                    ->orLike('ELEVEMAITRE.PRENOMELEVE', $search)
                    ->orLike('ELEMCONST.NOMEC', $search)
                    ->groupEnd();
        }

        $builder->orderBy('ELEVEMAITRE.MATRICULEELEVE', 'DESC');
        $notes = $builder->get()->getResultArray();

        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;
        $classes = $codeCentre ? $db->table('CLASSE')->where('CODECENTRE', $codeCentre)->get()->getResultArray() : [];

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'notes'          => $notes,
            'centre'         => $centre,
            'classes'        => $classes,
            'search'         => $search,
            'filtreClasse'   => $filtreClasse
        ];

        return view('gestionnaire/gestionnaire_centre/notes/index', $data);
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
        $eleves = $codeCentre ? $db->table('ELEVEMAITRE')
                                   ->select('ELEVEMAITRE.MATRICULEELEVE, ELEVEMAITRE.NOMELEVE, ELEVEMAITRE.PRENOMELEVE, CLASSE.NOMCLASSE')
                                   ->join('CLASSE', 'CLASSE.CODECLASSE = ELEVEMAITRE.CODECLASSE')
                                   ->where('CLASSE.CODECENTRE', $codeCentre)
                                   ->get()->getResultArray() : [];
        $elemconsts = $db->table('ELEMCONST')->get()->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'centre'         => $centre,
            'classes'        => $classes,
            'eleves'         => $eleves,
            'elemconsts'     => $elemconsts
        ];

        return view('gestionnaire/gestionnaire_centre/notes/create', $data);
    }

    public function store()
    {
        $session = session();
        $db = \Config\Database::connect();

        $matricule = trim($this->request->getPost('matriculeeleve'));
        $codeEc    = trim($this->request->getPost('codeec'));
        $valeur    = trim($this->request->getPost('valeurnote'));

        if (empty($matricule) || empty($codeEc) || $valeur === '') {
            return redirect()->back()->withInput()->with('error', 'Tous les champs sont obligatoires.');
        }

        if ($valeur < 0 || $valeur > 20) {
            return redirect()->back()->withInput()->with('error', 'La note doit être comprise entre 0 et 20.');
        }

        // Vérifier si la note existe déjà pour cet élève et cet EC
        $existe = $db->table('AVOIRNOTE')->where(['MATRICULEELEVE' => $matricule, 'CODEEC' => $codeEc])->get()->getRowArray();

        if ($existe) {
            $db->table('AVOIRNOTE')->where(['MATRICULEELEVE' => $matricule, 'CODEEC' => $codeEc])->update(['VALEURNOTE' => $valeur]);
        } else {
            $db->table('AVOIRNOTE')->insert([
                'MATRICULEELEVE' => $matricule,
                'CODEEC'         => $codeEc,
                'VALEURNOTE'     => $valeur
            ]);
        }

        if (function_exists('enregistrer_log')) {
            enregistrer_log($session->get('immutilisateur'), "Attribution/Modification de note pour l'élève : " . $matricule);
        }

        return redirect()->to('/gestionnaire/notes')->with('success', 'Note enregistrée avec succès.');
    }

    public function edit($matricule, $codeec)
    {
        $session = session();
        $db = \Config\Database::connect();
        
        $matDecoded = urldecode($matricule);
        $ecDecoded = urldecode($codeec);

        $note = $db->table('AVOIRNOTE')->where(['MATRICULEELEVE' => $matDecoded, 'CODEEC' => $ecDecoded])->get()->getRowArray();

        if (!$note) {
            return redirect()->to('/gestionnaire/notes')->with('error', 'Note introuvable.');
        }

        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;
        $eleve = $db->table('ELEVEMAITRE')->where('MATRICULEELEVE', $matDecoded)->get()->getRowArray();
        $ec = $db->table('ELEMCONST')->where('CODEEC', $ecDecoded)->get()->getRowArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'note'           => $note,
            'eleve'          => $eleve,
            'ec'             => $ec,
            'centre'         => $centre
        ];

        return view('gestionnaire/gestionnaire_centre/notes/edit', $data);
    }

    public function update($matricule, $codeec)
    {
        $session = session();
        $db = \Config\Database::connect();
        
        $matDecoded = urldecode($matricule);
        $ecDecoded = urldecode($codeec);
        $valeur = trim($this->request->getPost('valeurnote'));

        if ($valeur === '' || $valeur < 0 || $valeur > 20) {
            return redirect()->back()->withInput()->with('error', 'Veuillez saisir une note valide entre 0 et 20.');
        }

        $db->table('AVOIRNOTE')->where(['MATRICULEELEVE' => $matDecoded, 'CODEEC' => $ecDecoded])->update(['VALEURNOTE' => $valeur]);

        if (function_exists('enregistrer_log')) {
            enregistrer_log($session->get('immutilisateur'), "Mise à jour de la note de l'élève : " . $matDecoded);
        }

        return redirect()->to('/gestionnaire/notes')->with('success', 'Note mise à jour avec succès.');
    }

    public function delete($matricule, $codeec)
    {
        $db = \Config\Database::connect();
        $db->table('AVOIRNOTE')->where(['MATRICULEELEVE' => urldecode($matricule), 'CODEEC' => urldecode($codeec)])->delete();

        return redirect()->to('/gestionnaire/notes')->with('success', 'Note supprimée avec succès.');
    }
    public function admis()
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
        $filtreStatut = trim($this->request->getGet('statut') ?? '');
        $filtreClasse = trim($this->request->getGet('classe') ?? '');

        $builder = $db->table('ELEVEMAITRE');
        $builder->select('ELEVEMAITRE.*, CLASSE.NOMCLASSE, CENTRE.NOMCENTRE');
        $builder->join('CLASSE', 'CLASSE.CODECLASSE = ELEVEMAITRE.CODECLASSE');
        $builder->join('CENTRE', 'CENTRE.CODECENTRE = CLASSE.CODECENTRE');

        if ($codeCentre) {
            $builder->where('CLASSE.CODECENTRE', $codeCentre);
        }

        // Filtre par statut (Admis, Non Admis, En cours)
        if (!empty($filtreStatut)) {
            $builder->where('ELEVEMAITRE.STATUTFINAL', $filtreStatut);
        }

        // Filtre par classe
        if (!empty($filtreClasse)) {
            $builder->where('ELEVEMAITRE.CODECLASSE', $filtreClasse);
        }

        // Recherche multicritère
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('ELEVEMAITRE.MATRICULEELEVE', $search)
                    ->orLike('ELEVEMAITRE.NOMELEVE', $search)
                    ->orLike('ELEVEMAITRE.PRENOMELEVE', $search)
                    ->orLike('ELEVEMAITRE.NUMCINELEVE', $search)
                    ->groupEnd();
        }

        $builder->orderBy('ELEVEMAITRE.NOMELEVE', 'ASC');
        $eleves = $builder->get()->getResultArray();

        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;
        $classes = $codeCentre ? $db->table('CLASSE')->where('CODECENTRE', $codeCentre)->get()->getResultArray() : [];

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'eleves'         => $eleves,
            'centre'         => $centre,
            'classes'        => $classes,
            'search'         => $search,
            'filtreStatut'   => $filtreStatut,
            'filtreClasse'   => $filtreClasse
        ];

        return view('gestionnaire/gestionnaire_centre/notes/admis', $data);
    }
}
<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CentreController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        
        // Récupérer la liste des centres
        $centres = $db->table('CENTRE')->get()->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'centres'        => $centres
        ];

        return view('gestionnaire/centres/index', $data);
    }

    public function create()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $sectionsDisponibles = $db->table('SECTION')->get()->getResultArray();

        $data = [
            'immutilisateur'      => $session->get('immutilisateur'),
            'nom'                 => $session->get('nom'),
            'prenoms'             => $session->get('prenoms'),
            'sectionsDisponibles' => $sectionsDisponibles
        ];

        return view('gestionnaire/centres/create', $data);
    }

    public function store()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $nom = trim($this->request->getPost('NOMCENTRE') ?? '');
        $localisation = $this->request->getPost('LOCALISATION');
        $capacite = (int)($this->request->getPost('CAPACITEDACCUEIL') ?? 100);
        $sections = $this->request->getPost('SECTIONS') ?? [];

        if (empty($nom) || empty($localisation)) {
            return redirect()->back()->withInput()->with('error', 'Veuillez remplir tous les champs obligatoires.');
        }

        // Génération automatique du CODECENTRE (Ex: C001, C002, etc.)
        $dernierCentre = $db->table('CENTRE')->orderBy('CODECENTRE', 'DESC')->get()->getRow();
        $prochainNumero = 1;
        if ($dernierCentre) {
            // Extrait les chiffres du dernier code (ex: 'C005' -> 5) et incrémente
            $numeroActuel = (int) filter_var($dernierCentre->CODECENTRE, FILTER_SANITIZE_NUMBER_INT);
            $prochainNumero = $numeroActuel + 1;
        }
        $code = 'C' . str_pad($prochainNumero, 3, '0', STR_PAD_LEFT);

        $db->transStart();

        // 1. Insertion du centre avec le code généré
        $db->table('CENTRE')->insert([
            'CODECENTRE'       => $code,
            'NOMCENTRE'        => $nom,
            'LOCALISATION'     => $localisation,
            'CAPACITEDACCUEIL' => $capacite,
            'STATUT'           => 1
        ]);

        // 2. Association des sections dans la table pivot
        if (!empty($sections)) {
            $pivotData = [];
            foreach ($sections as $codeSection) {
                $pivotData[] = [
                    'CODECENTRE'  => $code,
                    'CODESECTION' => $codeSection
                ];
            }
            $db->table('CENTRE_SECTION')->insertBatch($pivotData);
        }

        // 3. Journalisation (Logs)
        if ($db->tableExists('LOGS')) {
            $db->table('LOGS')->insert([
                'action'   => 'Création du centre régional : ' . $nom . ' (' . $code . ')',
                'auteur'   => $session->get('immutilisateur'),
                'date_log' => date('Y-m-d H:i:s')
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'enregistrement du centre.');
        }

        return redirect()->to('/centres')->with('success', 'Le centre régional a été enregistré avec succès (Code : ' . $code . ').');
    }

    public function toggleStatus($code)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $centre = $db->table('CENTRE')->where('CODECENTRE', $code)->get()->getRow();

        if ($centre) {
            $nouveauStatut = ($centre->STATUT == 1) ? 0 : 1;
            $libelleStatut = ($nouveauStatut == 1) ? 'Activé' : 'Désactivé';

            $db->transStart();

            $db->table('CENTRE')->where('CODECENTRE', $code)->update(['STATUT' => $nouveauStatut]);

            // Journalisation (Logs) pour le changement de statut
            if ($db->tableExists('LOGS')) {
                $db->table('LOGS')->insert([
                    'action'   => 'Mise à jour statut centre (' . $libelleStatut . ') : ' . $centre->NOMCENTRE . ' (' . $code . ')',
                    'auteur'   => $session->get('immutilisateur'),
                    'date_log' => date('Y-m-d H:i:s')
                ]);
            }

            $db->transComplete();

            return redirect()->to('/centres')->with('success', 'Le statut du centre a été mis à jour avec succès.');
        }

        return redirect()->to('/centres')->with('error', 'Centre introuvable.');
    }

    public function edit($code)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        
        // Récupérer le centre à modifier
        $centre = $db->table('CENTRE')->where('CODECENTRE', $code)->get()->getRowArray();
        if (!$centre) {
            return redirect()->to('/centres')->with('error', 'Centre introuvable.');
        }

        // Récupérer toutes les sections globales disponibles
        $sectionsDisponibles = $db->table('SECTION')->get()->getResultArray();

        // Récupérer les sections déjà associées à ce centre
        $sectionsAssociees = $db->table('CENTRE_SECTION')->where('CODECENTRE', $code)->get()->getResultArray();
        $codesSectionsAssociees = array_column($sectionsAssociees, 'CODESECTION');

        $data = [
            'immutilisateur'         => $session->get('immutilisateur'),
            'nom'                    => $session->get('nom'),
            'prenoms'                => $session->get('prenoms'),
            'centre'                 => $centre,
            'sectionsDisponibles'    => $sectionsDisponibles,
            'codesSectionsAssociees' => $codesSectionsAssociees
        ];

        return view('gestionnaire/centres/edit', $data);
    }

    public function update($code)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $nom = trim($this->request->getPost('NOMCENTRE') ?? '');
        $localisation = $this->request->getPost('LOCALISATION');
        $capacite = (int)($this->request->getPost('CAPACITEDACCUEIL') ?? 100);
        $sections = $this->request->getPost('SECTIONS') ?? [];

        if (empty($nom) || empty($localisation)) {
            return redirect()->back()->withInput()->with('error', 'Veuillez remplir tous les champs obligatoires.');
        }

        $db->transStart();

        // 1. Mettre à jour les informations du centre
        $db->table('CENTRE')->where('CODECENTRE', $code)->update([
            'NOMCENTRE'        => $nom,
            'LOCALISATION'     => $localisation,
            'CAPACITEDACCUEIL' => $capacite
        ]);

        // 2. Mettre à jour les sections (supprimer les anciennes associations et insérer les nouvelles)
        $db->table('CENTRE_SECTION')->where('CODECENTRE', $code)->delete();
        if (!empty($sections)) {
            $pivotData = [];
            foreach ($sections as $codeSection) {
                $pivotData[] = [
                    'CODECENTRE'  => $code,
                    'CODESECTION' => $codeSection
                ];
            }
            $db->table('CENTRE_SECTION')->insertBatch($pivotData);
        }

        // 3. Journalisation (Logs)
        if ($db->tableExists('LOGS')) {
            $db->table('LOGS')->insert([
                'action'   => 'Modification du centre régional : ' . $nom . ' (' . $code . ')',
                'auteur'   => $session->get('immutilisateur'),
                'date_log' => date('Y-m-d H:i:s')
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la mise à jour du centre.');
        }

        return redirect()->to('/centres')->with('success', 'Le centre régional a été mis à jour avec succès.');
    }
}
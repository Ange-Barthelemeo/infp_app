<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CentralCentreController extends BaseController
{
    /**
     * Liste de tous les centres régionaux ACTIFS (STATUT = 1) avec le total des élèves-maîtres
     */
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        
        // Récupération des centres actifs en comptant les élèves via les classes
        $centres = $db->table('CENTRE')
            ->select('CENTRE.*, COUNT(ELEVEMAITRE.MATRICULEELEVE) as total_eleves')
            ->join('CLASSE', 'CLASSE.CODECENTRE = CENTRE.CODECENTRE', 'left')
            ->join('ELEVEMAITRE', 'ELEVEMAITRE.CODECLASSE = CLASSE.CODECLASSE', 'left')
            ->where('CENTRE.STATUT', 1)
            ->groupBy('CENTRE.CODECENTRE')
            ->orderBy('CENTRE.NOMCENTRE', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'centres'        => $centres
        ];

        return view('gestionnaire/centres/index', $data);
    }

    public function showEleve($matricule)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        // 1. Récupérer les informations personnelles de l'élève, sa classe, sa section et son centre
        $eleve = $db->table('ELEVEMAITRE')
            ->select('ELEVEMAITRE.*, CLASSE.NOMCLASSE, CLASSE.CODECENTRE, CENTRE.NOMCENTRE, SECTION.LIBELLESECTION, SECTION.CODESECTION')
            ->join('CLASSE', 'CLASSE.CODECLASSE = ELEVEMAITRE.CODECLASSE', 'inner')
            ->join('CENTRE', 'CENTRE.CODECENTRE = CLASSE.CODECENTRE', 'inner')
            ->join('SECTION', 'SECTION.CODESECTION = CLASSE.CODESECTION', 'left')
            ->where('ELEVEMAITRE.MATRICULEELEVE', $matricule)
            ->get()
            ->getRowArray();

        if (!$eleve) {
            return redirect()->to('/central/centres')->with('error', 'Dossier d’élève-maître introuvable.');
        }

        // Sécurité supplémentaire : Vérifier que le centre rattaché est actif (STATUT = 1)
        $centreActif = $db->table('CENTRE')
            ->where('CODECENTRE', $eleve['CODECENTRE'])
            ->where('STATUT', 1)
            ->get()
            ->getRowArray();

        if (!$centreActif) {
            return redirect()->to('/central/centres')->with('error', 'Accès refusé : le centre de rattachement de cet élève est inactif.');
        }

        // 2. Récupérer les notes de l'élève par EC et par UE (via AVOIRNOTE)
        $notes = $db->table('AVOIRNOTE')
            ->select('AVOIRNOTE.*, EC.LIBELLEEC, EC.COEFEC, UE.LIBELLEUE, UE.CODEUE')
            ->join('EC', 'EC.CODEEC = AVOIRNOTE.CODEEC', 'inner')
            ->join('UE', 'UE.CODEUE = EC.CODEUE', 'inner')
            ->where('AVOIRNOTE.MATRICULEELEVE', $matricule)
            ->get()
            ->getResultArray();

        // 3. Organiser les notes par Unité d'Enseignement (UE) pour le calcul des moyennes
        $uesStructure = [];
        foreach ($notes as $note) {
            $codeUE = $note['CODEUE'];
            if (!isset($uesStructure[$codeUE])) {
                $uesStructure[$codeUE] = [
                    'libelle' => $note['LIBELLEUE'],
                    'ecs'     => [],
                    'moyenne' => 0,
                    'validee' => true
                ];
            }
            $uesStructure[$codeUE]['ecs'][] = $note;
        }

        // Calcul simple des moyennes par UE
        foreach ($uesStructure as $codeUE => &$ue) {
            $totalPoints = 0;
            $totalCoeff = 0;
            foreach ($ue['ecs'] as $ec) {
                $coef = $ec['COEFEC'] ?? 1;
                $valeur = $ec['VALEURNOTE'] ?? 0;
                $totalPoints += ($valeur * $coef);
                $totalCoeff += $coef;
                
                if ($valeur < 10) {
                    $ue['validee'] = false;
                }
            }
            $ue['moyenne'] = $totalCoeff > 0 ? round($totalPoints / $totalCoeff, 2) : 0;
        }

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'eleve'          => $eleve,
            'uesStructure'   => $uesStructure,
            'notesBrutes'    => $notes
        ];

        return view('gestionnaire/eleves/show', $data);
    }

    public function show($codeCentre)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        // Récupérer les informations du centre
        $centre = $db->table('CENTRE')
            ->where('CODECENTRE', $codeCentre)
            ->get()
            ->getRowArray();

        if (!$centre) {
            // CORRIGÉ ICI : Redirection vers /central/centres au lieu de /gestionnaire/centres
            return redirect()->to('/central/centres')->with('error', 'Centre introuvable.');
        }

        // Récupérer les élèves-maîtres du centre via les classes
        $eleves = $db->table('ELEVEMAITRE')
            ->select('ELEVEMAITRE.*, CLASSE.NOMCLASSE')
            ->join('CLASSE', 'CLASSE.CODECLASSE = ELEVEMAITRE.CODECLASSE', 'inner')
            ->where('CLASSE.CODECENTRE', $codeCentre)
            ->orderBy('ELEVEMAITRE.NOMELEVE', 'ASC')
            ->get()
            ->getResultArray();

        // Récupérer les formateurs rattachés à ce centre précis
        $formateurs = $db->table('FORMATEUR')
            ->select('FORMATEUR.*, PERMANENT.IMMFORMATEUR, VACATAIRE.CODEVAC')
            ->join('PERMANENT', 'PERMANENT.NUMCINFORM = FORMATEUR.NUMCINFORM', 'left')
            ->join('VACATAIRE', 'VACATAIRE.NUMCINFORM = FORMATEUR.NUMCINFORM', 'left')
            ->where('FORMATEUR.CODECENTRE', $codeCentre)
            ->orderBy('FORMATEUR.NOMFORMATEUR', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'centre'         => $centre,
            'eleves'         => $eleves,
            'formateurs'     => $formateurs
        ];

        return view('gestionnaire/centres/show', $data);
    }
}
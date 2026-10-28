<?php

namespace App\Controllers\GestionnaireCentre;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class DashboardCentreController extends BaseController
{
    public function index()
    {
        $session = session();
        
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $db = \Config\Database::connect();
        $userModel = new UtilisateurModel();

        $imm = $session->get('immutilisateur');
        $currentUser = $userModel->find($imm);

        // Récupération du centre rattaché au gestionnaire connecté
        $codeCentre = $currentUser['CODECENTRE'] ?? null;
        $nomCentre = 'Mon Centre';

        if ($codeCentre) {
            $centre = $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray();
            if ($centre) {
                $nomCentre = $centre['NOMCENTRE'];
            }
        }

        // Statistiques spécifiques au centre et au rôle Gestionnaire de Centre
        // 1. Nombre de responsables de centre créés pour ce centre
        $totalResponsables = $userModel->where('PROFIL', 'RESPONSABLE_CENTRE')
                                       ->where('CODECENTRE', $codeCentre)
                                       ->countAllResults();

        // 2. Nombre total des élèves du centre (via les classes du centre)
        $totalEleves = 0;
        if ($codeCentre) {
            $totalEleves = $db->table('ELEVEMAITRE')
                              ->join('CLASSE', 'CLASSE.CODECLASSE = ELEVEMAITRE.CODECLASSE')
                              ->where('CLASSE.CODECENTRE', $codeCentre)
                              ->countAllResults();
        }

        // 3. Nombre total des formateurs affectés dans ce centre
        $totalFormateurs = 0;
        if ($codeCentre) {
            $totalFormateurs = $db->table('FORMATEUR')
                                  ->where('CODECENTRE', $codeCentre)
                                  ->countAllResults();
        }

        // 4. Nombre de classes créées pour ce centre
        $totalClasses = 0;
        if ($codeCentre) {
            $totalClasses = $db->table('CLASSE')
                              ->where('CODECENTRE', $codeCentre)
                              ->countAllResults();
        }

        // 5. Derniers responsables de centre créés
        $recentResponsables = [];
        if ($codeCentre) {
            $recentResponsables = $userModel->where('PROFIL', 'RESPONSABLE_CENTRE')
                                            ->where('CODECENTRE', $codeCentre)
                                            ->orderBy('IMMUTILISATEUR', 'DESC')
                                            ->limit(5)
                                            ->findAll();
        }

        $data = [
            'immutilisateur'     => $imm,
            'nom'                => $session->get('nom'),
            'prenoms'            => $session->get('prenoms'),
            'profil'             => $session->get('profil'),
            'nomCentre'          => $nomCentre,
            'totalResponsables'  => $totalResponsables,
            'totalEleves'        => $totalEleves,
            'totalFormateurs'    => $totalFormateurs,
            'totalClasses'       => $totalClasses,
            'recentResponsables' => $recentResponsables
        ];

        return view('gestionnaire/gestionnaire_centre/dashboard/index', $data);
    }
}
<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CentralDashboardController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        // 1. Total des centres régionaux
        $totalCentres = $db->table('CENTRE')->countAllResults();

        // 2. Total des élèves-maîtres (Adaptez le nom de la table si besoin, ex: 'ELEVE' ou 'ELEVE_MAITRE')
        $totalEleves = 0;
        if ($db->tableExists('ELEVE')) {
            $totalEleves = $db->table('ELEVE')->countAllResults();
        }

        // 3. Total des formateurs et ventilation (Permanents / Vacataires)
        $totalFormateurs = $db->table('FORMATEUR')->countAllResults();
        $totalPermanents = $db->table('PERMANENT')->countAllResults();
        $totalVacataires = $db->table('VACATAIRE')->countAllResults();

        // 4. Répartition géographique des centres (basée sur la colonne LOCALISATION)
        $repartitionGeo = $db->table('CENTRE')
            ->select('LOCALISATION, COUNT(*) as total')
            ->groupBy('LOCALISATION')
            ->get()
            ->getResultArray();

        // 5. Activités récentes / Logs (si la table des logs existe)
        $logs = [];
        if ($db->tableExists('LOGS')) {
            $logs = $db->table('LOGS')->orderBy('date_log', 'DESC')->limit(5)->get()->getResultArray();
        }

        $data = [
            'immutilisateur'   => $session->get('immutilisateur'),
            'nom'              => $session->get('nom'),
            'prenoms'          => $session->get('prenoms'),
            'totalCentres'     => $totalCentres,
            'totalEleves'      => $totalEleves, // Transmis à la vue
            'totalFormateurs'  => $totalFormateurs,
            'totalPermanents'  => $totalPermanents,
            'totalVacataires'  => $totalVacataires,
            'repartitionGeo'   => $repartitionGeo,
            'logs'             => $logs
        ];

        return view('gestionnaire/dashboard/index', $data);
    }
}
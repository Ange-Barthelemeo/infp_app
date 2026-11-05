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

        // 1. Total des centres régionaux ACTIFS uniquement (STATUT = 1)
        $totalCentres = $db->table('CENTRE')
                           ->where('STATUT', 1)
                           ->countAllResults();

        // 2. Total des élèves-maîtres rattachés aux centres actifs (Corrigé via ELEVEMAITRE et CLASSE)
        $totalEleves = 0;
        if ($db->tableExists('ELEVEMAITRE') && $db->tableExists('CLASSE') && $db->tableExists('CENTRE')) {
            $totalEleves = $db->table('ELEVEMAITRE')
                ->join('CLASSE', 'CLASSE.CODECLASSE = ELEVEMAITRE.CODECLASSE', 'inner')
                ->join('CENTRE', 'CENTRE.CODECENTRE = CLASSE.CODECENTRE', 'inner')
                ->where('CENTRE.STATUT', 1)
                ->countAllResults();
        }

        // 3. Total des formateurs et ventilation (Permanents / Vacataires)
        $totalFormateurs = $db->table('FORMATEUR')->countAllResults();
        $totalPermanents = $db->table('PERMANENT')->countAllResults();
        $totalVacataires = $db->table('VACATAIRE')->countAllResults();

        // 4. Répartition géographique des centres ACTIFS uniquement
        $repartitionGeo = $db->table('CENTRE')
            ->select('LOCALISATION, COUNT(*) as total')
            ->where('STATUT', 1)
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
            'totalEleves'      => $totalEleves,
            'totalFormateurs'  => $totalFormateurs,
            'totalPermanents'  => $totalPermanents,
            'totalVacataires'  => $totalVacataires,
            'repartitionGeo'   => $repartitionGeo,
            'logs'             => $logs
        ];

        return view('gestionnaire/dashboard/index', $data);
    }
}
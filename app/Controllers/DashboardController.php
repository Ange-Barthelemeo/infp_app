<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        // Statistiques globales des comptes
        $totalUsers = $db->table('UTILISATEUR')->countAllResults();
        $activeUsers = $db->table('UTILISATEUR')->where('ACTIF', 1)->countAllResults();

        // Derniers utilisateurs créés
        $recentUsers = $db->table('UTILISATEUR')
                          ->orderBy('IMMUTILISATEUR', 'DESC')
                          ->limit(5)
                          ->get()
                          ->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'totalUsers'     => $totalUsers,
            'activeUsers'    => $activeUsers,
            'recentUsers'    => $recentUsers
        ];

        return view('dashboard/admin', $data);
    }
}
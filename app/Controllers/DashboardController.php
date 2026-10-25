<?php

    namespace App\Controllers;

    use App\Controllers\BaseController;
    use App\Models\UtilisateurModel;

    class DashboardController extends BaseController
    {
        public function index()
        {
            $session = session();
            
            if (!$session->get('logged_in')) {
                return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
            }

            $userModel = new UtilisateurModel();

            // Récupération de statistiques purement techniques et administratives
            $data = [
                'immutilisateur' => $session->get('immutilisateur'),
                'nom'            => $session->get('nom'),
                'prenoms'        => $session->get('prenoms'),
                'profil'         => $session->get('profil'),
                'totalUsers'     => $userModel->countAll(),
                'activeUsers'    => $userModel->where('ACTIF', 1)->countAllResults(),
                'recentUsers'    => $userModel->where('PROFIL !=', 'ADMIN')->orderBy('IMMUTILISATEUR', 'DESC')->limit(5)->findAll()
            ];

            return view('dashboard/admin', $data);
        }
    }
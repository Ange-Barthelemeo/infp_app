<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ReferentielController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms')
        ];

        return view('admin/referentiel/index', $data);
    }
}
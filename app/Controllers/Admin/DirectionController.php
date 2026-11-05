<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DirectionController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $directions = $db->table('DIRECTION')->get()->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'directions'     => $directions
        ];

        return view('admin/directions/index', $data);
    }

    public function toggleStatus($codeDirection)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $direction = $db->table('DIRECTION')->where('CODEDIRECTION', $codeDirection)->get()->getRowArray();

        if ($direction) {
            $nouveauStatut = (isset($direction['STATUT']) && $direction['STATUT'] == 1) ? 0 : 1;
            $db->table('DIRECTION')->where('CODEDIRECTION', $codeDirection)->update(['STATUT' => $nouveauStatut]);

            enregistrer_log($session->get('immutilisateur'), "Changement de statut de la direction : " . $codeDirection);
            return redirect()->to('/admin/directions')->with('success', 'Statut de la direction mis à jour avec succès.');
        }

        return redirect()->to('/admin/directions')->with('error', 'Direction introuvable.');
    }
}
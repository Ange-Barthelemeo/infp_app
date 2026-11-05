<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class SectionController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $sections = $db->table('SECTION')->get()->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'sections'       => $sections
        ];

        return view('admin/sections/index', $data);
    }

    public function toggleStatus($codeSection)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $section = $db->table('SECTION')->where('CODESECTION', $codeSection)->get()->getRowArray();

        if ($section) {
            $nouveauStatut = (isset($section['STATUT']) && $section['STATUT'] == 1) ? 0 : 1;
            $db->table('SECTION')->where('CODESECTION', $codeSection)->update(['STATUT' => $nouveauStatut]);

            enregistrer_log($session->get('immutilisateur'), "Changement de statut de la section : " . $codeSection);
            return redirect()->to('/admin/sections')->with('success', 'Statut de la section mis à jour avec succès.');
        }

        return redirect()->to('/admin/sections')->with('error', 'Section introuvable.');
    }
}
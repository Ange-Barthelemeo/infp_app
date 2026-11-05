<?php

namespace App\Controllers\Admin;

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
        
        // Récupération de tous les centres
        $centres = $db->table('CENTRE')->get()->getResultArray();

        // Récupération de toutes les sections disponibles pour les listes déroulantes
        $toutesSections = $db->table('SECTION')->get()->getResultArray();

        // Association des sections pour chaque centre
        foreach ($centres as &$centre) {
            $sections = $db->table('CENTRE_SECTION cs')
                           ->join('SECTION s', 's.CODESECTION = cs.CODESECTION')
                           ->where('cs.CODECENTRE', $centre['CODECENTRE'])
                           ->get()
                           ->getResultArray();
            $centre['sections'] = $sections;
            $centre['section_codes'] = array_column($sections, 'CODESECTION');
        }

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'centres'        => $centres,
            'toutesSections' => $toutesSections
        ];

        return view('admin/centres/index', $data);
    }

    // Corrigé en 'toggleStatus' avec un 's' pour correspondre à la requête du framework
    public function toggleStatus($codeCentre)
    {
        $db = \Config\Database::connect();
        $centre = $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray();

        if ($centre) {
            $nouveauStatut = ($centre['STATUT'] == 1) ? 0 : 1;
            $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->update(['STATUT' => $nouveauStatut]);
        }

        return redirect()->to('/admin/centres')->with('success', 'Statut du centre mis à jour avec succès.');
    }

    public function updateSections($codeCentre)
    {
        $db = \Config\Database::connect();
        $sectionsChoisies = $this->request->getPost('sections') ?? [];

        // Suppression des anciennes associations
        $db->table('CENTRE_SECTION')->where('CODECENTRE', $codeCentre)->delete();

        // Insertion des nouvelles associations sélectionnées
        if (!empty($sectionsChoisies)) {
            $dataBatch = [];
            foreach ($sectionsChoisies as $codeSection) {
                $dataBatch[] = [
                    'CODECENTRE'  => $codeCentre,
                    'CODESECTION' => $codeSection
                ];
            }
            $db->table('CENTRE_SECTION')->insertBatch($dataBatch);
        }

        return redirect()->to('/admin/centres')->with('success', 'Sections habilitées mises à jour avec succès.');
    }
}
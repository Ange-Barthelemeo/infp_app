<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class UeEcController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        
        // 1. Récupération de toutes les UE
        $ues = $db->table('UNITENS')->get()->getResultArray();
        
        // 2. Récupération de tous les EC
        $ecs = $db->table('ELEMCONST')->get()->getResultArray();

        // 3. Récupération des liaisons de la table SUIVRE avec les sections
        $suivres = $db->table('SUIVRE')->get()->getResultArray();

        // Organiser les sections par EC
        $sectionsParEc = [];
        foreach ($suivres as $suivre) {
            $sectionsParEc[$suivre['CODEEC']][] = $suivre['CODESPECIALITE'] ?? $suivre['CODESECTION']; 
            // Note: Ajustez 'CODESECTION' selon le nom exact dans votre table SUIVRE (affiché 'CODESECTION' dans votre DESCRIBE)
        }

        // Version plus propre pour stocker les sections par EC :
        $sectionsParEc = [];
        foreach ($suivres as $suivre) {
            $sectionsParEc[$suivre['CODEEC']][] = $suivre['CODESECTION'];
        }

        // Injecter les sections dans chaque EC
        foreach ($ecs as &$ec) {
            $ec['sections'] = $sectionsParEc[$ec['CODEEC']] ?? [];
        }
        unset($ec);

        // 4. Association des EC à leur UE respective
        $ecsParUe = [];
        foreach ($ecs as $ec) {
            $ecsParUe[$ec['CODEUE']][] = $ec;
        }

        foreach ($ues as &$ue) {
            $ue['ecs'] = $ecsParUe[$ue['CODEUE']] ?? [];
        }
        unset($ue);

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'ues'            => $ues
        ];

        return view('admin/ues/index', $data);
    }

    public function toggleStatus($codeUe)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $ue = $db->table('UNITENS')->where('CODEUE', $codeUe)->get()->getRowArray();

        if ($ue) {
            $nouveauStatut = (isset($ue['STATUT']) && $ue['STATUT'] == 1) ? 0 : 1;
            $db->table('UNITENS')->where('CODEUE', $codeUe)->update(['STATUT' => $nouveauStatut]);

            if (function_exists('enregistrer_log')) {
                enregistrer_log($session->get('immutilisateur'), "Changement de statut de l'UE : " . $codeUe);
            }
            return redirect()->to('/admin/ues')->with('success', 'Statut de l\'UE mis à jour avec succès.');
        }

        return redirect()->to('/admin/ues')->with('error', 'Unité d\'Enseignement introuvable.');
    }
}
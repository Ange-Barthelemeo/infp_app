<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ParametreController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('PARAMETRE_SYSTEME');
        $params = $builder->get()->getResultArray();

        // Transformer les résultats en un tableau associatif [CLE => VALEUR]
        $settings = [];
        foreach ($params as $p) {
            $settings[$p['CLE']] = $p['VALEUR'];
        }

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'settings'       => $settings
        ];

        return view('admin/parametres/index', $data);
    }

    public function update()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('PARAMETRE_SYSTEME');

        $postData = $this->request->getPost();

        // Application des règles de validation et de sécurité strictes
        if (isset($postData['pwd_min_length'])) {
            $postData['pwd_min_length'] = max(8, (int) $postData['pwd_min_length']);
        }
        if (isset($postData['max_login_attempts'])) {
            $postData['max_login_attempts'] = max(5, (int) $postData['max_login_attempts']);
        }

        // Mettre à jour chaque paramètre soumis
        foreach ($postData as $key => $value) {
            $builder->where('CLE', $key)->update(['VALEUR' => trim($value)]);
        }

        // Enregistrer l'action dans le journal d'audit si le helper est chargé
        if (function_exists('enregistrer_log')) {
            enregistrer_log($session->get('immutilisateur'), "Mise à jour des paramètres système");
        }

        return redirect()->to('/parametres')->with('success', 'Paramètres système mis à jour avec succès.');
    }
}
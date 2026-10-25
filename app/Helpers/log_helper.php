<?php

if (!function_exists('enregistrer_log')) {
    /**
     * Enregistre une action dans la table AUDIT_LOG
     * 
     * @string $immutilisateur Matricule de l'utilisateur qui effectue l'action
     * @string $action Description de l'action réalisée
     */
    function enregistrer_log($immutilisateur, $action)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('AUDIT_LOG');
        
        $builder->insert([
            'IMMUTILISATEUR' => $immutilisateur,
            'ACTION'         => $action,
            'DATEACTION'     => date('Y-m-d H:i:s')
        ]);
    }
}
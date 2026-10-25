<?php

if (!function_exists('get_setting')) {
    function get_setting(string $key, $default = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('PARAMETRE_SYSTEME');
        $row = $builder->where('CLE', $key)->get()->getRow();

        if ($row !== null) {
            return $row->VALEUR;
        }

        return $default;
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'UTILISATEUR';
    protected $primaryKey = 'IMMUTILISATEUR'; 
    protected $allowedFields = [
        'IMMUTILISATEUR',
        'NOM',
        'PRENOMS',
        'TELEPHONE',         // <--- AJOUTEZ CETTE LIGNE ICI
        'CODEDIRECTION',
        'CODECENTRE',
        'EMAIL',
        'PROFIL',
        'MOTDEPASSE',
        'ACTIF',
        'PREMIERE_CONNEXION',
        'TENTATIVES_ECHOUEES'
    ];
}
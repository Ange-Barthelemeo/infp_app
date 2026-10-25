<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'UTILISATEUR';
    protected $primaryKey = 'IMMUTILISATEUR'; // <--- Indiquer explicitement la clé primaire ici
    protected $allowedFields = [
        'IMMUTILISATEUR',
        'NOM',
        'PRENOMS',
        'CODEDIRECTION',
        'CODECENTRE',
        'EMAIL',
        'PROFIL',
        'MOTDEPASSE',
        'ACTIF',
        'PREMIERE_CONNEXION',
        'TENTATIVES_ECHOUEES' // Assurez-vous que ce champ y figure aussi pour autoriser sa mise à jour
    ];
}
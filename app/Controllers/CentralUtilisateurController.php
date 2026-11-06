<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CentralUtilisateurController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $request = service('request');
        $search = trim($request->getGet('search'));
        $filtreCentre = $request->getGet('centre');

        // On ne liste que les GESTIONNAIRE_CENTRE
        $builder = $db->table('UTILISATEUR')
            ->select('UTILISATEUR.*, CENTRE.NOMCENTRE, DIRECTION.NOMDIRECTION')
            ->join('CENTRE', 'CENTRE.CODECENTRE = UTILISATEUR.CODECENTRE', 'left')
            ->join('DIRECTION', 'DIRECTION.CODEDIRECTION = UTILISATEUR.CODEDIRECTION', 'left')
            ->where('UTILISATEUR.PROFIL', 'GESTIONNAIRE_CENTRE');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('UTILISATEUR.NOM', $search)
                ->orLike('UTILISATEUR.PRENOMS', $search)
                ->orLike('UTILISATEUR.IMMUTILISATEUR', $search)
                ->orLike('UTILISATEUR.EMAIL', $search)
                ->groupEnd();
        }

        if (!empty($filtreCentre)) {
            $builder->where('UTILISATEUR.CODECENTRE', $filtreCentre);
        }

        $users = $builder->orderBy('UTILISATEUR.NOM', 'ASC')->get()->getResultArray();
        
        $centres = $db->table('CENTRE')->where('STATUT', 1)->orderBy('NOMCENTRE', 'ASC')->get()->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'users'          => $users,
            'centres'        => $centres,
            'search'         => $search,
            'filtreCentre'   => $filtreCentre
        ];

        return view('gestionnaire/utilisateurs/index', $data);
    }

    public function create()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $centres = $db->table('CENTRE')->where('STATUT', 1)->orderBy('NOMCENTRE', 'ASC')->get()->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'centres'        => $centres
        ];

        return view('gestionnaire/utilisateurs/create', $data);
    }

    public function store()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $request = service('request');

        $im = trim($request->getPost('IMMUTILISATEUR'));
        $nom = trim($request->getPost('NOM'));
        $prenoms = trim($request->getPost('PRENOMS'));
        $email = trim($request->getPost('EMAIL'));
        $telephone = trim($request->getPost('TELEPHONE'));
        $codeCentre = trim($request->getPost('CODECENTRE'));

        // Forcer le profil à Gestionnaire de Centre uniquement
        $profil = 'GESTIONNAIRE_CENTRE';

        if (empty($im) || empty($nom) || empty($prenoms) || empty($email) || empty($codeCentre)) {
            return redirect()->back()->withInput()->with('error', 'Veuillez remplir tous les champs obligatoires, y compris le centre.');
        }

        // Nettoyage IM et vérification globale d'unicité
        $cleanIm = str_replace(' ', '', $im);
        $existeUtilisateur = $db->table('UTILISATEUR')->where("REPLACE(IMMUTILISATEUR, ' ', '') =", $cleanIm)->get()->getRowArray();
        $existePermanent = $db->table('PERMANENT')->where("REPLACE(IMMFORMATEUR, ' ', '') =", $cleanIm)->get()->getRowArray();

        if ($existeUtilisateur || $existePermanent) {
            return redirect()->back()->withInput()->with('error', 'Cet identifiant IM est déjà utilisé dans le système.');
        }

        // Mot de passe par défaut sécurisé
        $motDePasseDefaut = password_hash('12345678', PASSWORD_DEFAULT);

        $db->table('UTILISATEUR')->insert([
            'IMMUTILISATEUR'     => $im,
            'NOM'                => $nom,
            'PRENOMS'            => $prenoms,
            'EMAIL'              => $email,
            'TELEPHONE'          => $telephone,
            'CODECENTRE'         => $codeCentre,
            'CODEDIRECTION'      => null,
            'PROFIL'             => $profil,
            'MOTDEPASSE'         => $motDePasseDefaut,
            'ACTIF'              => 1,
            'PREMIERE_CONNEXION' => 1
        ]);

        return redirect()->to('/central/utilisateurs')->with('success', 'Compte Gestionnaire de Centre créé avec succès (Mot de passe par défaut : 12345678).');
    }

    public function toggleStatus($im)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $user = $db->table('UTILISATEUR')->where('IMMUTILISATEUR', $im)->where('PROFIL', 'GESTIONNAIRE_CENTRE')->get()->getRowArray();

        if (!$user) {
            return redirect()->to('/central/utilisateurs')->with('error', 'Utilisateur introuvable.');
        }

        $nouveauStatut = ($user['ACTIF'] == 1) ? 0 : 1;
        $db->table('UTILISATEUR')->where('IMMUTILISATEUR', $im)->update(['ACTIF' => $nouveauStatut]);

        $message = ($nouveauStatut == 1) ? 'Compte activé avec succès.' : 'Compte désactivé avec succès.';
        return redirect()->to('/central/utilisateurs')->with('success', $message);
    }
}
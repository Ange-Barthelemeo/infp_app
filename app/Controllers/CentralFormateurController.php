<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CentralFormateurController extends BaseController
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

        $builder = $db->table('FORMATEUR')
            ->select('FORMATEUR.*, CENTRE.NOMCENTRE, PERMANENT.IMMFORMATEUR, VACATAIRE.CODEVAC')
            ->join('CENTRE', 'CENTRE.CODECENTRE = FORMATEUR.CODECENTRE', 'inner')
            ->join('PERMANENT', 'PERMANENT.NUMCINFORM = FORMATEUR.NUMCINFORM', 'left')
            ->join('VACATAIRE', 'VACATAIRE.NUMCINFORM = FORMATEUR.NUMCINFORM', 'left')
            ->where('CENTRE.STATUT', 1);

        // Application du filtre de recherche si présent
        if (!empty($search)) {
            $builder->groupStart()
                ->like('FORMATEUR.NOMFORMATEUR', $search)
                ->orLike('FORMATEUR.PRENOMFORMATEUR', $search)
                ->orLike('FORMATEUR.NUMCINFORM', $search)
                ->orLike('PERMANENT.IMMFORMATEUR', $search)
                ->orLike('VACATAIRE.CODEVAC', $search)
                ->groupEnd();
        }

        $formateurs = $builder->orderBy('FORMATEUR.NOMFORMATEUR', 'ASC')
            ->get()
            ->getResultArray();

        $totalPermanents = 0;
        $totalVacataires = 0;
        foreach ($formateurs as $f) {
            if (!empty($f['IMMFORMATEUR'])) {
                $totalPermanents++;
            } else {
                $totalVacataires++;
            }
        }

        $data = [
            'immutilisateur'   => $session->get('immutilisateur'),
            'nom'              => $session->get('nom'),
            'prenoms'          => $session->get('prenoms'),
            'formateurs'       => $formateurs,
            'totalPermanents'  => $totalPermanents,
            'totalVacataires'  => $totalVacataires,
            'search'           => $search
        ];

        return view('gestionnaire/formateurs/index', $data);
    }

    /**
     * Afficher le formulaire d'ajout d'un formateur
     */
    public function create()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        
        // Récupérer uniquement les centres actifs pour l'affectation
        $centres = $db->table('CENTRE')
            ->where('STATUT', 1)
            ->orderBy('NOMCENTRE', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'centres'        => $centres
        ];

        return view('gestionnaire/formateurs/create', $data);
    }

    /**
     * Enregistrer un nouveau formateur (Permanent ou Vacataire)
     */
    public function store()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $request = service('request');

        $numCin = trim($request->getPost('NUMCINFORM'));
        $codeCentre = trim($request->getPost('CODECENTRE'));
        $nom = trim($request->getPost('NOMFORMATEUR'));
        $prenom = trim($request->getPost('PRENOMFORMATEUR'));
        $contact = trim($request->getPost('CONTACTFORMATEUR'));
        $adresse = trim($request->getPost('ADRESSEFORMATEUR'));
        $typeFormateur = $request->getPost('TYPE_FORMATEUR'); // 'permanent' ou 'vacataire'
        $imFormateur = trim($request->getPost('IMMFORMATEUR'));

        // 1. Vérification de l'unicité du CIN
        $existeCin = $db->table('FORMATEUR')->where('NUMCINFORM', $numCin)->get()->getRowArray();
        if ($existeCin) {
            return redirect()->back()->withInput()->with('error', 'Ce numéro de CIN est déjà utilisé par un autre formateur.');
        }

        // 2. Vérification de l'unicité du Contact
        $existeContact = $db->table('FORMATEUR')->where('CONTACTFORMATEUR', $contact)->get()->getRowArray();
        if ($existeContact) {
            return redirect()->back()->withInput()->with('error', 'Ce numéro de contact est déjà attribué à un autre formateur.');
        }

        // 3. Si Permanent, vérifier l'unicité globale de l'IM (dans PERMANENT ET dans UTILISATEUR en ignorant les espaces)
        if ($typeFormateur === 'permanent') {
            if (empty($imFormateur)) {
                return redirect()->back()->withInput()->with('error', 'L’IM est obligatoire pour un formateur permanent.');
            }

            // Nettoyer l'IM saisi (retirer les espaces pour comparer uniformément)
            $cleanIm = str_replace(' ', '', $imFormateur);

            // Vérification dans PERMANENT (en ignorant les espaces en base)
            $existeImPermanent = $db->table('PERMANENT')
                ->where("REPLACE(IMMFORMATEUR, ' ', '') =", $cleanIm)
                ->get()
                ->getRowArray();
            
            // Vérification dans UTILISATEUR (en ignorant les espaces en base)
            $existeImUtilisateur = $db->table('UTILISATEUR')
                ->where("REPLACE(IMMUTILISATEUR, ' ', '') =", $cleanIm)
                ->get()
                ->getRowArray();

            if ($existeImPermanent || $existeImUtilisateur) {
                return redirect()->back()->withInput()->with('error', 'Cet identifiant IM ("' . $imFormateur . '") est déjà utilisé dans le système par un autre utilisateur ou formateur.');
            }
        }

        // Début de transaction
        $db->transStart();

        // Insertion dans la table mère FORMATEUR
        $db->table('FORMATEUR')->insert([
            'NUMCINFORM'       => $numCin,
            'CODECENTRE'       => $codeCentre,
            'NOMFORMATEUR'     => $nom,
            'PRENOMFORMATEUR'  => $prenom,
            'CONTACTFORMATEUR' => $contact,
            'NATIONALITE'      => 'Malagasy',
            'EST_ACTIF'        => 1,
            'ADRESSEFORMATEUR' => $adresse
        ]);

        // Insertion selon le type (Permanent ou Vacataire)
        if ($typeFormateur === 'permanent') {
            $db->table('PERMANENT')->insert([
                'NUMCINFORM'   => $numCin,
                'IMMFORMATEUR' => $imFormateur
            ]);
        } else {
            // Génération automatique du code vacataire (ex: VAC-ANNEE-XXXX)
            $codeVac = 'VAC-' . date('Y') . '-' . strtoupper(substr(uniqid(), -4));
            $db->table('VACATAIRE')->insert([
                'NUMCINFORM' => $numCin,
                'CODEVAC'    => $codeVac
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de l’enregistrement du formateur.');
        }

        return redirect()->to('/gestionnaire/formateurs')->with('success', 'Formateur ajouté avec succès.');
    }

    /**
     * Basculer l'état (Activer / Désactiver) d'un formateur
     */
    public function toggleStatus($numCin)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $formateur = $db->table('FORMATEUR')->where('NUMCINFORM', $numCin)->get()->getRowArray();

        if (!$formateur) {
            return redirect()->to('/gestionnaire/formateurs')->with('error', 'Formateur introuvable.');
        }

        $nouveauStatut = (($formateur['EST_ACTIF'] ?? 1) == 1) ? 0 : 1;
        $db->table('FORMATEUR')->where('NUMCINFORM', $numCin)->update(['EST_ACTIF' => $nouveauStatut]);

        $message = ($nouveauStatut == 1) ? 'Formateur activé avec succès.' : 'Formateur désactivé avec succès.';
        return redirect()->to('/gestionnaire/formateurs')->with('success', $message);
    }
}
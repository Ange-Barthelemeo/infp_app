<?php

namespace App\Controllers\GestionnaireCentre;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class ClasseController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        $db = \Config\Database::connect();
        $search = trim($this->request->getGet('search') ?? '');

        $builder = $db->table('CLASSE');
        $builder->select('CLASSE.*, CENTRE.NOMCENTRE, PROMOTION.NOMPROM, SECTION.NOMSECTION');
        $builder->join('CENTRE', 'CENTRE.CODECENTRE = CLASSE.CODECENTRE', 'left');
        $builder->join('PROMOTION', 'PROMOTION.CODEPROM = CLASSE.CODEPROM', 'left');
        $builder->join('SECTION', 'SECTION.CODESECTION = CLASSE.CODESECTION', 'left');
        
        // Restriction stricte au centre du gestionnaire connecté
        if ($codeCentre) {
            $builder->where('CLASSE.CODECENTRE', $codeCentre);
        }

        // Recherche multicritère : Code classe, Nom de classe, Promotion ou Section
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('CLASSE.CODECLASSE', $search)
                    ->orLike('CLASSE.NOMCLASSE', $search)
                    ->orLike('PROMOTION.NOMPROM', $search)
                    ->orLike('SECTION.NOMSECTION', $search)
                    ->groupEnd();
        }

        $builder->orderBy('CLASSE.CODECLASSE', 'DESC');
        $classes = $builder->get()->getResultArray();

        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'classes'        => $classes,
            'centre'         => $centre,
            'search'         => $search
        ];

        return view('gestionnaire/gestionnaire_centre/classes/index', $data);
    }

    public function create()
    {
        $session = session();
        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        $db = \Config\Database::connect();
        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;
        
        // Récupérer les promotions et sections disponibles
        $promotions = $db->table('PROMOTION')->get()->getResultArray();
        $sections = $db->table('SECTION')->get()->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'centre'         => $centre,
            'promotions'     => $promotions,
            'sections'       => $sections
        ];

        return view('gestionnaire/gestionnaire_centre/classes/create', $data);
    }

    public function store()
    {
        $session = session();
        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        if (!$codeCentre) {
            return redirect()->back()->withInput()->with('error', 'Aucun centre rattaché à votre compte.');
        }

        $db = \Config\Database::connect();

        $codeClasse  = trim($this->request->getPost('codeclasse'));
        $nomClasse   = trim($this->request->getPost('nomclasse'));
        $codeProm    = trim($this->request->getPost('codeprom'));
        $codeSection = trim($this->request->getPost('codesection'));
        $capaciteMax = trim($this->request->getPost('capacitemax'));

        if ($db->table('CLASSE')->where('CODECLASSE', $codeClasse)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('error', 'Ce code de classe existe déjà.');
        }

        $data = [
            'CODECLASSE'  => $codeClasse,
            'CODECENTRE'  => $codeCentre,
            'CODEPROM'    => $codeProm,
            'CODESECTION' => $codeSection,
            'NOMCLASSE'   => $nomClasse,
            'CAPACITEMAX' => $capaciteMax ?: null
        ];

        $db->table('CLASSE')->insert($data);

        if (function_exists('enregistrer_log')) {
            enregistrer_log($session->get('immutilisateur'), "Création de la classe : " . $codeClasse . " (" . $nomClasse . ")");
        }

        return redirect()->to('/gestionnaire/classes')->with('success', 'Classe créée avec succès.');
    }

    public function edit($code)
    {
        $session = session();
        $db = \Config\Database::connect();
        
        $codeDecoded = urldecode($code);
        $classe = $db->table('CLASSE')->where('CODECLASSE', $codeDecoded)->get()->getRowArray();

        if (!$classe) {
            return redirect()->to('/gestionnaire/classes')->with('error', 'Classe introuvable.');
        }

        $userModel = new UtilisateurModel();
        $currentUser = $userModel->find($session->get('immutilisateur'));
        $codeCentre = $currentUser['CODECENTRE'] ?? null;

        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;
        $promotions = $db->table('PROMOTION')->get()->getResultArray();
        $sections = $db->table('SECTION')->get()->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'classe'         => $classe,
            'centre'         => $centre,
            'promotions'     => $promotions,
            'sections'       => $sections
        ];

        return view('gestionnaire/gestionnaire_centre/classes/edit', $data);
    }

    public function update($code)
    {
        $session = session();
        $db = \Config\Database::connect();
        $codeDecoded = urldecode($code);

        $nomClasse   = trim($this->request->getPost('nomclasse'));
        $codeProm    = trim($this->request->getPost('codeprom'));
        $codeSection = trim($this->request->getPost('codesection'));
        $capaciteMax = trim($this->request->getPost('capacitemax'));

        $data = [
            'NOMCLASSE'   => $nomClasse,
            'CODEPROM'    => $codeProm,
            'CODESECTION' => $codeSection,
            'CAPACITEMAX' => $capaciteMax ?: null
        ];

        $db->table('CLASSE')->where('CODECLASSE', $codeDecoded)->update($data);

        if (function_exists('enregistrer_log')) {
            enregistrer_log($session->get('immutilisateur'), "Modification de la classe : " . $codeDecoded);
        }

        return redirect()->to('/gestionnaire/classes')->with('success', 'Classe mise à jour avec succès.');
    }

    public function delete($code)
    {
        $session = session();
        $db = \Config\Database::connect();
        $codeDecoded = urldecode($code);

        $classe = $db->table('CLASSE')->where('CODECLASSE', $codeDecoded)->get()->getRowArray();

        if ($classe) {
            $db->table('CLASSE')->where('CODECLASSE', $codeDecoded)->delete();

            if (function_exists('enregistrer_log')) {
                enregistrer_log($session->get('immutilisateur'), "Suppression de la classe : " . $codeDecoded);
            }

            return redirect()->to('/gestionnaire/classes')->with('success', 'Classe supprimée avec succès.');
        }

        return redirect()->to('/gestionnaire/classes')->with('error', 'Classe introuvable.');
    }
}
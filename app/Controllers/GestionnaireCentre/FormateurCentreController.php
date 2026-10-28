<?php

namespace App\Controllers\GestionnaireCentre;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class FormateurCentreController extends BaseController
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

        $builder = $db->table('FORMATEUR');
        $builder->select('FORMATEUR.*, CENTRE.NOMCENTRE');
        $builder->join('CENTRE', 'CENTRE.CODECENTRE = FORMATEUR.CODECENTRE', 'left');
        
        // Restriction stricte au centre du gestionnaire connecté
        if ($codeCentre) {
            $builder->where('FORMATEUR.CODECENTRE', $codeCentre);
        }

        // Recherche multicritère : NumCinForm, Nom, Prénom ou Contact
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('FORMATEUR.NUMCINFORM', $search)
                    ->orLike('FORMATEUR.NOMFORMATEUR', $search)
                    ->orLike('FORMATEUR.PRENOMFORMATEUR', $search)
                    ->orLike('FORMATEUR.CONTACTFORMATEUR', $search)
                    ->orLike("CONCAT(FORMATEUR.NOMFORMATEUR, ' ', FORMATEUR.PRENOMFORMATEUR)", $search)
                    ->orLike("CONCAT(FORMATEUR.PRENOMFORMATEUR, ' ', FORMATEUR.NOMFORMATEUR)", $search)
                    ->groupEnd();
        }

        $builder->orderBy('FORMATEUR.NUMCINFORM', 'DESC');
        $formateurs = $builder->get()->getResultArray();

        $centre = $codeCentre ? $db->table('CENTRE')->where('CODECENTRE', $codeCentre)->get()->getRowArray() : null;

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'formateurs'     => $formateurs,
            'centre'         => $centre,
            'search'         => $search
        ];

        return view('gestionnaire/gestionnaire_centre/formateurs/index', $data);
    }
}
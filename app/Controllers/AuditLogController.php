<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AuditLogController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        
        $dateDebut = $this->request->getGet('date_debut');
        $dateFin   = $this->request->getGet('date_fin');

        $builder = $db->table('AUDIT_LOG');
        $builder->select('AUDIT_LOG.*, UTILISATEUR.NOM, UTILISATEUR.PRENOMS');
        $builder->join('UTILISATEUR', 'UTILISATEUR.IMMUTILISATEUR = AUDIT_LOG.IMMUTILISATEUR', 'left');

        // Filtre par date de début (uniquement la date)
        if (!empty($dateDebut)) {
            $builder->where('DATE(AUDIT_LOG.DATEACTION) >=', $dateDebut);
        }

        // Filtre par date de fin (uniquement la date)
        if (!empty($dateFin)) {
            $builder->where('DATE(AUDIT_LOG.DATEACTION) <=', $dateFin);
        }

        // Tri par ordre croissant des ID
        $builder->orderBy('AUDIT_LOG.IDLOG', 'ASC');
        $logs = $builder->get()->getResultArray();

        $data = [
            'immutilisateur' => $session->get('immutilisateur'),
            'nom'            => $session->get('nom'),
            'prenoms'        => $session->get('prenoms'),
            'logs'           => $logs,
            'dateDebut'      => $dateDebut,
            'dateFin'        => $dateFin
        ];

        return view('admin/logs/index', $data);
    }
}
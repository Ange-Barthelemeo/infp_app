<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->post('login/attempt', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');
$routes->get('dashboard', 'DashboardController::index');
$routes->get('admin/profile', 'AdminProfileController::index');
$routes->post('admin/profile/update', 'AdminProfileController::update');

// Gestion des utilisateurs (Liste, Formulaire de création, Enregistrement et Changement de statut)
$routes->get('utilisateurs', 'UserController::index');
$routes->get('utilisateurs/create', 'UserController::create');
$routes->post('utilisateurs/store', 'UserController::store');
$routes->get('utilisateurs/toggle/(:any)', 'UserController::toggleStatus/$1');
$routes->get('utilisateurs/edit/(:any)', 'UserController::edit/$1');
$routes->post('utilisateurs/update/(:any)', 'UserController::update/$1');
$routes->get('changer-mot-de-passe-initial', 'FirstLoginController::index');
$routes->post('changer-mot-de-passe-initial/update', 'FirstLoginController::update');
$routes->get('audit-logs', 'AuditLogController::index');
$routes->get('parametres', 'ParametreController::index');
$routes->post('parametres/update', 'ParametreController::update');
$routes->get('central/dashboard', 'CentralDashboardController::index');
$routes->get('gestionnaire/dashboard', 'CentralDashboardController::index');

// ==========================================
// GESTION DES MÉTADONNÉES (Réservé à l'Admin)
// ==========================================

// Hub du Référentiel
$routes->get('admin/referentiel', 'Admin\ReferentielController::index');

// 1. Directions
$routes->get('admin/directions', 'Admin\DirectionController::index');
$routes->get('admin/directions/toggle/(:segment)', 'Admin\DirectionController::toggleStatus/$1');

// 2. Centres Régionaux
$routes->get('admin/centres', 'Admin\CentreController::index');
$routes->get('admin/centres/toggle/(:segment)', 'Admin\CentreController::toggleStatus/$1');
$routes->post('admin/centres/update-sections/(:segment)', 'Admin\CentreController::updateSections/$1');

// 3. Sections de formation
$routes->get('admin/sections', 'Admin\SectionController::index');
$routes->get('admin/sections/toggle/(:segment)', 'Admin\SectionController::toggleStatus/$1');

// 4. Unité d'Enseignement & Éléments Constitutifs (Hub Unifié UE & EC)
$routes->get('admin/ues', 'Admin\UeEcController::index');
$routes->get('admin/ues/toggle/(:segment)', 'Admin\UeEcController::toggleStatus/$1');

// (Optionnel si vous souhaitez garder les deux alias d'URL actifs)
$routes->get('admin/ues-ecs', 'Admin\UeEcController::index');
$routes->get('admin/ues-ecs/toggle/(:segment)', 'Admin\UeEcController::toggleStatus/$1');

// Retrait de ['filter' => 'auth'] si vous gérez la session directement dans le contrôleur
$routes->group('gestionnaire', function($routes) {
    $routes->get('centres', 'CentralCentreController::index');
    $routes->get('centres/(:any)', 'CentralCentreController::show/$1');
});

$routes->group('gestionnaire', function($routes) {
    $routes->get('centres', 'CentralCentreController::index');
    $routes->get('centres/(:any)', 'CentralCentreController::show/$1');
    $routes->get('eleves/dossier/(:segment)', 'CentralCentreController::showEleve/$1');
});

$routes->group('gestionnaire', function($routes) {
    $routes->get('dashboard', 'CentralDashboardController::index');
    $routes->get('centres', 'CentralCentreController::index');
    $routes->get('centres/(:any)', 'CentralCentreController::show/$1');
    $routes->get('eleves/dossier/(:segment)', 'CentralCentreController::showEleve/$1');
    
    // Module Formateurs
    $routes->get('formateurs', 'CentralFormateurController::index');
    $routes->get('formateurs/create', 'CentralFormateurController::create');
    $routes->post('formateurs/store', 'CentralFormateurController::store');
    $routes->post('formateurs/toggle/(:segment)', 'CentralFormateurController::toggleStatus/$1');

    // Module Profil Gestionnaire Central
    $routes->get('profile', 'CentralProfileController::index');
    $routes->post('profile/update', 'CentralProfileController::update');

    // Gestion des comptes Gestionnaires de Centre
    $routes->get('utilisateurs', 'CentralUtilisateurController::index');
    $routes->get('utilisateurs/create', 'CentralUtilisateurController::create');
    $routes->post('utilisateurs/store', 'CentralUtilisateurController::store');
    $routes->get('utilisateurs/toggle/(:segment)', 'CentralUtilisateurController::toggleStatus/$1');
});
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==========================================
// AUTHENTIFICATION & ACCÈS GÉNÉRAL
// ==========================================
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->post('login/attempt', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');
$routes->get('dashboard', 'DashboardController::index');

$routes->get('changer-mot-de-passe-initial', 'FirstLoginController::index');
$routes->post('changer-mot-de-passe-initial/update', 'FirstLoginController::update');
$routes->get('audit-logs', 'AuditLogController::index');
$routes->get('parametres', 'ParametreController::index');
$routes->post('parametres/update', 'ParametreController::update');


// ==========================================
// GESTION DES UTILISATEURS (Admin global)
// ==========================================
$routes->get('utilisateurs', 'UserController::index');
$routes->get('utilisateurs/create', 'UserController::create');
$routes->post('utilisateurs/store', 'UserController::store');
$routes->get('utilisateurs/toggle/(:any)', 'UserController::toggleStatus/$1');
$routes->get('utilisateurs/edit/(:any)', 'UserController::edit/$1');
$routes->post('utilisateurs/update/(:any)', 'UserController::update/$1');


// ==========================================
// GESTION DES CENTRES (Admin global)
// ==========================================
$routes->get('centres', 'CentreController::index');
$routes->get('centres/create', 'CentreController::create');
$routes->post('centres/store', 'CentreController::store');
$routes->get('centres/toggle/(:any)', 'CentreController::toggleStatus/$1');
$routes->get('centres/edit/(:any)', 'CentreController::edit/$1');
$routes->post('centres/update/(:any)', 'CentreController::update/$1');


// ==========================================
// GESTIONNAIRE CENTRAL (Isolé sous le préfixe 'central/')
// ==========================================
$routes->group('central', function($routes) {
    $routes->get('dashboard', 'CentralDashboardController::index');
    $routes->get('centres', 'CentralCentreController::index');
    $routes->get('centres/(:any)', 'CentralCentreController::show/$1');
    $routes->get('eleves/dossier/(:segment)', 'CentralCentreController::showEleve/$1');
    
    // Module Formateurs
    $routes->get('formateurs', 'CentralFormateurController::index');
    $routes->get('formateurs/create', 'CentralFormateurController::create');
    $routes->post('formateurs/store', 'CentralFormateurController::store');
    $routes->post('formateurs/toggle/(:segment)', 'CentralFormateurController::toggleStatus/$1');

    // Profil Gestionnaire Central
    $routes->get('profile', 'CentralProfileController::index');
    $routes->post('profile/update', 'CentralProfileController::update');

    // Gestion des comptes Gestionnaires de Centre
    $routes->get('utilisateurs', 'CentralUtilisateurController::index');
    $routes->get('utilisateurs/create', 'CentralUtilisateurController::create');
    $routes->post('utilisateurs/store', 'CentralUtilisateurController::store');
    $routes->get('utilisateurs/toggle/(:any)', 'CentralUtilisateurController::toggleStatus/$1');
});


// ==========================================
// MÉTADONNÉES (Réservé à l'Admin)
// ==========================================
$routes->get('admin/profile', 'AdminProfileController::index');
$routes->post('admin/profile/update', 'AdminProfileController::update');
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

// 4. Unité d'Enseignement & Éléments Constitutifs
$routes->get('admin/ues', 'Admin\UeEcController::index');
$routes->get('admin/ues/toggle/(:segment)', 'Admin\UeEcController::toggleStatus/$1');
$routes->get('admin/ues-ecs', 'Admin\UeEcController::index');
$routes->get('admin/ues-ecs/toggle/(:segment)', 'Admin\UeEcController::toggleStatus/$1');


// ==========================================
// ESPACE GESTIONNAIRE DE CENTRE (routes en 'gestionnaire/')
// ==========================================
$routes->get('gestionnaire/profile', 'GestionnaireCentre\ProfilController::index');
$routes->post('gestionnaire/profile/update', 'GestionnaireCentre\ProfilController::update');
$routes->get('gestionnaire/dashboard', 'GestionnaireCentre\DashboardCentreController::index');

// Responsables
$routes->get('gestionnaire/responsables', 'GestionnaireCentre\ResponsableController::index');
$routes->get('gestionnaire/responsables/create', 'GestionnaireCentre\ResponsableController::create');
$routes->post('gestionnaire/responsables/store', 'GestionnaireCentre\ResponsableController::store');
$routes->get('gestionnaire/responsables/toggle/(:any)', 'GestionnaireCentre\ResponsableController::toggleStatus/$1');
$routes->get('gestionnaire/responsables/delete/(:any)', 'GestionnaireCentre\ResponsableController::delete/$1');

// Formateurs de centre
$routes->get('gestionnaire/formateurs', 'GestionnaireCentre\FormateurCentreController::index');

// Élèves
$routes->get('gestionnaire/eleves', 'GestionnaireCentre\EleveCentreController::index');
$routes->get('gestionnaire/eleves/create', 'GestionnaireCentre\EleveCentreController::create');
$routes->post('gestionnaire/eleves/store', 'GestionnaireCentre\EleveCentreController::store');
$routes->get('gestionnaire/eleves/edit/(:any)', 'GestionnaireCentre\EleveCentreController::edit/$1');
$routes->post('gestionnaire/eleves/update/(:any)', 'GestionnaireCentre\EleveCentreController::update/$1');
$routes->get('gestionnaire/eleves/delete/(:any)', 'GestionnaireCentre\EleveCentreController::delete/$1');

// Classes
$routes->get('gestionnaire/classes', 'GestionnaireCentre\ClasseController::index');
$routes->get('gestionnaire/classes/create', 'GestionnaireCentre\ClasseController::create');
$routes->post('gestionnaire/classes/store', 'GestionnaireCentre\ClasseController::store');
$routes->get('gestionnaire/classes/edit/(:any)', 'GestionnaireCentre\ClasseController::edit/$1');
$routes->post('gestionnaire/classes/update/(:any)', 'GestionnaireCentre\ClasseController::update/$1');
$routes->get('gestionnaire/classes/delete/(:any)', 'GestionnaireCentre\ClasseController::delete/$1');

// Séances
$routes->get('gestionnaire/seances', 'GestionnaireCentre\SeanceController::index');
$routes->get('gestionnaire/seances/create', 'GestionnaireCentre\SeanceController::create');
$routes->post('gestionnaire/seances/store', 'GestionnaireCentre\SeanceController::store');
$routes->get('gestionnaire/seances/delete/(:num)', 'GestionnaireCentre\SeanceController::delete/$1');
$routes->get('gestionnaire/seances/edit/(:num)', 'GestionnaireCentre\SeanceController::edit/$1');
$routes->post('gestionnaire/seances/update/(:num)', 'GestionnaireCentre\SeanceController::update/$1');

// Notes
$routes->get('gestionnaire/notes', 'GestionnaireCentre\NoteCentreController::index');
$routes->get('gestionnaire/notes/create', 'GestionnaireCentre\NoteCentreController::create');
$routes->post('gestionnaire/notes/store', 'GestionnaireCentre\NoteCentreController::NoteCentreController::store'); // Ajusté si besoin
$routes->post('gestionnaire/notes/store', 'GestionnaireCentre\NoteCentreController::store');
$routes->get('gestionnaire/notes/edit/(:any)/(:any)', 'GestionnaireCentre\NoteCentreController::edit/$1/$2');
$routes->post('gestionnaire/notes/update/(:any)/(:any)', 'GestionnaireCentre\NoteCentreController::update/$1/$2');
$routes->get('gestionnaire/notes/delete/(:any)/(:any)', 'GestionnaireCentre\NoteCentreController::delete/$1/$2');
$routes->get('gestionnaire/notes/admis', 'GestionnaireCentre\NoteCentreController::admis');
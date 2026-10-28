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

// Dashboards spécifiques
$routes->get('central/dashboard', 'CentralDashboardController::index');

// Gestion des Centres régionaux
$routes->get('centres', 'CentreController::index');
$routes->get('centres/create', 'CentreController::create');
$routes->post('centres/store', 'CentreController::store');
$routes->get('centres/toggle/(:any)', 'CentreController::toggleStatus/$1');
$routes->get('centres/edit/(:any)', 'CentreController::edit/$1');
$routes->post('centres/update/(:any)', 'CentreController::update/$1');

// Routes pour l'espace Gestionnaire de Centre (Profil & Tableau de bord)
$routes->get('gestionnaire/profile', 'GestionnaireCentre\ProfilController::index');
$routes->post('gestionnaire/profile/update', 'GestionnaireCentre\ProfilController::update');
$routes->get('gestionnaire/dashboard', 'GestionnaireCentre\DashboardCentreController::index');

// Gestion des responsables par le Gestionnaire de Centre (uniquement Index, Create, Store et Toggle)
$routes->get('gestionnaire/responsables', 'GestionnaireCentre\ResponsableController::index');
$routes->get('gestionnaire/responsables/create', 'GestionnaireCentre\ResponsableController::create');
$routes->post('gestionnaire/responsables/store', 'GestionnaireCentre\ResponsableController::store');
$routes->get('gestionnaire/responsables/toggle/(:any)', 'GestionnaireCentre\ResponsableController::toggleStatus/$1');
$routes->get('gestionnaire/responsables/delete/(:any)', 'GestionnaireCentre\ResponsableController::delete/$1');
$routes->get('gestionnaire/formateurs', 'GestionnaireCentre\FormateurCentreController::index');

$routes->get('gestionnaire/eleves', 'GestionnaireCentre\EleveCentreController::index');
$routes->get('gestionnaire/eleves/create', 'GestionnaireCentre\EleveCentreController::create');
$routes->post('gestionnaire/eleves/store', 'GestionnaireCentre\EleveCentreController::store');
$routes->get('gestionnaire/eleves/edit/(:any)', 'GestionnaireCentre\EleveCentreController::edit/$1');
$routes->post('gestionnaire/eleves/update/(:any)', 'GestionnaireCentre\EleveCentreController::update/$1');
$routes->get('gestionnaire/eleves/delete/(:any)', 'GestionnaireCentre\EleveCentreController::delete/$1');

$routes->get('gestionnaire/classes', 'GestionnaireCentre\ClasseController::index');
$routes->get('gestionnaire/classes/create', 'GestionnaireCentre\ClasseController::create');
$routes->post('gestionnaire/classes/store', 'GestionnaireCentre\ClasseController::store');
$routes->get('gestionnaire/classes/edit/(:any)', 'GestionnaireCentre\ClasseController::edit/$1');
$routes->post('gestionnaire/classes/update/(:any)', 'GestionnaireCentre\ClasseController::update/$1');
$routes->get('gestionnaire/classes/delete/(:any)', 'GestionnaireCentre\ClasseController::delete/$1');

$routes->get('gestionnaire/seances', 'GestionnaireCentre\SeanceController::index');
$routes->get('gestionnaire/seances/create', 'GestionnaireCentre\SeanceController::create');
$routes->post('gestionnaire/seances/store', 'GestionnaireCentre\SeanceController::store');
$routes->get('gestionnaire/seances/delete/(:num)', 'GestionnaireCentre\SeanceController::delete/$1');
$routes->get('gestionnaire/seances/edit/(:num)', 'GestionnaireCentre\SeanceController::edit/$1');
$routes->post('gestionnaire/seances/update/(:num)', 'GestionnaireCentre\SeanceController::update/$1');

$routes->get('gestionnaire/notes', 'GestionnaireCentre\NoteCentreController::index');
$routes->get('gestionnaire/notes/create', 'GestionnaireCentre\NoteCentreController::create');
$routes->post('gestionnaire/notes/store', 'GestionnaireCentre\NoteCentreController::store');
$routes->get('gestionnaire/notes/edit/(:any)/(:any)', 'GestionnaireCentre\NoteCentreController::edit/$1/$2');
$routes->post('gestionnaire/notes/update/(:any)/(:any)', 'GestionnaireCentre\NoteCentreController::update/$1/$2');
$routes->get('gestionnaire/notes/delete/(:any)/(:any)', 'GestionnaireCentre\NoteCentreController::delete/$1/$2');
$routes->get('gestionnaire/notes/admis', 'GestionnaireCentre\NoteCentreController::admis');
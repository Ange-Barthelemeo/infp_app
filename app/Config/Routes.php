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


    $routes->get('centres', 'CentreController::index');
    $routes->get('centres/create', 'CentreController::create');
    $routes->post('centres/store', 'CentreController::store');
    $routes->get('centres/toggle/(:any)', 'CentreController::toggleStatus/$1');

        // Routes pour la modification des centres régionaux
    $routes->get('centres/edit/(:any)', 'CentreController::edit/$1');
    $routes->post('centres/update/(:any)', 'CentreController::update/$1');
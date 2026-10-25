<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @param CLIRequest|IncomingRequest $request
     *
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Chargement des helpers indispensables
        $this->helpers = ['form', 'url', 'parametre', 'log'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');

        // ==========================================
        // VÉRIFICATION GLOBALE DU MODE MAINTENANCE
        // ==========================================
        $maintenanceActive = (string) get_setting('maintenance_mode', '0') === '1';

        if ($maintenanceActive) {
            $session = session();
            $profil  = $session->get('profil');

            // Vérifier si la route actuelle fait partie des accès autorisés
            $isAllowedRoute = url_is('login') 
                           || url_is('logout') 
                           || url_is('auth/login') 
                           || url_is('login/attempt') 
                           || url_is('auth/attemptLogin');

            // Si l'utilisateur n'est pas un ADMIN et n'est pas sur une route autorisée
            if ($profil !== 'ADMIN' && !$isAllowedRoute) {
                echo view('errors/html/maintenance');
                exit();
            }
        }
    }
}
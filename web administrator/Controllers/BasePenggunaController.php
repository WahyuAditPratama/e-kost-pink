<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\AuthModel;
use App\Models\AppModel;
use App\Libraries\Auth;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BasePenggunaController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */


    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available`
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['my_helper', 'url', 'date'];
    protected $auth;
    protected $authmodel;
    protected $session;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */

    public function __construct()
    {
        $this->session     = \Config\Services::session();
        $this->request     = \Config\Services::request();
        $this->auth        = new Auth();
        $this->authmodel = new AuthModel();
    }

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }
}

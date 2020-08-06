<?php
use Symfony\Component\HttpFoundation\Session\Session;

class Router {
    /**
    * Gére les différents accès aux sites et initialise le contrôleur correspondant à
    * la requête de l'utilisateur
    * @var  string  $_request	requête de l'utilisateur
    * @var  bool    $_auth      état de l'authentification
    * @var  string  $_module	module demandé
    * @var  array   $_routes    liste des routes disponibles
    * @var  array   $_config    configuration du site
    * @version	2.0
    */
    public $_request;
    private $_auth;
    private $_module;
    private $_routes;

    protected static $_config;

    public function __construct($req) {
        $this->_request = $req;
        $this->BuildConfig();
        $this->SetAuth();
    }

    /**
    * Lecture du fichier de configuration
    * @throws  ErrorException Fichier illisible
    * @todo    Gestion de l'erreur
    */
    private function BuildConfig() {
        self::$_config = parse_ini_file('src/config.ini', true);

        if(isset(self::$_config['PATH']) && isset(self::$_config['MODULES']) && isset(self::$_config['DATABASE']))
            $this->_routes = self::$_config['MODULES'];
        else {
            // TODO Fichier de configuration invalide
        }
    }

    /**
    * Vérifie l'authentification
    */
    private function SetAuth() {
        if(isset($_SESSION['user']) && $_SESSION['user'])
            $this->_auth = $_SESSION['auth'];
        else
            $this->_auth = 0;
    }

    /**
    * Parse l'url et récupère le module, les actions et les paramètres
    */
    private function ParseURL() {
        $url = explode('/', $this->_request->getPathInfo());
        array_shift($url);  // Supprime la première case vide

        $module = strtolower(urldecode(array_shift($url)));
        // Si pas de module, on charge l'index
        $this->_module = empty($module) ? 'index' : $module;
        $_SESSION['module'] = $this->_module;

        $this->_actions = strtolower(urldecode(array_shift($url)));
        $this->_parameters = array_map('urldecode', $url);
    }

    /**
    * Construit la route et appel le constructeur correspondant
    */
    public function Route() {
        $this->ParseURL();

        if(!in_array($this->_module, array_keys($this->_routes))) {

            // Le module demandé n'est pas dans la liste des modules accessibles
            $controllerName = 'Error';
            $httpCode = 404;
        }
        elseif(!file_exists('src/controllers/Controller' . ucfirst($this->_module) . '.php')) {
            // Le fichier n'a pas été trouvé
            $controllerName = 'Error';
            $httpCode = 418; // Teapot Error :p
        }
        elseif($this->_auth < $this->_routes[$this->_module]) {
            // Verification des droits d'accès
            $controllerName = 'Log';
            $httpCode = 200;
        }
        else {
            //
            $httpCode = 200;
            $controllerName = ucfirst($this->_module);
        }

        // Charge le controlleur
        $controllerName = 'Controller' . $controllerName;
        $controller = new $controllerName($this->_actions, $this->_parameters, $httpCode);

        $controller->Make();
    }

    /**
    * Méthode de redirection
    */
    public function Go($module, $action=null, $param=null) {
        $url = $module;
        if($action != null) {
            $url += $action;
            if($param != null) $url += $param;
        }

        header('location: /'. $url);
    }
}

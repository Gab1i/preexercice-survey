<?php
class ControllerError extends Router {
    /**
    * Controlleur d'erreur
    * @var  string  $_action
    * @var  array   $_parameters
    * @version	2.0
    */
    private $_action;
    private $_parameters;

    public function __construct($action, $parameters) {
        $this->_action = $action;
        $this->_parameters = $parameters;
    }

    public function make() {
        // hihi
        if(random_int(0, 10) == 1)
            $vue = new View('teapot', 'I\'m a teapot', 418);
        else
            $vue = new View('404', 'Erreur 404', 404);

        $vue->Build();
    }
}

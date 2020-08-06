<?php
class ControllerIndex extends Router {
    /**
    * Controlleur d'erreur
    * @var  string  $_action
    * @var  array   $_parameters
    * @version	2.0
    */
    private $_action;
    private $_parameters;
    private $_modelSurvey;

    public function __construct($action, $parameters) {
        $this->_action = $action;
        $this->_parameters = $parameters;
        $this->_modelSurvey = new ModelSurvey();
        $this->_modelUser = new ModelUser();
    }

    public function make() {
        if(count($_POST) > 0) {
            if($this->_checkSurvey()) {
                $this->_sendSurvey();
            } else {
                $this->_displaySurvey(true);
            }
        } else {
            $this->_displaySurvey();
        }
    }

    private function _displaySurvey($error=false) {
        $questions = $this->_modelSurvey->GetQuestions();

        $vue = new View('index', 'Accueil');
        $vue->Build(array(
            'questions' => $questions,
            'error' => $error,
            'previous' =>  $_POST
        ));
    }

    private function _sendSurvey() {
        $userId = $this->_modelUser->AddUser($_POST['name'], $_POST['mail']);
        foreach ($_POST as $key => $value) {
            if(preg_match('/q_([0-9]+)/', $key, $matches)) {
                $this->_modelSurvey->AddAnswer($userId, $matches[1], $value);
            }
        }

        $vue = new View('thank', 'Accueil');
        $vue->Build();
    }

    private function _checkSurvey() {
        if(isset($_POST['name']) && strlen($_POST['name']) > 0 && isset($_POST['mail']) && preg_match('#^[a-zA-Z0-9._-]+@[a-zA-Z]+\.[a-z]{1,7}$#', $_POST['mail'])) {
            if($this->_modelUser->CheckMail($_POST['mail'])) {
                return false;
            }

            return true;
        }

        return false;
    }
}

<?php
class ControllerAdmin extends Router {
    /**
    * Administration controller
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
        switch ($this->_action) {
            case 'results':
                $this->_getResults();
                break;

            case 'new':
                $this->_newQuestion();
                break;

            case 'add':
                $this->_addQuestion();
                break;

            case 'delete':
                $this->_deleteQuestion();
                break;

            default:
                $this->_displaySurvey();
                break;
        }
    }

    private function _displaySurvey() {
        $questions = $this->_modelSurvey->GetQuestions();
        $nbAnswers = $this->_modelSurvey->CountAnswers();

        $vue = new View('index_admin', 'Accueil');
        $vue->Build(array(
            'questions' => $questions,
            'nbAnswers' => $nbAnswers
        ));
    }

    private function _getResults() {
        $answers = $this->_modelSurvey->GetAllAnswers();

        $vue = new View('', 'Accueil');
        $vue->BuildCsv($answers);
    }

    private function _newQuestion() {
        $vue = new View('new_question', 'Accueil');
        $vue->Build();
    }

    private function _addQuestion() {
        $order = $this->_modelSurvey->GetFuturNum();
        $this->_modelSurvey->AddQuestion($_POST['question'], $order, $_POST['question_type']);
        $this->Go('survey/admin');
    }

    private function _deleteQuestion() {
        if(isset($this->_parameters[0]) && $this->_modelSurvey->QuestionExists($this->_parameters[0])) {
            $this->_modelSurvey->RemoveQuestion($this->_parameters[0]);
        }

        $this->Go('survey/admin');
    }
}

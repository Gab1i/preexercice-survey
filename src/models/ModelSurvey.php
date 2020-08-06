<?php
/**
* User model
* @version	1.0
*/
class ModelSurvey extends Model {
	public function AddQuestion($text, $order, $type) {
		$request = 'INSERT INTO questions(`question_order`, `type`, `text`)
                	VALUES(:order, :type, :text)';

		$param = array(
			'order' => $order,
			'type' => $type,
			'text' => $text
		);

		$this->Request($request, $param);
	}

	public function GetQuestions() {
		$request = 'SELECT * FROM `questions` ORDER BY `question_order`';
        return $this->Request($request)->fetchAll();
	}

	public function RemoveQuestion($idQuestion) {
		$this->ResetSurvey();
		$request = 'DELETE FROM `questions` WHERE `id_question` = :id';

		$param = array(
			'id' => $idQuestion
		);
		$this->Request($request, $param);
        $this->ReorderSuppr();
	}

	public function AddAnswer($user, $question, $answer) {
		$request = 'INSERT INTO answers(`id_question`, `id_user`, `answer`)
                	VALUES(:question, :user, :answer)';

		$param = array(
			'question' => $question,
			'user' => $user,
			'answer' => $answer
		);

		$this->Request($request, $param);
	}

	public function ReorderQuestion($questionPlaces) {
		/* this method take an array containing tuple ($idQuestion, $newPlace) */
		$req = 'UPDATE questions
				SET `question_order` = :order
				WHERE `id_question` = :id';

		foreach ($questionPlaces as $question) {
			$param = array(
				'id' => $question[0],
				'order' => $question[1]
			);

			$this->Request($req, $param);
		}
	}

	public function CountAnswers() {
		$request = 'SELECT COUNT(DISTINCT id_user) as nb FROM `answers` GROUP BY `id_user`';

        $result = $this->Request($request)->fetch();
		if(!$result) return 0;
		else return $result['nb'];
	}

	public function GetAllAnswers() {
		$request = 'SELECT * FROM `answers` a
		 			INNER JOIN `questions` q ON q.`id_question` = a.`id_question`';

        return $this->Request($request)->fetchAll();
	}

	public function GetFuturNum() {
		$request = 'SELECT MAX(question_order)+1 as value FROM `questions`';
		$result = $this->Request($request)->fetch();

		return is_null($result['value']) ? 1 : $result['value'];
	}

	public function QuestionExists($id) {
        $request = 'SELECT COUNT(*) as nb FROM questions WHERE id_question = :id ';
        $param = array(
            'id' => $id,
            );

        $data = $this->Request($request, $param)->fetch();
        if($data['nb'] == 0)
            return false;
        else
            return true;
	}

	public function ResetSurvey() {
		$request1 = 'DELETE FROM `answers`';
        $this->Request($request1);

		$request2 = 'DELETE FROM `user`';
        $this->Request($request2);
	}

	public function ReorderSuppr() {
		$questions = $this->GetQuestions();

		$req = 'UPDATE questions
				SET `question_order` = :order
				WHERE `id_question` = :id';
		for ($i=0; $i < count($questions); $i++) {
			$param = array(
				'id' => $questions[$i]['id_question'],
				'order' => $i+1
			);

			$this->Request($req, $param);
		}
	}
}

<?php
/**
* User model
* @version	1.0
*/
class ModelUser extends Model {
	public function AddUser($name, $mail) {
		$request = 'INSERT INTO user(`name`, `mail`, `answer_time`)
                	VALUES(:name, :mail, NOW())';

		$param = array(
			'name' => $name,
			'mail' => $mail
		);

		$this->Request($request, $param);
		return $this->LastId();
	}

	public function CheckMail($mail) {
        $request = 'SELECT COUNT(*) as nombre FROM user WHERE mail = :mail ';
        $param = array(
            'mail' => $mail,
            );

        $donnees = $this->Request($request, $param)->fetch();
        if($donnees['nombre'] == 0)
            return false;
        else
            return true;
    }
}

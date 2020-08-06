<?php
abstract class Model extends Router {
    /**
    * Model de données pour gérer la connexion à la base de données
    * @version	2.0
    */
    private $_bdd;
    private $_nbRow;

    public function __construct() {
        $this->_bdd = $this->Connection();
        $this->_nbRow = 0;
    }

    protected function GetRow() {
        return $this->_nbRow;
    }

    /**
    * Méthode qui gère les requêtes à la base de données
    * @param  string  $sql          Requête sql
    * @param  array   $parameters   tableau des paramètres à passer à la variable
    */
    protected function Request($sql, $parameters=NULL) {
        if($parameters == NULL) {
            $result = $this->_bdd->query($sql);
        }
        else {
            $result = $this->_bdd->prepare($sql);
            $result->execute($parameters);
        }
        $this->_nbRow = $result->rowCount();
        return $result;
    }

    /**
    * Méthode qui créé la connexion à la base
    */
    private function Connection() {
        $db_config = self::$_config['DATABASE'];

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        $bdd = new PDO(
            $db_config['SGBD'] .':host='. $db_config['HOST'] .';dbname='. $db_config['DB_NAME'],
            $db_config['USER'],
            $db_config['PASSWORD'],
            $options);
            //$db_config['OPTIONS']);

        unset($db_config);

        return $bdd;
    }

    /**
    * Méthode qui renvoit le dernier identifiant inséré dans la base
    */
    public function LastId() {
        return $this->_bdd->lastInsertId();
    }
}

?>

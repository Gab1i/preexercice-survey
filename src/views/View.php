<?php
use Symfony\Component\HttpFoundation\Response;

class View {
    /**
    * Classe qui contrôle l'affichage des différentes vues et la réponse http
    * @var  string  $_module	contient le module demandé
    * @var  string  $_title     titre de la page
    * @var  int     $_httpCode	code http a renvoyer
    * @version	2.0
    */
    private $_module;
    private $_title;
    private $_httpCode;

    public function __construct($module, $title, $httpCode=200) {
        $this->_title = $title;
        $this->_module = 'src/views/' . $module . '.php';
        $this->_httpCode = $httpCode;
    }

    /**
    * Méthode qui construit et affiche la vue
    * @param  array  $data     Contient la liste des variables à transmettre à la vue
    */
    public function Build($data=array(), $header=true, $footer=true) {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');

        $content = $this->generateFile($this->_module, $data);

        $vue = $this->generateFile('src/views/gabarit.php', array(
            'title' => $this->_title,
            'header' => $header,
            'footer' => $footer,
            'content' => $content));

        // Remplace les liens relatifs (ignore les liens absolus)
        $pattern = '#((src).?=.?(\'|"))(?!http|www|\#)(.+(\'|"))#';
        $replacement = '$1'. ROOT .'public/$4';
        $vue = preg_replace($pattern, $replacement, $vue);

        $pattern = '#((href|action).?=.?(\'|"))(?!http|www|\#)(.+(\'|"))#';
        $replacement = '$1'. ROOT .'$4';
        $vue = preg_replace($pattern, $replacement, $vue);

        $response->setContent($vue);

        $response->setStatusCode($this->_httpCode);
        $response->send();
    }

    public function BuildJson($data=array()) {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($data));
        $response->setStatusCode($this->_httpCode);
        $response->send();
    }

    public function BuildCsv($data=array()) {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $str = implode(',', array_keys($data[0])) . PHP_EOL;
        foreach ($data as $key => $value) {
            $str .= implode(',', $value) . PHP_EOL;
        }

        $response->setContent($str);
        $response->setStatusCode($this->_httpCode);
        $response->send();
    }

    /**
    * Méthode qui met l'affichage d'un fichier en tampon
    * @param  string  $file     nom du fichier
    * @param  string  $data     variables à extraire
    */
    public function GenerateFile($file, $data) {
        if(file_exists($file)) {
            extract($data);
            ob_start();
            require $file;
            return ob_get_clean();
        }
        else {
            throw new Exception('File '. $file .' not found');
        }
    }


}

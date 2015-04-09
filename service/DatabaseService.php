<?php

class DatabaseService {
    /**
    * Instance de la classe DatabaseService
    * @access private
    * @var DatabaseService
    * @see getInstance
    */
    private static $instance;

    /**
    * Type de la bdd.
    * @access private
    * @var string
    * @see __construct
    */
    private $type = "pgsql";

    /**
    * Adresse du serveur hôte.
    * @access private
    * @var string
    * @see __construct
    */
    private $host = "ec2-184-73-254-144.compute-1.amazonaws.com";

    /**
    * Nom de la bdd.
    * @access private
    * @var string
    * @see __construct
    */
    private $dbname = "d2v1v9s59qbq66";

    /**
    * Nom d'utilisateur
    * @access private
    * @var string
    * @see __construct
    */
    private $username = "xjzkvstydxdowf";

    /**
    * Mot de passe
    * @access private
    * @var string
    * @see __construct
    */
    private $password = 'jT6bxwXWoee69wtN0MlE2_j2jb';

    private $dbh;

    private function __construct() {
        try{
            $this->dbh = new PDO(
                $this->type.':host='.$this->host.'; dbname='.$this->dbname,
                $this->username,
                $this->password,
                array(PDO::ATTR_PERSISTENT => true)
            );

            $req = "SET NAMES UTF8";
            $result = $this->dbh->prepare($req);
            $result->execute();
        } catch(PDOException $e){
            echo $e->getMessage();
            die();
        }
    }

    /**
    * Retourne une instance de DatabaseService, si non stocké, en crée une.
    * @return $instance
    */
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
    * Retourn l'objet PDO permettant de manipuler la base de donnée.
    * @return $dbh
    */
    public function getDbh()
    {
        return $this->dbh;
    }
}
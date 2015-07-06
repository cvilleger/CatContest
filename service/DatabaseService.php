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
    private $type = DB_TYPE;

    /**
    * Adresse du serveur hôte.
    * @access private
    * @var string
    * @see __construct
    */
    private $host = DB_HOST;

    /**
    * Nom de la bdd.
    * @access private
    * @var string
    * @see __construct
    */
    private $dbname = DB_NAME;

    /**
    * Nom d'utilisateur
    * @access private
    * @var string
    * @see __construct
    */
    private $username = DB_USERNAME;

    /**
    * Mot de passe
    * @access private
    * @var string
    * @see __construct
    */
    private $password = DB_PASSWORD;

    private $pdo;

    private function __construct() {
        try{
            $this->pdo = new PDO(
                $this->type.':host='.$this->host.'; dbname='.$this->dbname,
                $this->username,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            $req = "SET NAMES UTF8";
            $result = $this->pdo->prepare($req);
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
    * Retourne l'objet PDO permettant de manipuler la base de donnée.
    * @return $pdo
    */
    public function getPdo()
    {
        return $this->pdo;
    }
}

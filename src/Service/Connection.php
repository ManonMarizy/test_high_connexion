<?php

namespace App\Service;

use \PDO;

class Connection
{
    private PDO $pdoConnection;

    private $user;

    private $host;

    private $password;

    private $dbName;

    public function __construct($app_db_user, $app_db_host, $app_db_pwd, $app_db_name)
    {

        $this->user = $app_db_user;
        $this->host = $app_db_host;
        $this->password = $app_db_pwd;
        $this->dbName = $app_db_name;

        try {
            $this->pdoConnection = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';charset=utf8',
                $this->user,
                $this->password
            );
            $this->pdoConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            echo('Error !: ' . $e->getMessage());
            die;
        }
    }

    /**
     * @return PDO $pdo
     */
    public function getPdoConnection(): PDO
    {
        return $this->pdoConnection;
    }
}
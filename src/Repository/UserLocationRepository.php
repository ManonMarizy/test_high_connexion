<?php

namespace App\Repository;

use App\Service\Connection;

class UserLocationRepository
{
    private $pdo;

    public function __construct(Connection $connection)
    {
        $this->pdo = $connection->getPdoConnection();
    }

    public function createTable()
    {
        $query = 'CREATE TABLE user_location (
            `phone_number` VARCHAR(10) NOT NULL PRIMARY KEY,
            `zip_code` VARCHAR(5) NOT NULL,
            `date` DATETIME NOT NULL
        );';
        $this->pdo->exec($query);
    }
    
    public function insertData(array $informations)
    {
        $query = 'INSERT INTO user_location (phone_number, zip_code, date) VALUES (:phoneNumber, :zipCode, :date)
            ON DUPLICATE KEY UPDATE date = :date, zip_code = :zipCode
            WHERE date < :date;';

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':phoneNumber', $informations['phoneNumber'], \PDO::PARAM_STR);
        $statement->bindValue(':zipCode', $informations['zipcode'], \PDO::PARAM_STR);
        $statement->bindValue(':date', $informations['date']);
        $statement->execute();

    }

}
<?php

namespace App\Repository;

use App\Service\Connection;
use PDO;

class DonationRepository
{
    private PDO $pdo;

    public function __construct(Connection $connection)
    {
        $this->pdo = $connection->getPdoConnection();
    }

    public function createTable()
    {
        $query = 'CREATE TABLE donation (
            `phone_number` VARCHAR(10) NOT NULL PRIMARY KEY,
            `total_amount` INT NOT NULL,
            UNIQUE (phone_number)
        );';
        $this->pdo->exec($query);

    }

    public function insertData(array $informations)
    {
        $query = 'INSERT INTO donation (phone_number, total_amount) VALUES  (:phoneNumber, :amount)
            ON DUPLICATE KEY UPDATE total_amount = total_amount + :amount;';

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':phoneNumber', $informations['phoneNumber']);
        $statement->bindValue(':amount', $informations['amount'], PDO::PARAM_INT);
        $statement->execute();
    }

    public function getCountOfPeoplePerAmount(): array
    {
        $query = 'SELECT COUNT(phone_number) AS nbOfPeople, total_amount
            FROM donation
            GROUP BY total_amount;
            ';
        return $this->pdo->query($query)->fetchAll();
    }
}
<?php

namespace App\Repository;

use App\Service\Connection;
use PDO;

class UserLocationRepository
{
    private PDO $pdo;

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
            ON DUPLICATE KEY UPDATE date = IF(date > VALUES(date), date, VALUES(date)), zip_code = IF(date > VALUES(date), zip_code, VALUES(zip_code));';

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':phoneNumber', $informations['phoneNumber']);
        $statement->bindValue(':zipCode', $informations['zipCode']);
        $statement->bindValue(':date', $informations['date']);
        $statement->execute();

    }

    public function getStatisticsPerDepartment(): array
    {
        $tenBestDepartment = 'SELECT classment.nbOfPeople AS nbOfPeople,  classment.department AS departments
            FROM (SELECT COUNT(phone_number) AS nbOfPeople, SUBSTR(zip_code,4) AS department
            FROM user_location
            GROUP BY SUBSTR(zip_code,4)
            ORDER BY nbOfPeople DESC) AS classment
            LIMIT 10;';
        $tenBestDepartment = $this->pdo->query($tenBestDepartment)->fetchAll();

        $otherDepartments = 'SELECT SUM(otherDepartment.nbOfPeople) AS nbOfPeople
            FROM (
                     SELECT classment.nbOfPeople
                     FROM (
                              SELECT COUNT(phone_number) AS nbOfPeople, SUBSTR(zip_code, 4) AS department
                              FROM user_location
                              GROUP BY SUBSTR(zip_code, 4)
                              ORDER BY nbOfPeople DESC) AS classment
            
                              LEFT JOIN (
                         SELECT classment.department
                         FROM (SELECT COUNT(phone_number) AS nbOfPeople, SUBSTR(zip_code, 4) AS department
                               FROM user_location
                               GROUP BY SUBSTR(zip_code, 4)
                               ORDER BY nbOfPeople DESC) AS classment
                         LIMIT 10
                     ) AS tenClassment
                              ON classment.department = tenClassment.department
                 ) AS otherDepartment;';
        $otherDepartments  = $this->pdo->query($otherDepartments )->fetch();

        return [
            'tenDepartments' => $tenBestDepartment,
            'otherDepartments' => $otherDepartments
        ];
    }

}
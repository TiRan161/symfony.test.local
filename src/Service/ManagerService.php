<?php


namespace App\Service;


use Doctrine\DBAL\Connection;

class ManagerService
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function getData($where)
    {
        $sql = 'select m.id as id, m.code as code, m.photo as photo, m.surname as surname, m.name as name, ';
        $sql.= 'm.middle_name as middleName, m.email as email, br.id as branchId, br.name as branchName from manager m ';
        $sql.= 'left join branch br on br.id = m.branch_id ';
        if (isset($where)) {
            $sql.= $where;
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $managers = [];
        while ($row = $stmt->fetch()) {
            $managers[] = [
                'id' => $row['id'],
                'code' => $row['code'],
                'photo' => $row['photo'],
                'surname' => $row['surname'],
                'name' => $row['name'],
                'middleName' => $row['middleName'],
                'email' => $row['email'],
                'branch' => [
                    'id' => $row['branchId'],
                    'name' => $row['branchName'],
                ]
            ];
        }
        return $managers;
    }

}
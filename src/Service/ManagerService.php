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

    public function getViewAllByIds($ids)
    {
        $sql = 'select m.id as id, m.code as code, m.surname as surname, m.name as name, ';
        $sql .= 'm.middle_name as middleName, br.id as branchId, br.name as branchName from manager m ';
        $sql .= 'left join branch br on br.id = m.branch_id where m.id in (' . implode(',', $ids) . ') '; //!
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $this->formatFetch($stmt);
    }

    public function getIds()
    {
        $sql = 'select id from manager';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $ids = [];
        while ($row = $stmt->fetch()) {
            $ids[] = $row['id'];
        }
        return $ids;
    }

    public function getManagersByBranch($branchId)
    {
        $sql = 'select m.id as id, m.code as code, m.surname as surname, m.name as name, ';
        $sql .= 'm.middle_name as middleName, br.id as branchId, br.name as branchName from manager m ';
        $sql .= 'left join branch br on br.id = m.branch_id where br.id = :branchId'; //!
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('branchId', $branchId);
        $stmt->execute();
        return $this->formatFetch($stmt);
    }

    public function getPersonalManager($code)
    {
        $sql = 'select m.id as id, m.code as code, m.photo as photo, m.surname as surname, m.name as name, ';
        $sql .= 'm.middle_name as middleName, m.email as email, m.branch_id as branchId, br.name as branchName from manager m ';
        $sql .= 'left join branch br on br.id = m.branch_id where m.code = :code'; //!
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('code', $code);
        $stmt->execute();
        $managers = $stmt->fetch();
        return $managers;
    }

    public function removeManager($id)
    {
        $sql = 'delete from manager where id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        return true;

    }

    public function writeManager(array $data)
    {

    }

    private function formatFetch($stmt)
    {
        $managers = [];
        while ($row = $stmt->fetch()) {
            $managers[] = [
                'id' => $row['id'],
                'code' => $row['code'],
                'surname' => $row['surname'],
                'name' => $row['name'],
                'middleName' => $row['middleName'],
                'branch' => [
                    'id' => $row['branchId'],
                    'name' => $row['branchName'],
                ]
            ];
        }
        return $managers;
    }

}
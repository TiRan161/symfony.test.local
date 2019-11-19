<?php


namespace App\Service;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;
use Exception;
use phpDocumentor\Reflection\Types\Integer;

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
// добавить проверку каждого поля в массиве на пустоту!
    public function writeManager(array $data)
    {
        $this->conn->beginTransaction();
        try {
            $sql = 'insert into manager (branch_id, code, surname, name, middle_name, email, photo) ';
            $sql .= 'values (:branchId, :code, :surname, :name, :middleName, :email, :photo)';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue('branchId', $data['branch'], ParameterType::INTEGER);
            $stmt->bindValue('code', $data['code']);
            $stmt->bindValue('surname', $data['surname']);
            $stmt->bindValue('name', $data['name']);
            $stmt->bindValue('middleName', $data['middleName']);
            $stmt->bindValue('email', $data['email']);
            $stmt->bindValue('photo', $data['photo']);
            $stmt->execute();
            return $this->conn->commit();
        } catch (Exception $e) {
            return $this->conn->rollBack();
        }
    }

    public function updateManager(array $data)
    {
        $this->conn->beginTransaction();
        try {
            $sql = 'update manager set surname = :surname, name = :name, middle_name = :middleName, email = :email, ';
            $sql .= 'photo = :photo, branch_id = :branchId where code = :code';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue('surname', $data['surname']);
            $stmt->bindValue('name', $data['name']);
            $stmt->bindValue('middleName', $data['middleName']);
            $stmt->bindValue('photo', $data['photo']);
            $stmt->bindValue('branchId', $data['branch']);
            $stmt->bindValue('email', $data['email']);
            $stmt->bindValue('code', $data['code']);
            $stmt->execute();
            return $this->conn->commit();
        } catch (Exception $e) {
            return $this->conn->rollBack();
        }

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
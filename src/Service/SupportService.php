<?php


namespace App\Service;


use Doctrine\DBAL\Connection;

class SupportService
{

    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function getUuid()
    {
        if (function_exists('com_create_guid') === true)
        {
            $uuid=trim(com_create_guid(), '{}');
            $result =$uuid;
        }
        else
        {
            $data = openssl_random_pseudo_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
            $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
            $result = $uuid;
        }

        return $result;
    }

    public function testSelect($id)
    {
        $sql = 'select m.id as manager_id, m.name as manager_name,  from manager m ';
        $sql .= 'left join branch b on b.id = m.branch_id where m.id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();

        $managerById = null;
        while ($row = $stmt->fetch()) {
            $managerById = $row;
        }
        return $managerById;
    }

    /**
     * @param array $data
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function testInsert(array $data)
    {
        $this->conn->beginTransaction();
        try {
            $sql = 'insert into manager (branch_id, code, name, surname, email, photo, middle_name) ';
            $sql .= 'values (:branch_id, :code, :name, :surname, :email, :photo, :middle_name)';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue('branch_id', $data['branch_id']);
            $stmt->bindValue('created_at', new \DateTime($data['createdAt']), 'datetime');
            // ......
            $stmt->execute();
            $this->conn->commit();
        } catch (\Exception $e) {
            $this->conn->rollBack();
        }
    }

    /**
     * @param $id
     * @param $newName
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function testUpdate($id, $newName)
    {
        $this->conn->beginTransaction();
        try {
            $sql = 'update manager set name = :name where id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue('id', $id);
            $stmt->bindValue('name', $newName);
            $stmt->execute();
            $this->conn->commit();
        } catch (\Exception $exception) {
            $this->conn->rollBack();
        }


    }

}
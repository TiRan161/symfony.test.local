<?php


namespace App\Service;


use Doctrine\DBAL\Connection;

class BranchService
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function getAllBranch()
    {
        $sql = 'select br.id as id, br.name as name from branch br';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $branchData = [];
        while ($row = $stmt->fetch()){
            $branchData[] = [
                'id' => $row['id'],
                'name' => $row['name'],
            ];
        }
        return $branchData;
    }

    public function getBranchById($id)
    {
        $sql = 'select br.id as id, br.name as name from branch br where id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $branch = [];
        while ($row = $stmt->fetch()){
            $branch[] = [
                'id'=> $row['id'],
                'name' => $row['name'],
            ];
        }
        return $branch;
    }

}
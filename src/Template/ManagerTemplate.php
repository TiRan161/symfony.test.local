<?php


namespace App\Template;


class ManagerTemplate
{
    public function getManagerTemplate(?array $data = null)
    {
        return [
            'code' => $data['code'] ?? '',
            'photo' => $data['photo'] ?? '',
            'name' => $data['name'] ?? '',
            'middleName' => $data['middleName'] ?? '',
            'surname' => $data['surname'] ?? '',
            'email' => $data['email'] ?? '',
            'branch' => [
                'id' => $data['branchId'] ?? '',
                'name' => $data['branchName'] ?? '',
            ],
        ];
    }


}
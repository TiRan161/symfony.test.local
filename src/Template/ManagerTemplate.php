<?php


namespace App\Template;


class ManagerTemplate
{
    public function getManagerTemplate(?array $data = null)
    {
        return [
            'photo' => !empty($data['photo']) ?: '',
            'name' => empty($data['name']) ? '' : $data['name'],
            'middleName' => !empty($data['middleName']) ?: '',
            'surname' => !empty($data['surname']) ?: '',
            'email' => !empty($data['email']) ?: '',
            'branch' => !empty($data['branch']['id']) ?: '',
        ];
    }

}
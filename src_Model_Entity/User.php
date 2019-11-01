<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class User extends Entity
{

    protected $_accessible = [
        'username' => true,
        'password' => true,
        'status' => true,
        'role' => true,
        'pr' => true,
        'create_datetime' => true,
        'messages' => true
    ];

    protected $_hidden = [
        'password'
    ];
    
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            $hasher = new DefaultPasswordHasher();
            return $hasher->hash($password);
        }
    }
}

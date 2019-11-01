<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Message extends Entity
{
 
    protected $_accessible = [
        'status' => true,
        'user_id' => true,
        'category_id' => true,
        'title' => true,
        'body' => true,
        'create_datetime' => true,
        'user' => true,
        'category' => true
    ];
}

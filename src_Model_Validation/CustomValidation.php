<?php
namespace App\Model\Validation;
use Cake\Validation\Validation;

class CustomValidation extends Validation {
  /**
   * ユーザー名バリデート
   * @param string $username
   * @return bool
   */
    public static function validateUsername($username) {
        return stripos($username, 'admin') !== 0 ? true : false; 
    }
}
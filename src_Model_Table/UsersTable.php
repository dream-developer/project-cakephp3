<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Messages', [
            'foreignKey' => 'user_id'
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator->setProvider('custom', 'App\Model\Validation\CustomValidation');
        
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 64)
            ->requirePresence('username', 'create')
            ->notEmptyString('username')
            ->add('username', 'validateusername', ['rule' => 'validateUsername', 'provider' => 'custom', 'message' => 'このユーザー名は無効です'])
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'このユーザー名は、もう既に使われています']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->notEmptyString('status');

        $validator
            ->scalar('role')
            ->maxLength('role', 20)
            ->allowEmptyString('role');

        $validator
            ->scalar('pr')
            ->allowEmptyString('pr');

        $validator
            ->dateTime('create_datetime')
            ->allowEmptyDateTime('create_datetime');

        return $validator;
    }


    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));

        return $rules;
    }
    
    public function findAuth(\Cake\ORM\Query $query, array $options)
    {
        $query->where(['Users.status' => 1]);
        return $query;
    }
}

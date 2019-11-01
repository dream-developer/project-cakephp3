<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

class AppController extends Controller
{
    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('basic_layout');
        
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
 
        //$this->loadComponent('Security');
        
        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'authenticate' => [
            'Form' => [
                'finder' => 'auth'
            ]
            ],
            'loginRedirect' => ['controller' => 'Messages','action' => 'index']
        ]);
     
       if($this->request->getParam('action') === 'index'){
            if(isset($user['role']) && $user['role'] === 'admin'){
                return true;
            } 
            return false;
        }
        
    }
    
    public function isAuthorized($user)
    {
        if(isset($user['role']) && $user['role'] === 'admin'){
            return true;
        } 

        return false;
    }
}

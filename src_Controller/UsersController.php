<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event; 
use Cake\Datasource\ConnectionManager;

class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // loginは許可に追加しないこと
        $this->Auth->allow(['add', 'logout']);
    }
        
    public function isAuthorized($user)
    {
        if($this->request->getParam('action') === 'index'){
            if(isset($user['role']) && $user['role'] === 'admin'){
                return true;
            } 
            return false;
        }
        return true;
    }
    
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('ユーザー名かパスワードが違います');
        }
    }
    
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Messages']
        ]);        
        $connection = ConnectionManager::get('default');
        $cate_assoc = $connection->execute('SELECT * FROM categories')->fetchAll('assoc');   
        $cate_list = array_column($cate_assoc, 'name', 'id');
        $this->set(compact('user', 'cate_list'));
    }
    
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->status = 1;         
            $user->role = 'user';
            if ($this->Users->save($user)) {
                $this->Flash->success(__('登録しました。ユーザー名とパスワードでログインしてください'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function edit()
    {
        $id = $this->Auth->user('id');
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function delete()
    {
        $id = $this->Auth->user('id');
        $this->request->allowMethod(['post', 'delete']);
        
        $user = $this->Users->newEntity();
        $user->id = $id;         
        $user->status = 2;         
        if ($this->Users->save($user)) {
            
            $this->Flash->success(__('The user has been deleted.'));
            return $this->redirect(['action' => 'logout']);
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
    }
}

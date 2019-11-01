<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Network\Exception\NotFoundException;


class MessagesController extends AppController
{
    public function index()
    {
        $conditions = array('Messages.status' => 1, 'Users.status' => 1);
        $this->paginate = [
            'contain' => ['Users', 'Categories'], 
            'conditions' => $conditions
        ];
        $messages = $this->paginate($this->Messages);        
        $auth_user_id = $this->Auth->user('id');
        $this->set(compact('messages', 'auth_user_id'));
    }

    public function isAuthorized($user)
    {
        return true;
    }

    public function view($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => ['Users', 'Categories']
        ]);               
        if($message->status !== 1 or $message->user->status !== 1){
            $this->render('/Original/invalid');
            return;
        }
        $this->set('message', $message);
    }

    public function add()
    {
        $message = $this->Messages->newEntity();
        if ($this->request->is('post')) {
            $message = $this->Messages->patchEntity($message, $this->request->getData());
            $message->status = 1; 
            $message->user_id = $this->Auth->user('id'); 
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
        // この行は削除 $users = $this->Messages->Users->find('list', ['limit' => 200]);
        $categories = $this->Messages->Categories->find('list', ['limit' => 200]);
        $this->set(compact('message', 'users', 'categories'));
    }

    public function edit($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => ['Users']
        ]);
        if($message->status !== 1 or 
           $message->user->status !== 1 or
           $message->user_id !== $this->Auth->user('id'))
        {
            $this->render('/Original/invalid');
            return;
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $message = $this->Messages->patchEntity($message, $this->request->getData());
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
        $users = $this->Messages->Users->find('list', ['limit' => 200]);
        $categories = $this->Messages->Categories->find('list', ['limit' => 200]);
        $this->set(compact('message', 'users', 'categories'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);   
        $message = $this->Messages->get($id, ['contain' => ['Users']]);
        if($message->status !== 1 or 
           $message->user->status !== 1 or
           $message->user_id !== $this->Auth->user('id'))
        {

            $this->render('/Original/invalid');
            return;
        }
        $message->status = 2;
        if ($this->Messages->save($message)) {
            $this->Flash->success(__('The message has been deleted.'));
        } else {
            $this->Flash->error(__('The message could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

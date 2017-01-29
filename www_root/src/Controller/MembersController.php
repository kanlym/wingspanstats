<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Members Controller
 *
 * @property \App\Model\Table\MembersTable $Members
 */
class MembersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Characters', 'Corporations']
        ];
        $members = $this->paginate($this->Members);

        $this->set(compact('members'));
        $this->set('_serialize', ['members']);
    }

    /**
     * View method
     *
     * @param string|null $id Member id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $member = $this->Members->get($id, [
            'contain' => ['Characters', 'Corporations']
        ]);

        $this->set('member', $member);
        $this->set('_serialize', ['member']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $member = $this->Members->newEntity();
        if ($this->request->is('post')) {
            $member = $this->Members->patchEntity($member, $this->request->data);
            if ($this->Members->save($member)) {
                $this->Flash->success(__('The member has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The member could not be saved. Please, try again.'));
            }
        }
        $characters = $this->Members->Characters->find('list', ['limit' => 200]);
        $corporations = $this->Members->Corporations->find('list', ['limit' => 200]);
        $this->set(compact('member', 'characters', 'corporations'));
        $this->set('_serialize', ['member']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Member id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $member = $this->Members->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $member = $this->Members->patchEntity($member, $this->request->data);
            if ($this->Members->save($member)) {
                $this->Flash->success(__('The member has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The member could not be saved. Please, try again.'));
            }
        }
        $characters = $this->Members->Characters->find('list', ['limit' => 200]);
        $corporations = $this->Members->Corporations->find('list', ['limit' => 200]);
        $this->set(compact('member', 'characters', 'corporations'));
        $this->set('_serialize', ['member']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Member id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $member = $this->Members->get($id);
        if ($this->Members->delete($member)) {
            $this->Flash->success(__('The member has been deleted.'));
        } else {
            $this->Flash->error(__('The member could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

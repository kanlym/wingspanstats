<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tripwirestats Controller
 *
 * @property \App\Model\Table\TripwirestatsTable $Tripwirestats
 */
class TripwirestatsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Characters']
        ];
        $tripwirestats = $this->paginate($this->Tripwirestats);

        $this->set(compact('tripwirestats'));
        $this->set('_serialize', ['tripwirestats']);
    }

    /**
     * View method
     *
     * @param string|null $id Tripwirestat id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tripwirestat = $this->Tripwirestats->get($id, [
            'contain' => ['Characters']
        ]);

        $this->set('tripwirestat', $tripwirestat);
        $this->set('_serialize', ['tripwirestat']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tripwirestat = $this->Tripwirestats->newEntity();
        if ($this->request->is('post')) {
            $tripwirestat = $this->Tripwirestats->patchEntity($tripwirestat, $this->request->data);
            if ($this->Tripwirestats->save($tripwirestat)) {
                $this->Flash->success(__('The tripwirestat has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The tripwirestat could not be saved. Please, try again.'));
            }
        }
        $characters = $this->Tripwirestats->Characters->find('list', ['limit' => 200]);
        $this->set(compact('tripwirestat', 'characters'));
        $this->set('_serialize', ['tripwirestat']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tripwirestat id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tripwirestat = $this->Tripwirestats->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tripwirestat = $this->Tripwirestats->patchEntity($tripwirestat, $this->request->data);
            if ($this->Tripwirestats->save($tripwirestat)) {
                $this->Flash->success(__('The tripwirestat has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The tripwirestat could not be saved. Please, try again.'));
            }
        }
        $characters = $this->Tripwirestats->Characters->find('list', ['limit' => 200]);
        $this->set(compact('tripwirestat', 'characters'));
        $this->set('_serialize', ['tripwirestat']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tripwirestat id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tripwirestat = $this->Tripwirestats->get($id);
        if ($this->Tripwirestats->delete($tripwirestat)) {
            $this->Flash->success(__('The tripwirestat has been deleted.'));
        } else {
            $this->Flash->error(__('The tripwirestat could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

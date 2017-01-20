<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Monthstats Controller
 *
 * @property \App\Model\Table\MonthstatsTable $Monthstats
 */
class MonthstatsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $monthstats = $this->paginate($this->Monthstats);

        $this->set(compact('monthstats'));
        $this->set('_serialize', ['monthstats']);
    }

    /**
     * View method
     *
     * @param string|null $id Monthstat id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $monthstat = $this->Monthstats->get($id, [
            'contain' => []
        ]);

        $this->set('monthstat', $monthstat);
        $this->set('_serialize', ['monthstat']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $monthstat = $this->Monthstats->newEntity();
        if ($this->request->is('post')) {
            $monthstat = $this->Monthstats->patchEntity($monthstat, $this->request->data);
            if ($this->Monthstats->save($monthstat)) {
                $this->Flash->success(__('The monthstat has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The monthstat could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('monthstat'));
        $this->set('_serialize', ['monthstat']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Monthstat id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $monthstat = $this->Monthstats->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $monthstat = $this->Monthstats->patchEntity($monthstat, $this->request->data);
            if ($this->Monthstats->save($monthstat)) {
                $this->Flash->success(__('The monthstat has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The monthstat could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('monthstat'));
        $this->set('_serialize', ['monthstat']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Monthstat id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $monthstat = $this->Monthstats->get($id);
        if ($this->Monthstats->delete($monthstat)) {
            $this->Flash->success(__('The monthstat has been deleted.'));
        } else {
            $this->Flash->error(__('The monthstat could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

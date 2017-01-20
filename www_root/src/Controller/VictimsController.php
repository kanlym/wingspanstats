<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Victims Controller
 *
 * @property \App\Model\Table\VictimsTable $Victims
 */
class VictimsController extends AppController
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
        $victims = $this->paginate($this->Victims);

        $this->set(compact('victims'));
        $this->set('_serialize', ['victims']);
    }

    /**
     * View method
     *
     * @param string|null $id Victim id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $victim = $this->Victims->get($id, [
            'contain' => ['Characters']
        ]);

        $this->set('victim', $victim);
        $this->set('_serialize', ['victim']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $victim = $this->Victims->newEntity();
        if ($this->request->is('post')) {
            $victim = $this->Victims->patchEntity($victim, $this->request->data);
            if ($this->Victims->save($victim)) {
                $this->Flash->success(__('The victim has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The victim could not be saved. Please, try again.'));
            }
        }
        $characters = $this->Victims->Characters->find('list', ['limit' => 200]);
        $this->set(compact('victim', 'characters'));
        $this->set('_serialize', ['victim']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Victim id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $victim = $this->Victims->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $victim = $this->Victims->patchEntity($victim, $this->request->data);
            if ($this->Victims->save($victim)) {
                $this->Flash->success(__('The victim has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The victim could not be saved. Please, try again.'));
            }
        }
        $characters = $this->Victims->Characters->find('list', ['limit' => 200]);
        $this->set(compact('victim', 'characters'));
        $this->set('_serialize', ['victim']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Victim id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $victim = $this->Victims->get($id);
        if ($this->Victims->delete($victim)) {
            $this->Flash->success(__('The victim has been deleted.'));
        } else {
            $this->Flash->error(__('The victim could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

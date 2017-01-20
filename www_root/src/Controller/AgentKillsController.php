<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Agentkills Controller
 *
 * @property \App\Model\Table\AgentkillsTable $Agentkills
 */
class AgentkillsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $agentkills = $this->paginate($this->Agentkills);

        $this->set(compact('agentkills'));
        $this->set('_serialize', ['agentkills']);
    }

    /**
     * View method
     *
     * @param string|null $id Agentkill id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $agentkill = $this->Agentkills->get($id, [
            'contain' => []
        ]);

        $this->set('agentkill', $agentkill);
        $this->set('_serialize', ['agentkill']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $agentkill = $this->Agentkills->newEntity();
        if ($this->request->is('post')) {
            $agentkill = $this->Agentkills->patchEntity($agentkill, $this->request->data);
            if ($this->Agentkills->save($agentkill)) {
                $this->Flash->success(__('The agentkill has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The agentkill could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('agentkill'));
        $this->set('_serialize', ['agentkill']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Agentkill id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $agentkill = $this->Agentkills->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $agentkill = $this->Agentkills->patchEntity($agentkill, $this->request->data);
            if ($this->Agentkills->save($agentkill)) {
                $this->Flash->success(__('The agentkill has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The agentkill could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('agentkill'));
        $this->set('_serialize', ['agentkill']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Agentkill id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $agentkill = $this->Agentkills->get($id);
        if ($this->Agentkills->delete($agentkill)) {
            $this->Flash->success(__('The agentkill has been deleted.'));
        } else {
            $this->Flash->error(__('The agentkill could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

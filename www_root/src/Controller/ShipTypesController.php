<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ShipTypes Controller
 *
 * @property \App\Model\Table\ShipTypesTable $ShipTypes
 */
class ShipTypesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ShipTypes']
        ];
        $shipTypes = $this->paginate($this->ShipTypes);

        $this->set(compact('shipTypes'));
        $this->set('_serialize', ['shipTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Ship Type id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shipType = $this->ShipTypes->get($id, [
            'contain' => ['ShipTypes']
        ]);

        $this->set('shipType', $shipType);
        $this->set('_serialize', ['shipType']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shipType = $this->ShipTypes->newEntity();
        if ($this->request->is('post')) {
            $shipType = $this->ShipTypes->patchEntity($shipType, $this->request->data);
            if ($this->ShipTypes->save($shipType)) {
                $this->Flash->success(__('The ship type has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ship type could not be saved. Please, try again.'));
            }
        }
        $shipTypes = $this->ShipTypes->ShipTypes->find('list', ['limit' => 200]);
        $this->set(compact('shipType', 'shipTypes'));
        $this->set('_serialize', ['shipType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ship Type id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shipType = $this->ShipTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shipType = $this->ShipTypes->patchEntity($shipType, $this->request->data);
            if ($this->ShipTypes->save($shipType)) {
                $this->Flash->success(__('The ship type has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ship type could not be saved. Please, try again.'));
            }
        }
        $shipTypes = $this->ShipTypes->ShipTypes->find('list', ['limit' => 200]);
        $this->set(compact('shipType', 'shipTypes'));
        $this->set('_serialize', ['shipType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ship Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shipType = $this->ShipTypes->get($id);
        if ($this->ShipTypes->delete($shipType)) {
            $this->Flash->success(__('The ship type has been deleted.'));
        } else {
            $this->Flash->error(__('The ship type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

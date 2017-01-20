<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Ships Controller
 *
 * @property \App\Model\Table\ShipsTable $Ships
 */
class ShipsController extends AppController
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
        $ships = $this->paginate($this->Ships);

        $this->set(compact('ships'));
        $this->set('_serialize', ['ships']);
    }

    /**
     * View method
     *
     * @param string|null $id Ship id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ship = $this->Ships->get($id, [
            'contain' => ['ShipTypes']
        ]);

        $this->set('ship', $ship);
        $this->set('_serialize', ['ship']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ship = $this->Ships->newEntity();
        if ($this->request->is('post')) {
            $ship = $this->Ships->patchEntity($ship, $this->request->data);
            if ($this->Ships->save($ship)) {
                $this->Flash->success(__('The ship has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ship could not be saved. Please, try again.'));
            }
        }
        $shipTypes = $this->Ships->ShipTypes->find('list', ['limit' => 200]);
        $this->set(compact('ship', 'shipTypes'));
        $this->set('_serialize', ['ship']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ship id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ship = $this->Ships->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ship = $this->Ships->patchEntity($ship, $this->request->data);
            if ($this->Ships->save($ship)) {
                $this->Flash->success(__('The ship has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ship could not be saved. Please, try again.'));
            }
        }
        $shipTypes = $this->Ships->ShipTypes->find('list', ['limit' => 200]);
        $this->set(compact('ship', 'shipTypes'));
        $this->set('_serialize', ['ship']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ship id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ship = $this->Ships->get($id);
        if ($this->Ships->delete($ship)) {
            $this->Flash->success(__('The ship has been deleted.'));
        } else {
            $this->Flash->error(__('The ship could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

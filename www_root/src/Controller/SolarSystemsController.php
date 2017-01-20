<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SolarSystems Controller
 *
 * @property \App\Model\Table\SolarSystemsTable $SolarSystems
 */
class SolarSystemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SolarSystems']
        ];
        $solarSystems = $this->paginate($this->SolarSystems);

        $this->set(compact('solarSystems'));
        $this->set('_serialize', ['solarSystems']);
    }

    /**
     * View method
     *
     * @param string|null $id Solar System id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $solarSystem = $this->SolarSystems->get($id, [
            'contain' => ['SolarSystems']
        ]);

        $this->set('solarSystem', $solarSystem);
        $this->set('_serialize', ['solarSystem']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $solarSystem = $this->SolarSystems->newEntity();
        if ($this->request->is('post')) {
            $solarSystem = $this->SolarSystems->patchEntity($solarSystem, $this->request->data);
            if ($this->SolarSystems->save($solarSystem)) {
                $this->Flash->success(__('The solar system has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The solar system could not be saved. Please, try again.'));
            }
        }
        $solarSystems = $this->SolarSystems->SolarSystems->find('list', ['limit' => 200]);
        $this->set(compact('solarSystem', 'solarSystems'));
        $this->set('_serialize', ['solarSystem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Solar System id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $solarSystem = $this->SolarSystems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $solarSystem = $this->SolarSystems->patchEntity($solarSystem, $this->request->data);
            if ($this->SolarSystems->save($solarSystem)) {
                $this->Flash->success(__('The solar system has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The solar system could not be saved. Please, try again.'));
            }
        }
        $solarSystems = $this->SolarSystems->SolarSystems->find('list', ['limit' => 200]);
        $this->set(compact('solarSystem', 'solarSystems'));
        $this->set('_serialize', ['solarSystem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Solar System id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $solarSystem = $this->SolarSystems->get($id);
        if ($this->SolarSystems->delete($solarSystem)) {
            $this->Flash->success(__('The solar system has been deleted.'));
        } else {
            $this->Flash->error(__('The solar system could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

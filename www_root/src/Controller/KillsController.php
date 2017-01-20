<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Kills Controller
 *
 * @property \App\Model\Table\KillsTable $Kills
 */
class KillsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        
    }
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        // $this->RequestHandler->renderAs($this, 'json');
        // $this->response->type('application/json');
        // $this->set('_serialize', true);
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Characters', 'ShipTypes', 'SolarSystems']
        ];
        $kills = $this->paginate($this->Kills);

        $this->set(compact('kills'));
        $this->set('_serialize', ['kills']);
    }

    /**
     * View method
     *
     * @param string|null $id Kill id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kill = $this->Kills->get($id, [
            'contain' => ['Characters', 'ShipTypes', 'SolarSystems', 'AgentKills']
        ]);

        $this->set('kill', $kill);
        $this->set('_serialize', ['kill']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $kill = $this->Kills->newEntity();
        if ($this->request->is('post')) {
            $kill = $this->Kills->patchEntity($kill, $this->request->data);
            if ($this->Kills->save($kill)) {
                $this->Flash->success(__('The kill has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The kill could not be saved. Please, try again.'));
            }
        }
        $characters = $this->Kills->Characters->find('list', ['limit' => 200]);
        $shipTypes = $this->Kills->ShipTypes->find('list', ['limit' => 200]);
        $solarSystems = $this->Kills->SolarSystems->find('list', ['limit' => 200]);
        $this->set(compact('kill', 'characters', 'shipTypes', 'solarSystems'));
        $this->set('_serialize', ['kill']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Kill id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kill = $this->Kills->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kill = $this->Kills->patchEntity($kill, $this->request->data);
            if ($this->Kills->save($kill)) {
                $this->Flash->success(__('The kill has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The kill could not be saved. Please, try again.'));
            }
        }
        $characters = $this->Kills->Characters->find('list', ['limit' => 200]);
        $shipTypes = $this->Kills->ShipTypes->find('list', ['limit' => 200]);
        $solarSystems = $this->Kills->SolarSystems->find('list', ['limit' => 200]);
        $this->set(compact('kill', 'characters', 'shipTypes', 'solarSystems'));
        $this->set('_serialize', ['kill']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Kill id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kill = $this->Kills->get($id);
        if ($this->Kills->delete($kill)) {
            $this->Flash->success(__('The kill has been deleted.'));
        } else {
            $this->Flash->error(__('The kill could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

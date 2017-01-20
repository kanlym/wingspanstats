<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
/*
 * Stats Controller
 *
 * @property \App\Model\Table\AgentkillsTable $Agentkills
 */
class StatsController extends AppController
{
	public function beforeRender(Event $event){
        parent::beforeRender($event);
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('application/json');
        $this->set('_serialize', true);
    }

    public function agents($dateStart = false,$dateEnd = false){
        if ($dateStart == false){
            $dateStart = date('Y-m-') ."01";
        }
        if ($dateEnd == false){
            $dateEnd = date('Y-m-',strtotime('+1 month')) ."01";
        }
        $results = $this->Stats->agents($dateStart,$dateEnd);
        $status = true;
        if (empty($results)) $status = false;
        $this->set(compact('status','results','dateStart','dateEnd'));    
        $this->set('_serialize', ['status','results']);
    }
    /**
     * Get ship stats for a given ship name [default is stratios]
     * @param  string  $shipName  [description]
     * @param  boolean $dateStart [description]
     * @param  boolean $dateEnd   [description]
     * @return [type]             [description]
     */
    public function ship($shipName = 'stratios',$dateStart = false,$dateEnd = false){
    	$status = true;
    	if ($dateStart == false){
    		$dateStart = date('Y-m-') ."01";
    	}
    	if ($dateEnd == false){
    		$dateEnd = date('Y-m-',strtotime('+1 month')) ."01";
    	}
    	$results = $this->Stats->ship($shipName,$dateStart,$dateEnd);
    	$this->set(compact('status','results','dateStart','dateEnd'));	
    	$this->set('_serialize', ['status','results']);
    }


    /**
     * Get pilot stats for specified pilot [ all kills he participated]
     * @param  string  $pilotName [description]
     * @param  boolean $dateStart [description]
     * @param  boolean $dateEnd   [description]
     * @return [type]             [description]
     */
    public function pilots($pilotName = 'Kanly Aideron',$dateStart = false,$dateEnd = false){
    	$status = true;
    	if ($dateStart == false){
    		$dateStart = date('Y-m-') ."01";
    	}
    	if ($dateEnd == false){
    		$dateEnd = date('Y-m-',strtotime('+1 month')) ."01";
    	}
    	$results = $this->Stats->pilots($pilotName,$dateStart,$dateEnd);
    	$this->set(compact('status','results','dateStart','dateEnd'));	
    	$this->set('_serialize', ['status','results']);
    }

    public function locations($dateStart = false, $dateEnd = false){
        $status = true;
        if ($dateStart == false){
            $dateStart = date('Y-m-') ."01";
        }
        if ($dateEnd == false){
            $dateEnd = date('Y-m-',strtotime('+1 month')) ."01";
        }
        $results = $this->Stats->locations($dateStart,$dateEnd);
        $this->set(compact('status','results','dateStart','dateEnd'));    
        $this->set('_serialize', ['status','results']);
    }
 
    public function solo($dateStart = false,$dateEnd = false){
        $status = true;
        if ($dateStart == false){
            $dateStart = date('Y-m-') ."01";
        }
        if ($dateEnd == false){
            $dateEnd = date('Y-m-',strtotime('+1 month')) ."01";
        }
       $results = $this->Stats->solo($dateStart,$dateEnd);
       $this->set(compact('status','results','dateStart','dateEnd'));    
       $this->set('_serialize', ['status','results']);
    }
    public function miniBlops($dateStart = false, $dateEnd = false){
        $status = true;
        if ($dateStart == false){
            $dateStart = date('Y-m-') ."01";
        }
        if ($dateEnd == false){
            $dateEnd = date('Y-m-',strtotime('+1 month')) ."01";
        }
        $results = $this->Stats->miniBlops($dateStart,$dateEnd);
       $this->set(compact('status','results','dateStart','dateEnd'));    
       $this->set('_serialize', ['status','results']);
    }
    public function getSBNemesis($dateStart = false,$dateEnd = false){
        $status = true;
        if ($dateStart == false){
            $dateStart = date('Y-m-') ."01";
        }
        if ($dateEnd == false){
            $dateEnd = date('Y-m-',strtotime('+1 month')) ."01";
        }
        $status = true;
        $solo = 0;//can be 0 
        $results = $this->Stats->getGenericByDestroyedShip(array(11377),$solo,$dateStart,$dateEnd);
        $this->set(compact('status','results','dateStart','dateEnd'));    
       $this->set('_serialize', ['status','results']);
    }
    public function getSBManticore($dateStart = false,$dateEnd = false){
        $status = true;
        if ($dateStart == false){
            $dateStart = date('Y-m-') ."01";
        }
        if ($dateEnd == false){
            $dateEnd = date('Y-m-',strtotime('+1 month')) ."01";
        }
        $status = true;
        $solo = 0;//can be 0 
        $results = $this->Stats->getGenericByDestroyedShip(array(12032),$solo,$dateStart,$dateEnd);
        $this->set(compact('status','results','dateStart','dateEnd'));    
       $this->set('_serialize', ['status','results']);
    }
    public function getSBHound($dateStart = false,$dateEnd = false){
        $status = true;
        if ($dateStart == false){
            $dateStart = date('Y-m-') ."01";
        }
        if ($dateEnd == false){
            $dateEnd = date('Y-m-',strtotime('+1 month')) ."01";
        }
        $status = true;
        $solo = 0;//can be 0 
        $results = $this->Stats->getGenericByDestroyedShip(array(12034),$solo,$dateStart,$dateEnd);
        $this->set(compact('status','results','dateStart','dateEnd'));    
       $this->set('_serialize', ['status','results']);
    }
    public function getSBPurifier($dateStart = false,$dateEnd = false){
        $status = true;
        if ($dateStart == false){
            $dateStart = date('Y-m-') ."01";
        }
        if ($dateEnd == false){
            $dateEnd = date('Y-m-',strtotime('+1 month')) ."01";
        }
        $status = true;
        $solo = 0;//can be 0 
        $results = $this->Stats->getGenericByDestroyedShip(array(12038),$solo,$dateStart,$dateEnd);
        $this->set(compact('status','results','dateStart','dateEnd'));    
       $this->set('_serialize', ['status','results']);
    }
    //test out various functions
    public function genericShipTest(){
        $status = true;
        $solo = 0;//can be 0 
        $results = $this->Stats->getGenericByDestroyedShip($this->Stats->caps,$solo,'2015-01-01','2016-01-01');
        $this->set(compact('status','results','dateStart','dateEnd'));    
       $this->set('_serialize', ['status','results']);
    }
    
    public function setCookie($dateStart = false,$dateEnd = false){
        if ($dateStart == false){
            $dateStart = date('Y-m') ."01";
        }
        if ($dateEnd == false){
            $dateEnd = date('Y-m-',strtotime('+1 month')) ."01";
        }
        $this->Cookie->write('stats',
                ['dateStart'=>$dateStart, 'dateEnd'=>$dateEnd]
                );
        $this->set(compact('status'));    
        $this->set('_serialize', ['status']);
    }

}


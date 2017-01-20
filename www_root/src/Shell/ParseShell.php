<?php
namespace App\Shell;
use Cake\Console\Shell;
use Cake\Core\Exception\Exception;
use Cake\Core\Configure;

// DON'T IF I NEED IT
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\Datasource\EntityInterface;

class ParseShell extends Shell{

	public function initialize(){
		parent::initialize();
		$this->loadModel('Characters');
		$this->loadModel('SolarSystems');
		$this->loadModel('ShipTypes');
		$this->loadModel('Kills');
		$this->loadModel('Corporations');
		$this->loadModel('AgentKills');
		$this->loadModel('Monthstats');
	}

	
	public function checkIfAgentExists($character_id){
		$character = false;
		try{
			$character = $this->Characters->find('all')->where(['Characters.character_id = ' => $character_id]);
			
			$result = $character->all()->toArray();
			
			
			if (empty($result)) throw new Exception(__('_noUserFound'));
		}
		catch(Exception $e){
			// $this->out($e->getMessage());
			return false;
		}
		return true;
		
	}

	public function checkIfCorpExists($corporation_id){
		$corporation = false;
		try{
			$corporation = $this->Corporations->find('all')->where(['Corporations.corporation_id = ' => $corporation_id]);
			
			$result = $corporation->all()->toArray();
			
			
			if (empty($result)) throw new Exception(__('_noCorpFOund'));
		}
		catch(Exception $e){
			// $this->out($e->getMessage());
			return false;
		}
		return true;
		
	}

	public function checkIfKillExists($kill_id){
		$ss = false;
		try{
			$ss = $this->Kills->find('all')->where(['Kills.kill_id = ' => $kill_id]);
			$result = $ss->all()->toArray();
			if (empty($result)) throw new Exception(__('_noKillFound'));
		}
		catch(Exception $e){
			// $this->out($e->getMessage());
			return false;
		}
		return true;
		
	}
	public function checkIfAgentIsOnKill($kill_id,$agent_id){
		$ss = false;
		try{
			$ss = $this->AgentKills->find('all')->where(['AgentKills.kill_id = ' => $kill_id,'AgentKills.character_id'=>$agent_id]);
			$result = $ss->all()->toArray();
			if (empty($result)) throw new Exception(__('_noConnectionFound'));
		}
		catch(Exception $e){
			// $this->out($e->getMessage());
			return false;
		}
		return true;
	}

	public function checkIfShipExists($ship_type_id){
		$ss = false;
		try{
			$ss = $this->ShipTypes->find('all')->where(['ShipTypes.ship_type_id = ' => $ship_type_id]);
			$result = $ss->all()->toArray();
			if (empty($result)) throw new Exception(__('_noShipTypeFound'));
		}
		catch(Exception $e){
			// $this->out($e->getMessage());
			return false;
		}
		return true;
		
	}

	public function checkIfSolarSystemExists($solarsystem_id){
		$ss = false;
		try{
			$ss = $this->SolarSystems->find('all')->where(['SolarSystems.solar_system_id = ' => $solarsystem_id]);
			$result = $ss->all()->toArray();
			if (empty($result)) throw new Exception(__('_noSolarSystem'));
		}
		catch(Exception $e){
			// $this->out($e->getMessage());
			return false;
		}
		return true;
		
	}
	public function addCharacter($c){
		try{
			$c['id'] = $c['character_id'];
			if ($this->checkIfAgentExists((int)$c['character_id'])) throw new Exception('Character exists');
			$character = $this->Characters->newEntity();
			$character = $this->Characters->patchEntity($character,$c);
			$character->character_id = $c['id'];
			// die();
			if ($this->Characters->save($character)){

				// $this->out("Salvat");
				return true;
			}else{
				// $this->out("Character - NOT Salvat");
				return false;
			}	
		}catch (Exception $e){
			// $this->Log($e->getMessage());
			return false;
		}
		return true;
		
	}
	public function addCorporation($c){
		try{
			
			if ($this->checkIfCorpExists((int)$c['corporation_id'])) throw new Exception('Corp exists');
			$corp = $this->Corporations->newEntity();
			$corp = $this->Corporations->patchEntity($corp,$c);
			$corp->corporation_id = $c['corporation_id'];

			// die();
			if ($this->Corporations->save($corp)){

				// $this->out("Salvat");
				return true;
			}else{
				$this->out("Corp - NOT Salvat");
				return false;
			}	
		}catch (Exception $e){
			// $this->Log($e->getMessage());
			return false;
		}
		return true;
		
	}
	public function addAgentToKill($c){
		try{
			
			if ($this->checkIfAgentIsOnKill((int)$c['kill_id'],(int)$c['character_id'])) throw new Exception('Char is on kill already');
			$agk = $this->AgentKills->newEntity();
			$agk = $this->AgentKills->patchEntity($agk,$c);
			// $agk->agkoration_id = $c['agkoration_id'];

			// die();
			if ($this->AgentKills->save($agk)){

				// $this->out("Salvat");
				return true;
			}else{
				debug($agk);
				die();
				$this->out("AgentKill - NOT Salvat");
				return false;
			}	
		}catch (Exception $e){
			// $this->Log($e->getMessage());
			return false;
		}
		return true;
		
	}
	public function addSystems($s){
		try{
			if ($this->checkIfSolarSystemExists((int)$s['solar_system_id'])) throw new Exception('SolarSystems exists');
			$SolarSystems = $this->SolarSystems->newEntity();
			$SolarSystems = $this->SolarSystems->patchEntity($SolarSystems,$s);
			$SolarSystems->solar_system_id = $s['solar_system_id'];
			if ($this->SolarSystems->save($SolarSystems)){

				// $this->out("Salvat");
				return true;
			}else{
				$this->out("NOT Salvat");
				return false;
			}	
		}catch (Exception $e){
			// $this->Log($e->getMessage());
			return false;
		}
		return true;
		
	}

	public function addShips($s){
		try{
			if ($this->checkIfShipExists((int)$s['ship_type_id'])) throw new Exception('ship_type_id exists');
			$ship = $this->ShipTypes->newEntity();
			$ship = $this->ShipTypes->patchEntity($ship,$s);
			if ($this->ShipTypes->save($ship)){

				// $this->out("Salvat");
				return true;
			}else{
				$this->out("NOT Salvat");
				return false;
			}	
		}catch (Exception $e){
			// $this->Log($e->getMessage());
			return false;
		}
		return true;
		
	}
 	public function updateCorporationForUser($character_id, $corp_id){

 		$c = $this->Characters->get($character_id);
 		$c->corporation_id = $corp_id;
 		$this->Characters->save($c);
 	}
	public function addKill($s){
		try{
			if ($this->checkIfKillExists((int)$s['kill_id'])) throw new Exception('kill_id exists');
			$ship = $this->Kills->newEntity();
			$ship = $this->Kills->patchEntity($ship,$s);
			$ship->kill_id = $s['kill_id'];		
			// debug($ship);die();
			if ($this->Kills->save($ship)){

				// $this->out("Salvat");
				return true;
			}else{
				$this->out($ship);
				$this->out("NOT Salvat");
				return false;
			}	
		}catch (Exception $e){
			$this->Log($s);
			$this->Log($e->getMessage());
			return false;
		}
		return true;
		
	}

	public function parseJsonAgents($date = '2017-01'){
		 $root = WWW_ROOT.'results/'.$date.'/';
		 $data = file_get_contents($root.'agents.json');
         $agentData = json_decode($data);
         foreach ($agentData->agents as $a){
         	$c = array(
         		'character_name' => $a->character_name,
         		'character_id' =>(int)$a->character_id
         		);
         	// debug($c);die();
         	$this->addCharacter($c);
         }
         $root = WWW_ROOT.'results/'.$date.'/';
		 $data = file_get_contents($root.'kills.json');
         $agentData = json_decode($data);
         foreach ($agentData->kills as $a){
         	$c = array(
         		'character_name' => ($a->character_id == 0 ? 'Unknown':$a->character_name),
         		'character_id' =>(int)$a->character_id
         		);
         	// debug($c);die();
         	$this->addCharacter($c);
         }
         $root = WWW_ROOT.'results/'.$date.'/';
		 $data = file_get_contents($root.'victims.json');
         $agentData = json_decode($data);
         foreach ($agentData->victims as $a){
         	$c = array(
         		'character_name' => ($a->character_id == 0 ? 'Unknown':$a->character_name),
         		'character_id' =>(int)$a->character_id
         		);
         	// debug($c);die();
         	$this->addCharacter($c);
         }
        // usort($agentData->agents,'cmpISK');
	}
	public function parseJsonSystems(){
		$root = WWW_ROOT.'results/inputdata/';
		$data = file_get_contents($root.'systems.json');
        $agentData = json_decode($data);

	     foreach ($agentData->systems as $id => $data){
	     	$wh = 0;
	     	$effect = 'None';
	     	if ($data->security >= 0.5) $type = 'HighSec';
	     	elseif ($data->security > 0.0) $type = 'LowSec';
	     	elseif ($data->security <= 0.0) {
	     		$type = 'NullSec';
	     		if (isset($data->class)){
	     			$type = $data->class;
	     			$effect = (isset($data->effect) ? $data->effect : 'None');
	     			$wh = 1;
	     		}
	     	}
	     	$this->addSystems([
	     						'solar_system_id'=>$id,
	     						'name'=>$data->name,
	     						'security'=>$data->security,
	     						'type'=> $type,
	     						'isWh'=> $wh,
	     						'effect'=>$effect

	     						]);
	     	// $this->out("System $id is " . $data->name);
	     }
	}

	public function parseShipTypes($date = '2017-01'){
		 $root = WWW_ROOT.'results/'.$date.'/';
		 $data = file_get_contents($root.'ships.json');
         $agentData = json_decode($data);
         foreach ($agentData->ships as $a){
         	$c = array(
         		'name' => ($a->ship_type_id == 0 ? 'Unknown':$a->ship_name),
         		'ship_type_id' =>(int)$a->ship_type_id
         		);
         	// debug($c);die();
         	$this->addShips($c);
         }
	}

	//
	//should modify tfor item id and value to update with real name as there seems to be a bit of a debate upon what 
	//the fuck the item type id really is
	public function parseKills($date = '2017-01'){
		 $root = WWW_ROOT.'results/'.$date.'/';
		 $data = file_get_contents($root.'kills.json');
         $agentData = json_decode($data);
         $this->out("File is $root/kills.json");
         
         foreach ($agentData->kills as $a){
         	$c = array(
         		'solar_system_id' => (int) $a->solar_system_id,
         		'character_id' =>(int)$a->character_id,
         		'value' => (float) $a->value,
         		'kill_id'=>$a->kill_id,
         		'date' => $a->date,
         		'ship_type_id'=>$a->ship_type_id,
         		'agent_id'=>$a->agent_id,
         		'totalWingspanPct' => $a->totalWingspanPct * 100,
         		'partiesInvolved' => $a->wingspanAgents + $a->thirdParty,
         		'isExplorer' => $a->isExplorer,
         		'isOurLoss' => $a->isOurLoss,
         		'corporation_id'=>$a->corporation_id
         		);
         	if ($this->addKill($c)){
         		foreach ($a->attackers as $atc){
	         		//parsam corporati
	         		$corp = array(
	         			'corporation_id'=>$atc->corporation_id,
	         			'corporation_name'=>$atc->corporation_name
	         			);
	         		$user = array(
	         			'character_id' => $atc->character_id,
	         			'character_name'=>$atc->character_name,
	         			);
	         		$this->addCharacter($user);
	         		$this->addCorporation($corp);
	         		$this->updateCorporationForUser($atc->character_id,$atc->corporation_id);
	         		//linking agent to kill
	         		$atokill = array(
	         			'kill_id'=>$a->kill_id,
	         			'character_id'=>$atc->character_id,
	         			'killingBlow'=>$atc->killingBlow,
	         			'ship_type_id'=>$atc->ship_type_id,
	         			'damageDone'=>$atc->damageDone,
	         			'corporation_id'=>$atc->corporation_id,
	         			'wasBombing' => $atc->wasBombing
	         			);
	         		$this->addAgentToKill($atokill);
	         	}
         	}
         	
         	// debug($c);die();
         	
         }
	}



	// public function parseAgents()
	// public function parseAKills()
	// public function parseShips()
	// public function parsevictims
	public function parseOldData(){
		for ($i = 2016; $i<2017; $i++){
			for ($j = 6; $j <13;$j++){
				// $i = 2016;
				// $j = 10;
				if ($j < 10) $str = "$i-0$j"; 
				else $str= "$i-$j";
				$this->Log("Parsing file " . $str);
				$this->parseJsonAgents($str);
				$this->parseKills($str);		
			}
		}
	}
	public function parseCurrentMonth(){
				$str = date('Y') . '-' . (date('m') < 10 ? date('m') : date('m'));
				$this->parseJsonAgents($str);
				$this->parseKills($str);		
	}
	public function main(){
		// $this->updateCorporationForUser(0,1);die();
		$this->parseOldData();
		$this->parseCurrentMonth();
		// $this->parseJsonSystems();
		// $this->parseKills();
		// $this->parseShipTypes();
		// $this->checkIfAgentExists(1);
		// $c = ['character_name' =>"Test",
 	// 				'character_id'=>1
 	// 				];
		// $this->addCharacter($c);
		
	}
}
?>
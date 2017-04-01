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
use Cake\Datasource\ConnectionManager;
class TripwireShell extends Shell{
	public $USER_AGENT = "Kanly Stats WHY VALTYR WHY v0.1";
	public $username = '';
	public $password = '';
	public $baseUrl = '';
	public $loginPath = 'login.php';
	public $apiPath = 'agentstats.php';
	public $jsonPathForTests = 'tripwire/lol.json';
	public $WDSCorps = array(98330748);
	public function initialize(){
		parent::initialize();
		$this->baseUrl = Configure::read('tripWire.baseUrl');
		$this->username = Configure::read('tripWire.username');
		$this->password = Configure::read('tripWire.password');
		$this->loadModel('Tripwirestats');
		$this->loadModel('Stats');
	}
	public function fetch(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $this->loginPath);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->USER_AGENT);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "username=".$this->username."&password=".$this->password);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'tripwire/cookie-tripwire');  //could be empty, but cause problems on some hosts
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'tripwire/cookieTripwire');  //could be empty, but cause problems on some hosts
		$answer = curl_exec($ch);
		if (curl_error($ch)) {
		    echo curl_error($ch);
		}
		curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $this->apiPath);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "");
		$answer = curl_exec($ch);
		if (curl_error($ch)) {
		    echo curl_error($ch);
		}
		$a = json_decode($answer);
		return $a;
		// echo($answer);
	}

	public function getPilotJoinDates(){
		$url = "https://evewho.com/api.php?type=character&id="; //charID
		$initStats = $this->Stats->getAllAgents();
		foreach ($initStats as $s){
			$searchURL = $url.$s['character_id'];
			$this->Log("Getting join date for " . $s['character_id']);	
			$json = file_get_contents($searchURL);
			$obj = json_decode($json);
			// sleep(1);
			$this->Log($obj->info);
			try{
				if (!isset($obj->info->corporation_id)) continue;
				if (in_array($obj->info->corporation_id,$this->WDSCorps)){
				foreach ($obj->history as $h){

					if (in_array($h->corporation_id,$this->WDSCorps)){
						if (is_null($h->end_date)){
							$startDate = $h->start_date;	
							echo "Found WDS " . $startDate;
							//update start date joindate
							$query = "UPDATE characters set joindate = '$startDate' where character_id = " . $s['character_id'];
							$connection = ConnectionManager::get('default');
        					$connection->execute($query);

						}
					}
				}	
				}else{
					//not in corp
					foreach ($obj->history as $h){
						if (is_null($h->end_date)){
							$startDate = $h->start_date;	
							echo "Left WDS " . $startDate;
							$corp = $h->corporation_id;
							//update start date joindate
							$query = "UPDATE characters set joindate = '$startDate', corporation_id = '$corp' where character_id = " . $s['character_id'];
							$connection = ConnectionManager::get('default');
        					$connection->execute($query);

						}
					}
				}	
			}catch(Exception $e){
				$this->Log($obj->info);
				die();
			}
			
		}
		
		die();
	}

	public function readFile(){
		 $data = file_get_contents($this->jsonPathForTests);
         
         return json_decode($data);
	}
	public function addTripwireStat($c){
		try{
			
			$ts = $this->Tripwirestats->newEntity();
			$ts = $this->Tripwirestats->patchEntity($ts,$c);
			// die();
			if ($this->Tripwirestats->save($ts)){

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
	public function main(){
			$data = $this->fetch();
			foreach ($data->results as $r){				
				$initStats = $this->Stats->getInitialStats($r->characterID);
				// debug($initStats);die();
				if (isset($initStats[0])){
					$this->Log("PArsingwith dif for " . $r->characterName . ' - ' . $r->characterID);
					//we have initial stats
					$newSig = array(
			 			'character_id' => $r->characterID,
			 			'date' => date('Y-m-d H:i:s'),
			 			'sigCount' => $r->sigCount - $initStats[0]['sigCount'],
			 			'systemsVisited'=>$r->systemsVisited -  $initStats[0]['systemsVisited'],
			 			'systemsViewed' => $r->systemsViewed - $initStats[0]['systemsViewed']
			 		);
				}else{
					$this->Log("PArsing for " . $r->characterName . ' - ' . $r->characterID);
					$newSig = array(
			 			'character_id' => $r->characterID,
			 			'date' => date('Y-m-d H:i:s'),
			 			'sigCount' => $r->sigCount,
			 			'systemsVisited'=> $r->systemsVisited,
			 			'systemsViewed' => $r->systemsViewed
			 		);	
				}
				$this->addTripwireStat($newSig);
				unset($newSig);
		
			}
	}
}
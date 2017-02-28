<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;

use Cake\View\Exception\MissingTemplateException;
use Cake\Database\Exception\MissingConnectionException;
use Cake\Event\Event;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        // debug($_SESSION);die();
    
    $this->loadModel('Stats');
    }
    public function initialize()
    {
        parent::initialize();

    }
    public function test(){
        
        
        die();
    }
    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function prevmonth(){
        $dateStart = date('Y-m',strtotime('last month')).'-01';
        $dateEnd = date('Y-m').'-01';
          $this->Cookie->write('stats',
                ['dateStart'=>$dateStart, 'dateEnd'=>$dateEnd]
                );
          $this->redirect('/');
    }
    public function thismonth(){
        $dateEnd = date('Y-m',strtotime('next month')).'-01';
        $dateStart = date('Y-m').'-01';
          $this->Cookie->write('stats',
                ['dateStart'=>$dateStart, 'dateEnd'=>$dateEnd]
                );
          $this->redirect('/');
    }
    public function lastquarter(){
        $dateStart = date('Y-m',strtotime('-3 months')).'-01';
        $dateEnd = date('Y-m').'-01';
        
          $this->Cookie->write('stats',
                ['dateStart'=>$dateStart, 'dateEnd'=>$dateEnd]
                );
          $this->redirect('/');
    }
    public function customstats(){
    	
    }
    public function contest(){
        $this->viewBuilder()->layout('wingspan');
        $data = $this->Stats->topKillInAstero($this->dateStart,$this->dateEnd);
        $ds = $this->dateStart;
        $de = $this->dateEnd;
        $bomber = $this->Stats->topKillInBomber($this->dateStart,$this->dateEnd);
        $this->set(compact('data','ds','de','bomber'));
    }
    public function home(){
        $agentData = $this->Stats->agents($this->dateStart,$this->dateEnd);
        // if (empty($agentData)) $this->redirect('/'); //in case cache fails, we retry cuz fuck cake
        // if (empty($agentData)){
        //     die("Crunching numbers, return later");
        // }
        $shipsData = $this->Stats->topShips($this->dateStart,$this->dateEnd);
        $solo = 0;//can be 0 
        $stratiosData = $this->Stats->getGenericByFlownShip($this->Stats->stratios,$solo,$this->dateStart,$this->dateEnd);
        $solo = 0;//can be 0 
        $bombersData = $this->Stats->getGenericByFlownShip($this->Stats->bombers,$solo,$this->dateStart,$this->dateEnd);
        $topSeven = $this->Stats->topLastSevenDays($this->dateEnd);
        $totalNave = 0;
        foreach ($shipsData as $s){
            $totalNave += $s['totalKills'];
        }
        foreach ($shipsData as $i => $s){
            $shipsData[$i]['pct'] = round($s['totalKills'] * 100 / $totalNave);
        }
        $generalData = $this->Stats->locations($this->dateStart,$this->dateEnd);
        
        $this->set(compact('agentData','shipsData','stratiosData','bombersData','shipsChart','totalNave','generalData','topSeven'));

    }
    public function ships(){
        $this->viewBuilder()->layout('wingspan');
         $parsedData = $this->Stats->topShips($this->dateStart,$this->dateEnd);
           $propList = array(
                'name',
                    'totalKills',
                    'isk',
                    
                );
                $head = array(
                    'Top Ship',
                    'Kills',
                    'Isk Lost',
                    );
         $this->set(compact('parsedData','propList','head'));
    }
    public function login(){
        $this->viewBuilder()->layout('wingspan');
        
        
    }
    public function logout(){
        $this->request->session()->delete('Auth');
        $this->redirect('/');
    }
    public function sso($code = ''){
        if (isset($_GET['code'])){
            $code = $_GET['code'];
            $state = $_GET['state'];
            $clientid = Configure::read('eveSSO.client_id');
            $secret = Configure::read('eveSSO.secret');
            $useragent = "Wingspan Delivery Stats v0.1 - andrei.negescu@gmail.com ";
        }
        $url=Configure::read('eveSSO.authsite') .'/oauth/token' ;
        $verify_url=Configure::read('eveSSO.authsite')  . Configure::read('eveSSO.verifyurl') ;
        $header='Authorization: Basic '.base64_encode($clientid.':'.$secret);

        $fields_string='';
        $fields=array(
                    'grant_type' => 'authorization_code',
                    'code' => $code
                );
        foreach ($fields as $key => $value) {
            $fields_string .= $key.'='.$value.'&';
        }
        rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $result = curl_exec($ch);
        if ($result===false) {
            auth_error(curl_error($ch));
        }
        curl_close($ch);
        $response=json_decode($result);
        // print_r($response);die();
        $auth_token=$response->access_token;
        $ch = curl_init();
    // Get the Character details from SSO
        $header='Authorization: Bearer '.$auth_token;
        curl_setopt($ch, CURLOPT_URL, $verify_url);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $result = curl_exec($ch);
        if ($result===false) {
            auth_error(curl_error($ch));
        }
        curl_close($ch);
        $response=json_decode($result);
        if (!isset($response->CharacterID)) {
            throw new NotFoundException('No character ID returned');
        }
        // debug($response);die();
        $ch = curl_init();
        $lookup_url="https://api.eveonline.com/eve/CharacterAffiliation.xml.aspx?ids=".$response->CharacterID;
        curl_setopt($ch, CURLOPT_URL, $lookup_url);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $result = curl_exec($ch);
       if ($result===false) {
                throw new NotFoundException('No such character on the API');
            }
        $xml=simplexml_load_string($result);
        $corporationID=(string)$xml->result->rowset->row->attributes()["corporationID"];
        $allianceID=(string)$xml->result->rowset->row->attributes()["allianceID"];
        //fional check
        if (in_array($corporationID,array(98330748))){
            //correct corporation
            $redirectURL = $this->request->session()->read('Auth.redirectAuth');
            if ($redirectURL == false) $redirectURL = '/';
            $this->redirect($redirectURL);
            $this->auth($response);
            //auth the user
            // die("TRUE");
            // verifica daca exista userul
            // adauga userul in corporatie
            // logheaza tot
            // pune in sesiune
            // autentifica
        }else{
            throw new NotFoundException("INVALID");
        }


    }
    public function losses($page = false){
        $this->viewBuilder()->layout('wingspan');
        $hasChart = true;
        switch ($page) {
            case 'biggest': 
                $parsedData = $this->Stats->getBiggestLoss($this->dateStart,$this->dateEnd);
                 $propList = array(
                'character_name',
                    'name',
                    'isk',
                    
                );
                 $page = "Biggest WDS Loss";
                $head = array(
                    'Agent',
                    'Ship',
                    'Value',
                    );
                $hasChart = false;
                break;
            case 'normal': 
                $parsedData = $this->Stats->getLosses($this->dateStart,$this->dateEnd);
                 $propList = array(
                'character_name',
                    'kills',
                    'isk',
                    
                );
                 $page = "All losses";
                $head = array(
                    'Agent',
                    'Ships destroyed',
                    'Isk Lost',
                    );
                break;

            default: $parsedData = false;
        }
        
        $this->set(compact('parsedData','propList','head','page','hasChart'));
    }
    public function stats( $page = false){
        // $date = '2017-01';
        $this->viewBuilder()->layout('wingspan');
        $prop = 'agents';
        $extraData = array();
        switch ($page) {
            case 'agents': $parsedData = $this->Stats->agents($this->dateStart,$this->dateEnd);;break;
            case 'astero': $prop = 'ships'; $parsedData = $this->Stats->getGenericByFlownShip($this->Stats->astero,0,$this->dateStart,$this->dateEnd);break;
            // case 'awoxes': $parsedData = 'awoxes'; $prop='kills'; break;
            case 'blops': $prop = 'ships'; $parsedData = $this->Stats->getGenericByFlownShip($this->Stats->blops,0,$this->dateStart,$this->dateEnd);break;
            case 'miniBlops': $prop = 'ships'; $parsedData = $this->Stats->miniBlops($this->dateStart,$this->dateEnd);break;
            case 'bombers': 
                $prop = 'ships'; 

                $parsedData = $this->Stats->getGenericByFlownShip($this->Stats->bombers,0,$this->dateStart,$this->dateEnd);
                $extraData = array(
                        'nemesis'=> ['data'=> $this->Stats->getGenericByFlownShip(array(11377),1,$this->dateStart,$this->dateEnd),'label'=>'nemesis','name'=>'Nemesis kills'],
                        'purifier'=> ['data'=> $this->Stats->getGenericByFlownShip(array(12038),1,$this->dateStart,$this->dateEnd), 'label'=>'purifier','name'=>'Purifier kills'],
                        'hound'=> ['data'=> $this->Stats->getGenericByFlownShip(array(12034),1,$this->dateStart,$this->dateEnd),'label'=>'hound','name'=>'Hound kills'],
                        'manticore'=> ['data'=> $this->Stats->getGenericByFlownShip(array(12032),1,$this->dateStart,$this->dateEnd),'label'=>'manti','name'=>'Manticore kills'],
                    );
                break;
            case 'averagePilot': $parsedData = $this->Stats->averageIskPerKill($this->dateStart,$this->dateEnd); $prop = 'average';  break;
            case 'tripwire' : $parsedData = $this->Stats->tripwireMonth($this->dateStart,$this->dateEnd); $prop='tripwire'; break; 
            // case 'bombing': $parsedData = 'bombing_run_specialists';break;
            case 'capitals': $prop = 'ships'; $parsedData = $this->Stats->getGenericByDestroyedShip($this->Stats->caps,0,$this->dateStart,$this->dateEnd); $prop='kills'; break;
            case 'explorer': $parsedData = $this->Stats->getExplorerKills(0,$this->dateStart,$this->dateEnd);break;
            // case 'stats': $parsedData = 'general_stats';break;
            case 'industry': $prop = 'ships'; $parsedData = $this->Stats->getGenericByDestroyedShip($this->Stats->industrials,0,$this->dateStart,$this->dateEnd);break;
            case 'interdictors': $prop = 'ships'; $parsedData = $this->Stats->getGenericByFlownShip($this->Stats->interdictors,0,$this->dateStart,$this->dateEnd);break;
            case 'miner': $prop = 'ships'; $parsedData = $this->Stats->getGenericByDestroyedShip($this->Stats->miners,0,$this->dateStart,$this->dateEnd);break;
            case 'nestor': $prop = 'ships'; $parsedData = $this->Stats->getGenericByFlownShip($this->Stats->nestor,0,$this->dateStart,$this->dateEnd);break;
            case 'recons': $prop = 'ships'; $parsedData = $this->Stats->getGenericByFlownShip($this->Stats->recons,0,$this->dateStart,$this->dateEnd);;break;
            case 'ships': $parsedData = 'ships';$prop='ships';break;
            case 'solo': $parsedData = $this->Stats->solo($this->dateStart,$this->dateEnd);$prop='solo';break;
            case 'stratios': $prop = 'ships'; $parsedData = $this->Stats->getGenericByFlownShip($this->Stats->stratios,0,$this->dateStart,$this->dateEnd);;break;
            case 't3': $prop = 'ships'; $parsedData = $this->Stats->getGenericByFlownShip($this->Stats->strategicCruiser,0,$this->dateStart,$this->dateEnd);;break;
            // case 'team': $data = 'team_player';break;
            // case 'thera': $data = 'thera_crusader';break;
            default:               
                $file = 'general_stats';
                break;


        }
        // if (!isset($parsedData[0])){
        //    throw new MissingConnectionException('Something went wrong');
        // }
        if ($prop == 'agents'){
            $propList = array(
                'character_name',
                    'kills',
                    'isk',
                    
                );
            $head = array(
                'Agent',
                'Ships destroyed',
                'Isk Destroyed',
                );
        }
        elseif ($prop == 'tripwire'){
            $propList = array(
                'character_name',
                    'sigCount',
                    'systemsVisited',
                    'systemsViewed'
                    
                );
            $head = array(
                'Agent',
                'Signature Count',
                'Systems Visited',
                'System Viewed'
                );
        }
        elseif ($prop == 'ships'){
            $propList = array(
                'character_name',
                    'ships_killed',
                    'isk',
                    
                );
            $head = array(
                'Agent',
                'Ships destroyed',
                'Isk Destroyed',
                );
        }elseif ($prop == 'solo'){
             $propList = array(
                'character_name',
                    'ships_killed',
                    'isk',
                    
                );
            $head = array(
                'Agent',
                'Ships destroyed',
                'Isk Destroyed',
                );
        }elseif ($prop == 'average'){
            $head = array(
                'Agent',
                'No of Kills',                
                'Average Isk/Kill [B]',                
                'Average Damage/Kill',
                'Average Fleet Size',
                );
            $propList = array(
                'character_name',
                'noOfKills',
                'isk',
                'averageDamageDone',
                'avgFleet',      
                    
                    
                );

        }
        $page .= " " . $this->dateStart . ' to ' . $this->dateEnd;
        $this->set(compact('parsedData','propList','head','page','extraData'));
    }
    public function agent($alternativeCid = false,$altName = false){
        if ($this->request->is('post') || $alternativeCid !== false){
            if ($alternativeCid !== false ) {
                $cid = $alternativeCid;
                $cname = str_replace("'",' ',$altName);
            }
            else {
                $cid = $this->request->data['character_id'];
                $cname = str_replace("'",' ',$this->request->data['character_name']);
            }
            
            $agent = $this->Stats->getDataByAgent($cid,$this->dateStart,$this->dateEnd);
            $killingStats = array(
                        'totalKills'=>0,
                        'avgParties'=>0,
                        'totalValue'=>0
                    );
             $agent['loosingStats'] = array(
                        'totalValue'=>0,
                        'totalLoss'=>0,
                        'averageInvolvedInLoss' => 0
                    );
            if (!empty($agent['losses'])){
                $losses = $agent['losses'];
                // unset($agent['losses']);
                $totalValue = 0;
                $totalLoss = 0;
                $totalPartiesInvolvedInLoss=0;
                foreach ($losses as $l){
                    $totalValue += $l['value'];
                    $totalLoss++;
                    $totalPartiesInvolvedInLoss += $l['partiesInvolved'];
                }
                $averageInvolvedInLoss = $totalPartiesInvolvedInLoss/$totalLoss;    

                $agent['loosingStats'] = array(
                        'totalValue'=>$totalValue,
                        'totalLoss'=>$totalLoss,
                        'averageInvolvedInLoss' => $averageInvolvedInLoss
                    );
            }
            if (!empty($agent['kills'])){
                foreach ($agent['kills'] as $i=> $k){
                    $killingStats['totalKills']++;
                    $killingStats['avgParties'] += $k['partiesInvolved'];
                    $killingStats['totalValue'] += $k['value'];
                }

                $killingStats['avgParties'] =  ($killingStats['totalKills'] == 0 ? 0 : $killingStats['avgParties'] / $killingStats['totalKills']);
                
            }
            $agent['killingStats'] = $killingStats;
            $tIsk = $agent['killingStats']['totalValue'] + $agent['loosingStats']['totalValue'];
            $iskEfficency = ( $tIsk == 0 ? 0 : $agent['killingStats']['totalValue']  * 100 /$tIsk );
            $tShips = $agent['killingStats']['totalKills'] + $agent['loosingStats']['totalLoss'];
            $losWinRatio = ($tShips == 0 ? 0 : $agent['killingStats']['totalKills']  * 100 / $tShips );
            $humanInteraction = ($agent['loosingStats']['averageInvolvedInLoss'] + $agent['killingStats']['avgParties'] )/ 2;
            // debug($agent['favSystems']);die();
            $favSys = 'Unknown';
            if (isset($agent['favSystems'][0])){
                $fs = $agent['favSystems'][0];
                if ($fs['isWh'] == 1){
                    $favSys = "J ***". substr($fs['name'],-3);
                }else{
                    $favSys = $fs['name'];
                }
            $fs = $agent['favSystems'];
            unset($agent['favSystems']);
                foreach ($fs as $f => $s){
                        $agent['favSystems'][] = array(
                                'kills'=>$s['noOfKills'],
                                'isk' => $s['isk'],
                                'name' => ($s['isWh'] ? "J ***". substr($s['name'],-3) : $s['name'] )
                            );
                }
            }
            $genericStats = array(
                    'iskEfficency' => round($iskEfficency,2),
                    'losWinRatio' => round($losWinRatio,2),
                    'humanInteraction'=>round($humanInteraction,2),
                    'cid'=>$cid,
                    'cname'=>$cname,
                    'favSys'=>$favSys
                );
            // debug ($agent['favoriteShip']);die();
            $this->set(compact('agent','genericStats'));
            $this->set('_serialize',['agent','genericStats']);
                         
        }
            $agents = $this->Stats->getAllAgents();
            $this->set(compact('agents'));
            $this->set('_serialize',['agents']);
    }

    public function client($alternativeName = false){
        if ($this->request->is('post') || $alternativeName !== false){
            // $cid = $this->request->data['character_name'];
            if ($alternativeName !== false){
                $cname = str_replace("'",' ',urldecode($alternativeName));
            }else{
                $cname = str_replace("'",' ',$this->request->data['character_name']);    
            }
            
            if (trim($cname) == '') throw new NotFoundException('NO NO NO NO NO TYPE SOMETHING GODDAMIT');
            $checkup = $this->Stats->getClientByName($cname);
            $go = false;
            if (empty($checkup)){
            	//no info for $cname
                $this->Stats->addToQueue($cname);
                throw new NotFoundException("No info for character. Added to polling queue");
            }
            if (isset($checkup[0])){
                $cid = $checkup[0]['character_id'];
                $cname = $checkup[0]['character_name'];
                $go = true;
            }
            if ($go){
                $agent = $this->Stats->getClientById($cid,$this->dateStart,$this->dateEnd);
            $killingStats = array(
                        'totalKills'=>0,
                        'avgParties'=>0,
                        'totalValue'=>0
                    );
             $agent['loosingStats'] = array(
                        'totalValue'=>0,
                        'totalLoss'=>0,
                        'averageInvolvedInLoss' => 0
                    );
            if (!empty($agent['losses'])){
                $losses = $agent['losses'];
                // unset($agent['losses']);
                $totalValue = 0;
                $totalLoss = 0;
                $totalPartiesInvolvedInLoss=0;
                foreach ($losses as $l){
                    $totalValue += $l['value'];
                    $totalLoss++;
                    $totalPartiesInvolvedInLoss += $l['partiesInvolved'];
                }
                $averageInvolvedInLoss = $totalPartiesInvolvedInLoss/$totalLoss;    

                $agent['loosingStats'] = array(
                        'totalValue'=>$totalValue,
                        'totalLoss'=>$totalLoss,
                        'averageInvolvedInLoss' => $averageInvolvedInLoss
                    );
            }
            if (!empty($agent['kills'])){
                foreach ($agent['kills'] as $i=> $k){
                    $killingStats['totalKills']++;
                    $killingStats['avgParties'] += $k['partiesInvolved'];
                    $killingStats['totalValue'] += $k['value'];
                }

                $killingStats['avgParties'] =  ($killingStats['totalKills'] == 0 ? 0 : $killingStats['avgParties'] / $killingStats['totalKills']);
                
            }
            $agent['killingStats'] = $killingStats;
            $tIsk = $agent['killingStats']['totalValue'] + $agent['loosingStats']['totalValue'];
            $iskEfficency = ( $tIsk == 0 ? 0 : $agent['killingStats']['totalValue']  * 100 /$tIsk );
            $tShips = $agent['killingStats']['totalKills'] + $agent['loosingStats']['totalLoss'];
            $losWinRatio = ($tShips == 0 ? 0 : $agent['killingStats']['totalKills']  * 100 / $tShips );
            $humanInteraction = ($agent['loosingStats']['averageInvolvedInLoss'] + $agent['killingStats']['avgParties'] )/ 2;
            // debug($agent['favSystems']);die();
            $favSys = 'Unknown';
            if (isset($agent['favSystems'][0])){
                $fs = $agent['favSystems'][0];
                if ($fs['isWh'] == 1){
                    $favSys = "J ***". substr($fs['name'],-3);
                }else{
                    $favSys = $fs['name'];
                }
            $fs = $agent['favSystems'];
            unset($agent['favSystems']);
                foreach ($fs as $f => $s){
                        $agent['favSystems'][] = array(
                                'kills'=>$s['noOfKills'],
                                'isk' => $s['isk'],
                                'name' => ($s['isWh'] ? "J ***". substr($s['name'],-3) : $s['name'] )
                            );
                }
            }
            $genericStats = array(
                    'iskEfficency' => round($iskEfficency,2),
                    'losWinRatio' => round($losWinRatio,2),
                    'humanInteraction'=>round($humanInteraction,2),
                    'cid'=>$cid,
                    'cname'=>$cname,
                    'favSys'=>$favSys
                );
            // debug ($agent['favoriteShip']);die();
        }else{

        }
            
            $this->set(compact('agent','genericStats'));
            $this->set('_serialize',['agent','genericStats']);
                         
        }
            // $agents = $this->Stats->getAllClients   ();
            $this->set(compact('agents'));
            $this->set('_serialize',['agents']);
    }
    public function locations($type = 'kills'){
        $this->viewBuilder()->layout('wingspan');
        $locationStats = $this->Stats->getFavoriteSystems($this->dateStart,$this->dateEnd);
        foreach ($locationStats['fav'] as $i => $k){
            if ($k['isWh'] == 1 ) {
                $locationStats['fav'][$i]['name'] = 'J ***'.substr($locationStats['fav'][$i]['name'],-3);
            }
        }
        foreach ($locationStats['welp'] as $i => $k){
            if ($k['isWh'] == 1 ) {
                $locationStats['welp'][$i]['name'] = 'J ***'.substr($locationStats['welp'][$i]['name'],-3);
            }
        }
        $this->set(compact('locationStats'));
        $this->set('_serialize',['locationStats']);
    }
    public function datesetup(){
        $this->viewBuilder()->layout('wingspan');
        if ($this->request->is('post')){
            $dateStart = $this->request->data['dateStart'];
            $dateEnd = $this->request->data['dateEnd'];
            if (strtotime($dateStart) > strtotime($dateEnd)){
                throw new ForbiddenException("Bad date is bad");
            }
            $x = ['dateStart'=>$dateStart, 'dateEnd'=>$dateEnd];
            $this->Cookie->write('stats',
                ['dateStart'=>$dateStart, 'dateEnd'=>$dateEnd]
                );
            $this->redirect('/');
            //setting up
        }
        /*
                $this->Cookie->write('stats',
                ['dateStart'=>$dateStart, 'dateEnd'=>$dateEnd]
                );
         */
    }
    public function display()
    {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }
}

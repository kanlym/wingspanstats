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
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
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
    $options = array( 
        'agents'
        , 'astero'
        ,  'blops'
        , 'miniBlops'
        , 'bombers'
        ,  'explorer'

        ,  'industry'
        , 'interdictors'
        , 'miner'
        , 'nestor'
        , 'recons'
        ,  'solo'
        , 'stratios'
        , 't3'
        
        
        );
    $this->set('optionsMenu'
        ,$options);
    $this->loadModel('Stats');
    }
    public function initialize()
    {
        parent::initialize();

    }
    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */

    public function home(){
        $agentData = $this->Stats->agents($this->dateStart,$this->dateEnd);
        if (empty($agentData)){
            die("Crunching numbers, return later");
        }
        $shipsData = $this->Stats->topShips($this->dateStart,$this->dateEnd);
        $solo = 0;//can be 0 
        $stratiosData = $this->Stats->getGenericByFlownShip($this->Stats->stratios,$solo,$this->dateStart,$this->dateEnd);
        $solo = 0;//can be 0 
        $bombersData = $this->Stats->getGenericByFlownShip($this->Stats->bombers,$solo,$this->dateStart,$this->dateEnd);
        $soloData = $this->Stats->solo($this->dateStart,$this->dateEnd);
        
        $totalNave = 0;
        foreach ($shipsData as $s){
            $totalNave += $s['totalKills'];
        }
        foreach ($shipsData as $i => $s){
            $shipsData[$i]['pct'] = round($s['totalKills'] * 100 / $totalNave);
        }
        $generalData = $this->Stats->locations($this->dateStart,$this->dateEnd);
        
        $this->set(compact('agentData','shipsData','stratiosData','bombersData','soloData','shipsChart','totalNave','generalData'));
        $this->set(compact('agentData'));

    }
    public function losses($page = false){
        $this->viewBuilder()->layout('wingspan');
        switch ($page) {
            case 'biggest': 
                $parsedData = $this->Stats->getBiggestLoss($this->dateStart,$this->dateEnd);
                 $propList = array(
                'character_name',
                    'name',
                    'isk',
                    
                );
                $head = array(
                    'Agent',
                    'Ship',
                    'Value',
                    );
                break;
            case 'normal': 
                $parsedData = $this->Stats->getLosses($this->dateStart,$this->dateEnd);
                 $propList = array(
                'character_name',
                    'kills',
                    'isk',
                    
                );
                $head = array(
                    'Agent',
                    'Ships destroyed',
                    'Isk Lost',
                    );
                break;
            default: $parsedData = false;
        }
        
        $this->set(compact('parsedData','propList','head','page'));
    }
    public function stats( $page = false){
        // $date = '2017-01';
        $this->viewBuilder()->layout('wingspan');
        $prop = 'agents';
        switch ($page) {
            case 'agents': $parsedData = $this->Stats->agents($this->dateStart,$this->dateEnd);;break;
            case 'astero': $prop = 'ships'; $parsedData = $this->Stats->getGenericByFlownShip($this->Stats->astero,0,$this->dateStart,$this->dateEnd);break;
            // case 'awoxes': $parsedData = 'awoxes'; $prop='kills'; break;
            case 'blops': $prop = 'ships'; $parsedData = $this->Stats->getGenericByFlownShip($this->Stats->blops,0,$this->dateStart,$this->dateEnd);break;
            case 'miniBlops': $prop = 'ships'; $parsedData = $this->Stats->miniBlops($this->dateStart,$this->dateEnd);break;
            case 'bombers': $prop = 'ships'; $parsedData = $this->Stats->getGenericByFlownShip($this->Stats->bombers,0,$this->dateStart,$this->dateEnd);break;
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
        // if ($date == false){
        //     $date = date('Y-m');
        //     // $date = '2017-01';
        // }else{
        //     $d = explode('-',$date);
        //     if (count($d) < 2) throw new ForbiddenException("Invalid date");
        //     if ($d[1] < 1 && $d[0] < 2014) throw new ForbiddenException("Invalid date");
        // }
        //   $root = 'results/'.$date.'/';
        // // $root = 'results/__alltime__/';
        // $data = file_get_contents($root.$file.'.json');
        // $parsedData = json_decode($data);
        // $parsedData = $parsedData->$prop;
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
        }
        $this->set(compact('parsedData','propList','head','page'));
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

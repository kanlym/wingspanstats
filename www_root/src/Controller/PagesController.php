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
    $options = array( 'agents', 'astero',  'blops', 'bombers',  'explorer',  'industry', 'interdictors', 'miner', 'nestor', 'recons',  'solo', 'stratios', 't3', 'team', 'thera');
    $this->set('optionsMenu',$options);
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
        // $d = date('Y-m');
        $d ='2017-01';
        $root = 'results/'.$d.'/';
        // $root = 'results/__alltime__/';
        $data = file_get_contents($root.'agents.json');
        $agentData = json_decode($data);
        usort($agentData->agents,'cmpISK');

        $data = file_get_contents($root.'ships.json');
        $shipsData = json_decode($data);
        usort($shipsData->ships,'cmpISK');

        $data = file_get_contents($root.'stratios.json');
        $stratiosData = json_decode($data);
        usort($stratiosData->agents,'cmpShips');

        $data = file_get_contents($root.'bombers.json');
        $bombersData = json_decode($data);
        usort($bombersData->agents,'cmpShips');

        $data = file_get_contents($root.'solo_hunter.json');
        $soloData = json_decode($data);
        usort($soloData->agents,'cmpISK');
        //calculate ship stats
        $shipsChart = $shipsData->ships;
        $totalNave = 0;
        foreach ($shipsChart as $s){
            $totalNave += $s->ships_destroyed;
        }
        foreach ($shipsChart as $i => $s){
            $shipsChart[$i]->pct = round($s->ships_destroyed * 100 / $totalNave);
        }
        usort($shipsChart, 'cmpPct');

         $data = file_get_contents($root.'general_stats.json');
        $generalData = json_decode($data);
        
        $this->set(compact('agentData','shipsData','stratiosData','bombersData','soloData','shipsChart','totalNave','generalData'));
    }

    public function stats( $page = false,$date = false){
        // $date = '2017-01';
        $this->viewBuilder()->layout('wingspan');
        $prop = 'agents';
        switch ($page) {
            case 'agents': $file = 'agents';break;
            case 'astero': $file = 'astero';break;
            case 'awoxes': $file = 'awoxes'; $prop='kills'; break;
            case 'blops': $file = 'blops';break;
            case 'bombers': $file = 'bombers';break;
            case 'bombing': $file = 'bombing_run_specialists';break;
            case 'capitals': $file = 'capital_kills'; $prop='kills'; break;
            case 'explorer': $file = 'explorer_hunter';break;
            case 'stats': $file = 'general_stats';break;
            case 'industry': $file = 'industry_giant';break;
            case 'interdictors': $file = 'interdictor_ace';break;
            case 'miner': $file = 'miner_bumper';break;
            case 'nestor': $file = 'nestor';break;
            case 'recons': $file = 'recons';break;
            case 'ships': $file = 'ships';$prop='ships';break;
            case 'solo': $file = 'solo_hunter';break;
            case 'stratios': $file = 'stratios';break;
            case 't3': $file = 't3cruiser';break;
            case 'team': $file = 'team_player';break;
            case 'thera': $file = 'thera_crusader';break;
            default:               
                $file = 'general_stats';
                break;


        }
        if ($date == false){
            $date = date('Y-m');
            // $date = '2017-01';
        }else{
            $d = explode('-',$date);
            if (count($d) < 2) throw new ForbiddenException("Invalid date");
            if ($d[1] < 1 && $d[0] < 2014) throw new ForbiddenException("Invalid date");
        }
          $root = 'results/'.$date.'/';
        // $root = 'results/__alltime__/';
        $data = file_get_contents($root.$file.'.json');
        $parsedData = json_decode($data);
        $parsedData = $parsedData->$prop;
        if ($prop == 'agents'){
            $propList = array(
                'character_name',
                    'ships_destroyed',
                    'isk_destroyed',
                    
                );
            $head = array(
                'Agent',
                'Ships destroied',
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

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

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Core\Configure;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $dateStart = '';
    public $dateEnd = '';
    public $minimumPct = 25;
    public $allowedAcions = array('login','logout','home','sso','thismonth','prevmonth','lastquarter'); //allowed pages without login
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */

    public function checkIfAllowed(){
        if (!$this->checkIfLoggedIn()){
            if (!in_array($this->request->action,$this->allowedAcions)){
                $this->request->session()->write('Auth.redirectAuth',$this->referer() );
                $this->redirect('/pages/login');
            }    
        }
        
    }
    public function auth($response = false){
        $uid = $response->CharacterID;
        $name = $response->CharacterName;
             $s = $this->Stats->checkUserExistsForAuth($uid);
             if ($s === false) throw new NotFoundException('No Such User');     
                $this->request->session()->write('Auth.uid',$uid);
                $this->request->session()->write('Auth.loggedin',date('Y-m-d H:i:s'));
                $this->request->session()->write('Auth.name',$name);
                 
    }
    public function checkIfLoggedIn(){
        $uid = $this->request->session()->read('Auth.uid');

        try{                  
            $this->loadModel('Stats');  
            if ($uid == 0 ){
                $this->request->session()->delete('Auth');
                // $this->checkIfAllowed();
            } 

            $s = $this->Stats->checkUserExistsForAuth($uid);
            if ($s === false) throw new NotFoundException('No Such User');
        }catch(NotFoundException $e){
            return false;
        }
        return true;
    }
    public function checkIfOurBot(){
        // die($_GET['bot']);
        if ($this->request->is('POST')){
            
            if ($this->request->data['bot'] == "0026865d2aabdf20be434997cb225fc6"){
                //$hash = md5("kanlyhasthekey");      
                return true;
                // die($hash);
            }
        }
        return false;
    }
    public function initialize()
    {
        parent::initialize();
        $loggedIn = false;
        $loggedIn = $this->checkIfLoggedIn();
        if ($loggedIn == false){
            //check if authenticated via script
            if ($this->checkIfOurBot()){
                $loggedIn = true;
            }else{
                $this->checkIfAllowed();    
            }
            
        }
        $noance = uniqid();
        $loginUrl = Configure::read('eveSSO.authsite') .Configure::read('eveSSO.authurl') . '?response_type=code&redirect_uri=' . Configure::read('eveSSO.redirect_uri') . '&client_id=' . Configure::read('eveSSO.client_id') . '&scope=&state='. $noance;
        $this->set(compact('loginUrl'));
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->Cookie->config('path', '/');
        $this->Cookie->config([
            'expires' => '+60 minute',
            'httpOnly' => true
        ]);
        $this->Cookie->configKey('stats', 'path', '/');
        $this->Cookie->configKey('stats', 'domain', '.kanly.org');
        $this->Cookie->configKey('stats', 'encryption', false);
        $stats = $this->Cookie->read('stats');
        if ($stats == null){
            // $this->dateStart =  $dateStart = '2016-11';
            // $this->dateEnd = $dateEnd = '2016-12';
            $dateStart = date('Y-m').'-01';
            $dateEnd = date('Y-m',strtotime('+1 month')).'-01';
            $minimumPct = $this->minimumPct;

            $this->Cookie->write('stats',
                ['dateStart'=>$dateStart, 'dateEnd'=>$dateEnd,'minimumPct'=>$minimumPct]
                );
        }else{
           $this->dateStart = $dateStart= $stats['dateStart'];
            $this->dateEnd = $dateEnd = $stats['dateEnd'];
            $this->minimumPct = $minimumPct =  25;// $stats['minimumPct'];
        }
        // $this->dateStart =  $dateStart = '2016-11';
        // $this->dateEnd = $dateEnd = '2016-12';
        $this->set(compact('dateStart','dateEnd','minimumPct','loggedIn','loginUrl'));
         $this->set('_serialize', ['dateStart','dateEnd','minimumPct','loggedIn','loginUrl']);

 
        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
}

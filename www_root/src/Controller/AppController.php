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
    public $dateStart = 'unset';
    public $dateEnd = '';
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->Cookie->config('path', '/');
        $this->Cookie->config([
            'expires' => '+1 minute',
            'httpOnly' => true
        ]);
        $this->Cookie->configKey('stats', 'path', '/');
        $this->Cookie->configKey('stats', 'domain', '.kanly.org');
        $this->Cookie->configKey('stats', 'encryption', false);
        $stats = $this->Cookie->read('stats');
        if ($stats == null){
            $this->dateStart =  $dateStart = '2016-10';
            $this->dateEnd = $dateEnd = '2016-11';
            $dateStart = date('Y-m').'-01';
            $dateEnd = date('Y-m',strtotime('+1 month')).'-01';

            $this->Cookie->write('stats',
                ['dateStart'=>$dateStart, 'dateEnd'=>$dateEnd]
                );
        }else{
           $this->dateStart = $dateStart= $stats['dateStart'];
            $this->dateEnd = $dateEnd = $stats['dateEnd'];
        }
        $this->dateStart =  $dateStart = '2016-10';
        $this->dateEnd = $dateEnd = '2016-11';
        $this->set(compact('dateStart','dateEnd'));
         $this->set('_serialize', ['dateStart','dateEnd']);

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

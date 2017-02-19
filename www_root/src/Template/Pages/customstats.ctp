<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'wingspan';

?>
 <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Custom stats</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
        <div class="col-lg-12">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>                     
                        Configuration - for info only
                        </div>
                        <div class="panel-body">
                   
                            <div class="row">
                                <div class="col-lg-12">
                                 <table width="100%" class="table table-striped table-bordered table-hover" id="datatables-favSys">
                                    <thead>
                                        <tr>
                                            <th>Fleet PCT</th>
                                            <th>Fleet minimum people</th>
                                            <th>Ship Compo</th>
                                            <th>Target compo</th>
                                            <th>Time spent in wds</th>
                                            <th>Killing blows</th>
                                            <th>Isk Efficency</th>
                                            <th>kills</th>
                                            <th>losses</th>
                                            <th> Decide location</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                                    
                                </div>
                            </div>
                            
                        </div>    
                    </div>
            </div>
    </div>
    <div class="row">

    	Step 1 -> decide if looking for solo or multiple parties involved
    			-> decide date start/date end
    			-> decide wds percentage
    			-> decide isk value
    			-> decide locations

    </div>
    <div class="row">
    	Step 2 -> decide ship compo (or all) 
    			-> decide target ship compo ( or all )

    </div>
    <div class="row">
    	Step 3 -> decide isk efficency 
    			-> decide min no of losses
    			-> decide min no of kills
    </div>
    <div class="row">
    Results -> rows with aggregated stats for said parameters not individual pilots
    </div>
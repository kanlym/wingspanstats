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
if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Pages/home.ctp with your own version.');
endif;

?>
<?
// debug($generalData);die();
?>

 <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Current stats <?= $dateStart ?> to <?= $dateEnd ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            <?
                // debug($shipsData->ships);die();
            ?>
               <?= $this->element('headrows/row',array('icon'=>'fa-trophy','title'=>'Top agents','headNumber'=>'1/'.count($agentData->agents) .' agents','headText'=>$agentData->agents[0]->character_name,'color'=>'wingspan','link'=>'/stats/agents/'/* yellow */));?>
               <?= $this->element('headrows/row',array('icon'=>'fa-tasks','title'=>'Top ships','headNumber'=>$shipsData->ships[0]->ships_destroyed . ' kills','headText'=>$shipsData->ships[0]->ship_name,'color'=>'wingspan','link'=>'/home' /* yellow */));?>
               <?= $this->element('headrows/row',array('icon'=>'fa-rocket','title'=>'Top stratios kills','headNumber'=>$stratiosData->agents[0]->ships_destroyed .' kills','headText'=>$stratiosData->agents[0]->character_name,'color'=>'wingspan','link'=>'/stats/stratios/' /* yellow */));?>
               <?= $this->element('headrows/row',array('icon'=>'fa-bomb','title'=>'Top bomber kills','headNumber'=>$bombersData->agents[0]->ships_destroyed .' kills','headText'=>$bombersData->agents[0]->character_name,'color'=>'wingspan','link'=>'/stats/bomber/' /* yellow */));?>
            </div>
            <?

            $agentChart = $soloData->agents;

            $agentChartData = array();
            for ($i = 0; $i < 8;$i++){

                $agentChartData[] = array(
                        'nume'=>$agentChart[$i]->character_name,
                        'ships'=>$agentChart[$i]->ships_destroyed,
                        'id'=>'agent_'.$i,
                        'bani'=>round($agentChart[$i]->isk_destroyed/1000000000,2)
                    );

            }
            

            // debug($agentChart);die();
            ?>
                                         
            <script>
                $(function() {
  Morris.Bar({
        element: 'morris-bar-chart',
        data: [
            <?
                foreach ($agentChartData as $i=> $d){
                    if ($i == 5) break;
                    ?>
                     {
                        y: '<?= $d['nume'] ?>',
                        a: <?= $d['bani'] ?>,
                        b: <?= $d['ships']?>
                    },
                    <?
                }
            ?>
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Isk[b]','Ships'],
        hideHover: 'auto',
        resize: true,
        barColors: [
            '#f07c00',
            '#adadad'
        ]
    });
Morris.Bar({
        element: 'general-bar-chart',
        data: [
            <?
                foreach ($generalData->wh_stats as $g){
                    ?>
                     {
                        y: '<?= $g->type ?>'.toUpperCase(),
                        a: <?= round($g->total_value / 1000000000,2)  ?>,
                        b: <?= $g->destroyed ?>
                    },
                    <?
                }
            ?>
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Isk[b]','Ships'],
        hideHover: 'auto',
        resize: true,
        barColors: [
            '#f07c00',
            '#adadad'
        ]
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [
                <?
                $pctLeft =  100;
                    foreach ($shipsChart as $i => $s){
                        $pctLeft -= $s->pct;
                        ?>
                            {
                            label: "<?= $s->ship_name . ' ['.$s->ships_destroyed.' kills] ' ?>",
                            value: <?= $s->pct ?>
                        },
                        <?
                        if ($i == 5) {
                            ?>
                               {
                            label: "Other [<?= $totalNave ?> kills]",
                            value: <?= $pctLeft ?>
                        }
                            <?
                            break;
                        }
                    }
                ?>
       ],
        formatter: function (y, data) {
            return y + '%'
        },
        resize: true,
        colors: [
            '#A35400',
            '#B85F00',
            '#CC6900',
            '#E07400',
            '#F07C00',
            '#FF890A',
            '#FF931F',
            '#FF9C33',
            '#FFA647'
        ]
    }).select(0);

});

            </script>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                  
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> General stats
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Location</th>
                                                    <th>Ships Destroyed</th>
                                                    <th>Amount Destroyed</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>Wormholes</td>
                                                <td><?= $generalData->total_kills_wh ?></td>
                                                <td><?= round($generalData->total_value_wh / 1000000000,2) ?>b</td>
                                            </tr>

                                             <tr>
                                                <td>High Sec</td>
                                                <td><?= $generalData->total_kills_hs ?></td>
                                                <td><?= round($generalData->total_value_hs / 1000000000,2) ?>b</td>
                                            </tr>
                                             <tr>
                                                <td>Low Sec</td>
                                                <td><?= $generalData->total_kills_ls ?></td>
                                                <td><?= round($generalData->total_value_ls / 1000000000,2) ?>b</td>
                                            </tr>
                                             <tr>
                                                <td>Null Sec</td>
                                                <td><?= $generalData->total_kills_ns ?></td>
                                                <td><?= round($generalData->total_value_ns / 1000000000,2) ?>b</td>
                                            </tr>                                            
                                            <?
                                            ?>
                                               
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                <div class="col-lg-8">
                                    <div id="general-bar-chart"></div>
                                </div>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

                    <!-- /.panel -->
                   
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Top ships
                        </div>
                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>
                            <a href="#" class="btn btn-default btn-block">View Details</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.general Stats -->
                
                    <!-- /.general Stats -->
                   
                    <!-- /.panel .chat-panel -->
                </div>
                    <!-- /.general Stats -->
                        <div class="col-lg-8">
                  
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Solo agent by isk value
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Agent</th>
                                                    <th>Ships</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?
                                                foreach ($agentChartData as $i => $d){
                                                    ?>

                                                             <tr>
                                                            <td><?=$i + 1;?></td>
                                                            <td><?= $d['nume'];?></td>
                                                            <td><?= $d['ships'] ?></td>
                                                            <td><?= $d['bani']; ?>b</td>
                                                        </tr>
                                                    <?

                                                }
                                            ?>
                                               
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                <div class="col-lg-8">
                                    <div id="morris-bar-chart"></div>
                                </div>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

                    <!-- /.panel -->
                   
                    <!-- /.panel -->
                </div>
                    <!-- /.general Stats -->
                   
                    <!-- /.panel .chat-panel -->
                </div>  
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->

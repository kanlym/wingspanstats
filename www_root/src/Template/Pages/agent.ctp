<?php
$this->layout = 'wingspan';
?>

     <?
        if (isset($agent)){    
            // debug($agent['averages']);
     ?>
    <div class="row">
    <div class="col-lg-1">
    </div>
        <div class="col-lg-2">
            <img src="http://image.eveonline.com/Character/<?=$genericStats['cid'];?>_256.jpg">            
        </div>
        <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>                     
                        <?= $genericStats['cname'] ?> -  General Stats -  DIRECT LINK [ http://wingspan.kanly.org/pages/agent/<?= $genericStats['cid'] ?>/<?= urlencode($genericStats['cname']) ?> ]
                        </div>
                        <div class="panel-body">
                   
                            <div class="row">
                                <div class="col-lg-12">
                                 <table width="100%" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ISK Efficency</th>
                                            <th>Kill Vs Loss</th>
                                            <th> Human Interaction</th>
                                            <th> Average Fleet Size</th>
                                            <th>Number of kills</th>                                            
                                            <th> Total isk Destroyed</th>
                                            <th>Average Damage Done</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                        <td><?= $genericStats['iskEfficency'] ?>%</td>
                                        <td><?= $genericStats['losWinRatio'] ?>%</td>
                                        <td><?= round($genericStats['humanInteraction'],2) ?> clients</td>
                                        <td><?= round($agent['averages'][0]['avgFleet'],0)?></td>
                                        <td><?= $agent['averages'][0]['noOfKills']?></td>
                                        <td><?= round($agent['averages'][0]['isk'],2)?> B</td>
                                        <td><?= round($agent['averages'][0]['averageDamageDone'],2)?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                    
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-lg-12">
                                 <table width="100%" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Signature Count</th>
                                            <th>Systems Visited</th>
                                            <th>Systems Viewed</th>
                                            <th>Favorite System</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                        <td><?= isset($agent['tripwire'][0]['sigCountT']) ? $agent['tripwire'][0]['sigCountT'] : 0 ?></td>
                                        <td><?= isset($agent['tripwire'][0]['systemsVisitedT']) ? $agent['tripwire'][0]['systemsVisitedT'] : 0 ?></td>
                                        <td><?= isset($agent['tripwire'][0]['systemsViewedT']) ? $agent['tripwire'][0]['systemsViewedT'] : 0 ?></td>
                                        <td><?= $genericStats['favSys'];?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                    
                                </div>
                            </div>
                        </div>    
                    </div>
        </div>
    </div>
    <!-- STATS -->
      <div class="row">
        <div class="col-lg-6">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>                     
                       Loss Stats
                        </div>
                        <div class="panel-body">
                   
                            <div class="row">
                                <div class="col-lg-12">
                                 <table width="100%" class="table table-striped table-bordered table-hover" id="datatables-loss">
                                    <thead>
                                        <tr>
                                            <th>Ship</th>
                                            <th>Value</th>
                                            <th>Date</th>
                                            <th>Parties Involved</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                        foreach ($agent['losses'] as $l){

                                    ?>
                                        <tr>
                                            <td><a href="http://www.zkillboard.com/kill/<?= $l['kill_id']?>" target="_blank"><?= $l['name']?></a></td>
                                            <td><?= $l['value']?></td>
                                            <td><?= $l['date']?></td>
                                            <td><?= $l['partiesInvolved']?></td>
                                        </tr>
                                        <?
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                    
                                </div>
                            </div>
                            
                        </div>    
                    </div>
            </div>

             <div class="col-lg-6">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>                     
                       Killing Shot Stats
                        </div>
                        <div class="panel-body">
                   
                            <div class="row">
                                <div class="col-lg-12">
                                 <table width="100%" class="table table-striped table-bordered table-hover" id="datatables-kills">
                                    <thead>
                                        <tr>
                                            <th>Ship</th>
                                            <th>Value</th>
                                            <th>Date</th>
                                            <th>Parties Involved</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                        foreach ($agent['killingBlows'] as $l){

                                    ?>
                                        <tr>
                                            <td><a href="http://www.zkillboard.com/kill/<?= $l['kill_id']?>" target="_blank"><?= $l['name']?></a></td>
                                            <td><?= $l['value']?></td>
                                            <td><?= $l['date']?></td>
                                            <td><?= $l['partiesInvolved']?></td>
                                        </tr>
                                        <?
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                    
                                </div>
                            </div>
                            
                        </div>    
                    </div>
            </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>                     
                        Kills
                        </div>
                        <div class="panel-body">
                   
                            <div class="row">
                                <div class="col-lg-12">
                                 <table width="100%" class="table table-striped table-bordered table-hover" id="datatables-allKills">
                                    <thead>
                                        <tr>
                                            <th>Ship</th>
                                            <th>Value</th>
                                            <th>Damage Done</th>
                                            <th>Parties Involved</th>
                                            <th>Wingspan involvment pct</th>
                                            <th> Was flying a </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                        foreach ($agent['kills'] as $l){

                                    ?>
                                        <tr>
                                            <td><a href="http://www.zkillboard.com/kill/<?= $l['kill_id']?>" target="_blank"><?= $l['vicShip']?></a></td>
                                            <td><?= $l['value']?></td>
                                            <td><?= $l['damageDone'];?></td>
                                            <td><?= $l['partiesInvolved']?></td>
                                            <td><?= $l['totalWingspanpct']?>%</td>
                                            <td><?= $l['name']; ?></td>
                                        </tr>
                                        <?
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                    
                                </div>
                            </div>
                            
                        </div>    
                    </div>
            </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>                     
                        Favorite Ships
                        </div>
                        <div class="panel-body">
                   
                            <div class="row">
                                <div class="col-lg-12">
                                 <table width="100%" class="table table-striped table-bordered table-hover" id="datatables-favShip">
                                    <thead>
                                        <tr>
                                            <th>Ship</th>
                                            <th>Total Value [B]</th>
                                            <th>Ship Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                        foreach ($agent['favoriteShips'] as $l){

                                    ?>
                                        <tr>
                                            <td><?= $l['noOfHits']?></td>
                                            <td><?= $l['value']?></td>
                                            <td><a href="https://o.smium.org/search?q=<?= $l['name']; ?>" target="_blank"><?= $l['name']; ?></a> </td>
                                        </tr>
                                        <?
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                    
                                </div>
                            </div>
                            
                        </div>    
                    </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>                     
                        Favorite Systems
                        </div>
                        <div class="panel-body">
                   
                            <div class="row">
                                <div class="col-lg-12">
                                 <table width="100%" class="table table-striped table-bordered table-hover" id="datatables-favSys">
                                    <thead>
                                        <tr>
                                            <th>System</th>
                                            <th>Total Value [B]</th>
                                            <th>Kills</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                        foreach ($agent['favSystems'] as $l){

                                    ?>
                                        <tr>
                                            <td><?= $l['name']?></td>
                                            <td><?= $l['isk']?></td>
                                            <td><?= $l['kills']; ?></td>
                                        </tr>
                                        <?
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                    
                                </div>
                            </div>
                            
                        </div>    
                    </div>
            </div>
    </div>
    <? }else{ ?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                            <div class="col-lg-8">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                                <th>Portrait</th>
                                                <th>Name</th>
                                                <th>Stats</th>
                                                <th>Zkill</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                       
                                        foreach ($agents as $i => $d){
                                            if ($i%2 == 0 ) $class = 'odd'; else $class = 'even';
                                            ?>
                                                <tr class="<?= $class;?> gradeA">
                                                <form method="POST">
                                                <input type="hidden" name="character_id" value="<?= $d['character_id'] ?>">
                                                <input type="hidden" name="character_name" value="<?= $d['character_name'] ?>">
                                                <td><img src="http://image.eveonline.com/Character/<?= $d['character_id'] ?>_32.jpg"></td>
                                                <td><?= $d['character_name'] ?></td>
                                                <td><button>Generate</button></td>
                                           		<td><a href="http://zkillboard.com/character/<?= $d['character_id'] ?>/" target="_blank">Zkill</a></td>
												</form>
												</tr>
                                            <?

                                        }
                                    ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->

                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->

            </div>
  

<? } ?>
    <script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script>
    $(document).ready(function() {
        $("#datatables-kills").DataTable({
            aaSorting: [],
            responsive: true,
            pageLength:5
        });
        $("#datatables-loss").DataTable({
            aaSorting: [],
            responsive: true,
            pageLength:5
        });
        $("#datatables-allKills").DataTable({
            aaSorting: [],
            responsive: true,
            pageLength:5
        });      
        $("#datatables-favShip").DataTable({
            aaSorting: [],
            responsive: true,
            pageLength:10
        });  
        $("#datatables-favSys").DataTable({
            aaSorting: [],
            responsive: true,
            pageLength:10
        });  
        $('#dataTables-example').DataTable({
            aaSorting: [],
            responsive: true,
            pageLength: 25
            
        });
    });
    </script>
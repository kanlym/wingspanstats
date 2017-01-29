<?php 
 ?>
 <div class="row">
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
                                            <th>Kills</th>
                                            <th>Total Value [B]</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                        foreach ($locationStats['fav'] as $l){

                                    ?>
                                        <tr>
                                            <td><?= $l['noOfKills']?></td>
                                            <td><?= $l['isk']?></td>
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
            <div class="col-lg-6">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>                     
                        Favorite Welp spots
                        </div>
                        <div class="panel-body">
                   
                            <div class="row">
                                <div class="col-lg-12">
                                 <table width="100%" class="table table-striped table-bordered table-hover" id="datatables-welpSys">
                                    <thead>
                                        <tr>
                                            <th>Losses</th>
                                            <th>Total Value [B]</th>
                                            <th>name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                        foreach ($locationStats['welp'] as $l){

                                    ?>
                                        <tr>
                                            <td><?= $l['noOfKills']?></td>
                                            <td><?= $l['isk']?></td>
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
 <script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
 <script src="/vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script>
    $(document).ready(function() {
 
        $("#datatables-favSys").DataTable({
            aaSorting: [],
            responsive: true,
            pageLength:10
        });  
        $('#datatables-welpSys').DataTable({
            aaSorting: [],
            responsive: true,
            pageLength: 10            
        });
    });
    </script>
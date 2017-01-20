<?
?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Filters
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                            <th>#</th>
                                        <?
                                            foreach ($head as $h){
                                                ?>
                                                <th><?= $h; ?>
                                                <? if ($h == 'Isk Destroyed') echo "[B]" ?></th>
                                                <?
                                            }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                   
                                    foreach ($parsedData as $i => $d){
                                        if ($i%2 == 0 ) $class = 'odd'; else $class = 'even';
                                        ?>
                                            <tr class="<?= $class;?> gradeA">
                                            <td><?= $i+1 ?></td>
                                            <?
                                                foreach ($propList as $p){
                                                    if ($p == 'isk_destroyed'){
                                                        ?>
                                                             <td><?= round($d->$p/1000000000,2) ?> </td>                                                
                                                        <?    
                                                    }else{
                                                        ?>
                                                            <td><?= $d->$p ?></td>                                                
                                                        <?        
                                                    }
                                                    
                                                }
                                            ?>
                                                
                                            </tr>
                                        <?

                                    }
                                ?>
                                    
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                           
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
    <script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            aaSorting: [],
            responsive: true
        });
    });
    </script>
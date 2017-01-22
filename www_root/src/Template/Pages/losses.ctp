<?php
// debug($parsedData);die();
if ($hasChart){
?>
<script>
 $(function() {
  Morris.Bar({
        element: 'morris-bar-chart',
        data: [
            <?
                foreach ($parsedData as $i=> $d){
                    if ($i == 5) break;
                    ?>
                     {
                        y: "<?= $d[$propList[0]] ?>",
                        a: <?= $d[$propList[1]] ?>,
                        b: <?= $d[$propList[2]]?>
                    },
                    <?
                }
            ?>
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Ships','Isk[b]'],
        hideHover: 'auto',
        resize: true,
        barColors: [
            '#f07c00',
            '#adadad'
        ]
    });
});
</script>
<? } ?>
<div class="row">
                <div class="col-lg-<?= $hasChart ? 8 : 12 ?>">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?= $page ?>
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
                                                    if ($p == 'isk'){
                                                        ?>
                                                             <td><?= round($d[$p],2) ?> </td>                                                
                                                        <?
                                                    }elseif ($p == 'character_name'){
                                                            ?><td><?
                                                            if (isset($d['character_id'])){
                                                                ?>
                                                                <img src="http://image.eveonline.com/Character/<?= $d['character_id'] ?>_32.jpg">
                                                                <?
                                                            }
                                                            ?><?= $d[$p] ?></td><?
    
                                                    }else{
                                                        ?>
                                                            <td><?= $d[$p] ?></td>                                                
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
                <? if ($hasChart){ ?>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                            <div class="panel-heading">
                                        Filters
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div id="morris-bar-chart"></div>
                                    </div>
                    </div>
                </div>
                <? } ?>
            </div>
    <script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            aaSorting: [],
            responsive: true,
            "pageLength": 8
        });
    });
    </script>
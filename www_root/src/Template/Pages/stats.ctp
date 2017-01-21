<?
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
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?= isset($optionsMenu[$page]) ? $optionsMenu[$page] : $page ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                            <div class="col-lg-8">
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
                            </div>
                            <!-- /.table-responsive -->
                                <div class="col-lg-4">
                            
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div id="morris-bar-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->

            </div>
    <?
        if (!empty($extraData)){
            foreach ($extraData as $x){
            ?>
            <script>
 $(function() {
  Morris.Bar({
        element: 'morris-bar-chart-<?=$x['label']?>',
        data: [
            <?
                foreach ($x['data'] as $i=> $d){
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
                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?= $x['name'] ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example-<?= $x['label']?>">
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
                                          
                                            foreach ($x['data'] as $i => $d){
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
                                <div class="col-lg-4">
                                        <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div id="morris-bar-chart-<?=$x['label']?>"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
               
            </div>
            <?
            }
        }
    ?>
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
        <?
        foreach ($extraData as $x){
            ?>
            $('#dataTables-example-<?= $x['label'] ?>').DataTable({
             responsive: true,
             "pageLength":8
        });
            <?
        }
        ?>
    });
    </script>
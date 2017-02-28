<?php 
?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						<h2> Top ASTERO pilot for <?= $ds;?> 00:00 to <?= $de; ?> 00:00 is </h2>
						</div>
					</div>
					<div class="panel-body">
                            <div class="row">
                            	<div class="col-lg-8">
									<h2> <?= $data[0]['character_name'] ?> </h2>
									<h2> Killing a <?= $data[0]['sname'] ?> in <?= $data[0]['name'];?> worth <?= round($data[0]['isk'],2) ?> b isk</h2>
									<a target="_blank" href="http://zkillboard.com/kill/<?= $data[0]['kill_id'] ?>"> Kill info </a>
								</div>
							</div>
					</div>
			</div>
</div>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						<h2> Top Bomber solo kill in whs for <?= $ds;?> 00:00 to <?= $de; ?> 00:00 is </h2>
						</div>
					</div>
					<div class="panel-body">
                            <div class="row">
                            	<div class="col-lg-8">
									<h2> <?= $bomber[0]['character_name'] ?> </h2>
									<h2> Killing a <?= $bomber[0]['sname'] ?> in <?= $bomber[0]['name'];?> worth <?= round($bomber[0]['isk'],2) ?> b isk while flying a <?= $bomber['0']['flyingShip'] ?></h2>
									<a target="_blank" href="http://zkillboard.com/kill/<?= $bomber[0]['kill_id'] ?>"> Kill info </a>
								</div>
							</div>
					</div>
			</div>
</div>
<?php
$optionsMenu = array( 
         'astero' => "Flying asteros"
        ,  'blops' => "Flying blops"
        , 'miniBlops' => "Flying miniblops"
        , 'bombers' => "Flying bombers"        
        , 'interdictors' => "Flying interdictors"    
        , 'nestor' =>"Flying nestors"
        , 'recons' =>"Flying recons"
        , 'stratios' => "Flying strats"
        , 't3' => "Flyng T3"
        , 'explorer' => "Killing explorers"
        , 'industry' => "Killing industrials"
        , 'miner' => "Killing miners"
        
        
        );
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="/"><img id="logo" class="pull-left" src="/img/icon_wing.png" alt="wing"><span class="navbar-brand">Wingspan daily stats   </span></a></div>
                  <ul class="nav navbar-top-links navbar-right">
             
                <!-- /.dropdown -->
                <li><a href="/pages/thismonth">This Month</a></li>
                <li><a href="/pages/prevmonth">Last Month</a></li>
                <li><a href="/pages/lastquarter">Last Quarter</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
    
                    <ul class="dropdown-menu dropdown-user">

                      <?
                        if ($loggedIn) {
                       ?>
                        <li><a href="/pages/agent/<?= $_SESSION['Auth']['uid'] ?>/<?= urlencode($_SESSION['Auth']['name']) ?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="/pages/datesetup"><i class="fa fa-calendar fa-fw"></i> Date setup</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/pages/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                          <? }else{ ?>
                          <li><a href="<?=$loginUrl ?>"><i class="fa fa-sign-in fa-fw"></i> Login</a>
                          <? } ?>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
              
                <!-- /.dropdown -->
            </ul>
            </div>

            <!-- /.navbar-header -->

            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                 
                       <ul class="nav" id="side-menu">
                         
                        <li>
                            <a href="/"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user-md fa-fw"></i> Lookup<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                    <li>
                                        <a href="/pages/agent"> Agents </a>
                                    </li>
                                    <li>
                                        <a href="/pages/client"> Clients </a>
                                    </li>
                            </ul>
                        </li>   
                        
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> General stats<span class="fa arrow"></span></a>
                             <ul class="nav nav-second-level">
                                <li>
                                    <a href="/pages/ships"> Top Ships </a>
                                </li>
                                <li>
                                    <a href="/pages/stats/agents"> Top Agents</a>
                                </li>
                                <li>
                                    <a href="/pages/stats/solo"> Top Solo Agents</a>
                                </li>
                                <li>
                                    <a href="/pages/stats/averagePilot"> Pilot Averages </a>
                                </li>
                                
                               
                                <li><hr></li>
                                <li>
                                    <a href="/pages/losses/biggest">Biggest Loss</a>
                                </li>
                                <li>
                                    <a href="/pages/losses/normal">Welp factor</a>
                                </li>
                             </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Location stats<span class="fa arrow"></span></a>
                             <ul class="nav nav-second-level">
                                <li>
                                    <a href="/pages/stats/tripwire">Tripwire stats</a>
                                </li>  
                                <li><a href="/pages/locations">Favorite spots</a></li>
                             </ul>
                        </li>        
                             
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Ship stats <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            <?
                                foreach ($optionsMenu as $o => $n){
                                    ?>
                                        <li>
                                            <a href="/pages/stats/<?=$o?>"><?= $n ?></a>
                                        </li>
                                        
                                    <?    
                                }
                            ?>
                                
                              <!--   <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                </li> -->
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                           
                        </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->

        </nav>

  
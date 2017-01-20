<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="/"><img id="logo" class="pull-left" src="/img/icon_wing.png" alt="wing"><span class="navbar-brand">Wingspan daily stats</span></a></div>
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
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> General stats</a>
                        </li>        
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Tripwire stats</a>
                        </li>       
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Agent Stats<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            <?
                                foreach ($optionsMenu as $o){
                                    ?>
                                        <li>
                                            <a href="/pages/stats/<?=$o?>"><?= $o ?></a>
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

  

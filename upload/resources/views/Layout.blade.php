<!DOCTYPE html>
<html lang="en" <?php if($panelInit->isRTL == 1){ ?>dir="rtl"<?php } ?>>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="SolutionsBricks.com">
    <base href="<?php echo $panelInit->baseURL; ?>" />
    <?php if($panelInit->settingsArray['favicon'] == "e"){ ?>
        <link rel="icon" type="image/png" sizes="16x16" href="{{URL::asset('assets/images/favicon.png')}}">
    <?php } ?>
    <title><?php echo $panelInit->settingsArray['siteTitle'] . " | " . $panelInit->language['dashboard'] ; ?></title>
    <link href="{{URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <?php if($panelInit->isRTL == 1){ ?>
        <link href="{{URL::asset('assets/css/style-rtl.css')}}" rel="stylesheet">
        <link href="{{URL::asset('assets/plugins/bootstrap-rtl-master/dist/css/custom-bootstrap-rtl.css')}}" rel="stylesheet" type="text/css" />
    <?php }else{ ?>
        <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet">
    <?php } ?>
    <link href="{{URL::asset('assets/css/colors/'.$panelInit->defTheme.'.css')}}" id="theme" rel="stylesheet">
    <link href="{{URL::asset('assets/css/custom.css')}}" id="theme" rel="stylesheet">
    <link href="{{URL::asset('assets/css/intlTelInput.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/global-calendars/jquery.calendars.picker.css')}}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header <?php if($panelInit->settingsArray['leftmenuScroller'] == "e"){ echo "fix-sidebar"; } ?> card-no-border" ng-app="schoex" ng-controller="mainController">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar <?php if($panelInit->settingsArray['leftmenuScroller'] == "e"){ echo "topbarSticky"; } ?> no-print">
            <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="#/">
                        <?php
                        if($panelInit->settingsArray['siteLogo'] == "siteName"){
                            ?>
                            <span>
                                <span class="dark-logo" ng-show="$root.dashboardData.baseUser.defTheme.indexOf('dark') == -1"><?php echo $panelInit->settingsArray['siteTitle']; ?></span>
                                <span class="light-logo" ng-show="$root.dashboardData.baseUser.defTheme.indexOf('dark') !== -1"><?php echo $panelInit->settingsArray['siteTitle']; ?></span>
                            </span>
                            <?php
                        }elseif($panelInit->settingsArray['siteLogo'] == "text"){
                            ?>
                            <span>
                                <span class="dark-logo" ng-show="$root.dashboardData.baseUser.defTheme.indexOf('dark') == -1"><?php echo $panelInit->settingsArray['siteLogoAdditional']; ?></span>
                                <span class="light-logo" ng-show="$root.dashboardData.baseUser.defTheme.indexOf('dark') !== -1"><?php echo $panelInit->settingsArray['siteLogoAdditional']; ?></span>
                            </span>
                            <?php
                        }elseif($panelInit->settingsArray['siteLogo'] == "image"){
                            ?>
                            <span>
                                <img src="<?php echo URL::asset('assets/images/logo-dark.png'); ?>" alt="homepage" class="dark-logo" />
                                <img src="<?php echo URL::asset('assets/images/logo-light.png'); ?>" class="light-logo" alt="homepage" />
                            </span>
                            <?php
                        }
                        ?>
                     </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0 ">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="icon-arrow-left-circle"></i></a> </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{URL::to('/dashboard/profileImage/'.$users['id'])}}" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="{{URL::to('/dashboard/profileImage/'.$users['id'])}}" alt="user"></div>
                                            <div class="u-text">
                                                <h4>{{$users['fullName']}}</h4>
                                                <p class="text-muted">{{$users['email']}}</p></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <a href="#/account/invoices" class="dropdown-item"><i class="ti-wallet"></i> <?php echo $panelInit->language['myInvoices']; ?></a>
                                    <a href="#/messages" class="dropdown-item"><i class="ti-email"></i> <?php echo $panelInit->language['Messages']; ?></a>
                                    <div class="dropdown-divider"></div> <a href="#/account" class="dropdown-item"><i class="ti-settings"></i> <?php echo $panelInit->language['AccountSettings']; ?></a>
                                    <div class="dropdown-divider"></div> <a href="{{URL::to('/logout')}}" class="dropdown-item"><i class="fa fa-power-off"></i> <?php echo $panelInit->language['logout']; ?></a>
                                </ul>
                            </div>
                        </li>
                        <?php /* if( $panelInit->settingsArray['languageAllow'] == "1" ){ ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-us"></i></a>
                                <div class="dropdown-menu  dropdown-menu-right">
                                    <?php foreach ($languagesList as $value) { ?>
                                        <a class="dropdown-item <?php if($value->id == $users['defLang']){ echo "active"; } ?>" ng-click="changeLang('<?php echo $value->id; ?>')"><?php echo $value->languageTitle; ?></a>
                                    <?php } ?>
                                </div>
                            </li>
                        <?php } */ ?>


                        <li class="nav-item dropdown">
                            <a href="{{URL::to('/logout')}}" class="nav-link text-muted waves-effect waves-dark" > <i class="fa fa-power-off"></i></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="right-side-toggle text-muted nav-link " href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-view-grid"></i></a>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar <?php if($panelInit->settingsArray['leftmenuScroller'] == "e"){ echo "enableSlimScroller"; } ?> no-print" style="padding-bottom:60px;">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" >
                <!-- User profile -->
                <div class="user-profile">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="{{URL::to('/dashboard/profileImage/'.$users['id'])}}" alt="user" /> </div>
                    <!-- User profile text-->
                    <div class="profile-text"> <a href="javascript:void(0)" class="dropdown-toggle link u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{$users['fullName']}} <span class="caret"></span></a>
                        <div class="dropdown-menu animated flipInY">
                            <a href="#/account/invoices" class="dropdown-item"><i class="ti-wallet"></i> <?php echo $panelInit->language['myInvoices']; ?></a>
                            <a href="#/messages" class="dropdown-item"><i class="ti-email"></i> <?php echo $panelInit->language['Messages']; ?></a>
                            <div class="dropdown-divider"></div> <a href="#/account" class="dropdown-item"><i class="ti-settings"></i> <?php echo $panelInit->language['AccountSettings']; ?></a>
                            <div class="dropdown-divider"></div> <a href="{{URL::to('/logout')}}" class="dropdown-item"><i class="fa fa-power-off"></i> <?php echo $panelInit->language['logout']; ?></a>
                        </div>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">

                    <ul id="sidebarnav" <?php if($panelInit->settingsArray['leftmenuScroller'] != "e"){ echo "style='padding-bottom:60px;'"; }?>>
                          
                        <?php
                        if($users->role == "admin" AND $users->customPermissionsType == "custom"){
                            $userPerm = $users->customPermissionsAsJson();
                            $performPermScan = true;
                        }
                        $ss = 0;
                        while (list($key, $value) = each($panelInit->panelItems)) {

                            /**
                            Hard code for fleet management
                            **/

                            

                            if(++$ss == 2)
                            {
                                echo "<li><a class='aj scrollTop' href='".URL::to('#/vehicles')."' aria-expanded='false'><i class='mdi mdi-account-multiple-outline'></i><span class='hide-menu'>Fleet Management</span></a>";
                            }
                            if(isset($value['activated']) AND !strpos($panelInit->settingsArray['activatedModules'],$value['activated']) ){ continue;  }
                            if(!in_array($users->role, $value['permissions'])){
                                continue;
                            }
                            if(isset($performPermScan) AND isset($value['cusPerm']) AND $value['cusPerm'] != ""){
                                if(!in_array($value['cusPerm'],$userPerm)){
                                    continue;
                                }
                            }
							if("gradeLevels" == $value['title'] || "newsboard" == $value['title'])
									{}
									else {
                            echo "<li><a ";
                            if(isset($value['children'])){
                                echo "class='has-arrow'";
                            }else{
                                echo "class='aj scrollTop'";
                            }
                            if(isset($value['url'])){
                                echo " href='".URL::to($value['url'])."'";
                            }
                            echo " aria-expanded='false'>";
                            echo "<i class='".$value['icon']."'></i><span class='hide-menu'>";
                            if(isset($panelInit->language[$value['title']])){
                                echo $panelInit->language[$value['title']];
                            }else{
                                echo $value['title'];
                            }
                            echo "</span>";
                            echo "</a>";
                            if(isset($value['children'])){
                                echo '<ul aria-expanded="false" class="collapse">';
                                while (list($key2, $value2) = each($value['children'])) {
                                    if(isset($value2['activated']) AND !strpos($panelInit->settingsArray['activatedModules'],$value2['activated']) ){ continue;  }
                                    if(!in_array($users->role, $value2['permissions'])){
                                        continue;
                                    }
                                    if(isset($performPermScan) AND isset($value2['cusPerm']) AND $value2['cusPerm'] != ""){
                                        if(!in_array($value2['cusPerm'],$userPerm)){
                                            continue;
                                        }
                                    }
									if("gradeLevels" == $value2['title'] || "newsboard" == $value2['title'])
									{}
									else {
                                    echo "<li>";
                                    echo "<a class='aj scrollTop' href='".URL::to($value2['url'])."'>";
                                    if(isset($panelInit->language[$value2['title']])){
                                        echo $panelInit->language[$value2['title']];
                                    }else{
                                        echo $value2['title'];
                                    }
                                    echo "</a>";
                                    echo "</li>";
									}
                                }
                                echo "</ul>";
                            }
                            echo "</li>";
									}
                        }
                        ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
            <div class="sidebar-footer">
                <!-- item-->
                <a href="{{URL::to('#/account')}}" class="link" data-toggle="tooltip" title="<?php echo $panelInit->language['AccountSettings']; ?>"><i class="ti-settings"></i></a>
                <!-- item-->
                <a href="{{URL::to('#/messages')}}" class="link" data-toggle="tooltip" title="<?php echo $panelInit->language['Messages']; ?>"><i class="mdi mdi-gmail"></i></a>
                <!-- item-->
                <a href="{{URL::to('/logout')}}" class="link" data-toggle="tooltip" title="<?php echo $panelInit->language['logout']; ?>"><i class="mdi mdi-power"></i></a>
            </div>
            <!-- End Bottom points-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <div id='parentDBArea' ng-view></div>

                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> <?php echo $panelInit->language['servicePanel']; ?> <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <?php if( $panelInit->settingsArray['layoutColorUserChange'] == "1" ){ ?>
                                <ul id="themecolors" class="m-t-20">
                                    <li><b><?php echo $panelInit->language['lightSidebar']; ?></b></li>
                                    <li><a ng-click="changeTheme('default')" href="javascript:void(0)" data-theme="default" class="default-theme" ng-class="{'working':$root.dashboardData.baseUser.defTheme == 'default'}">1</a></li>
                                    <li><a ng-click="changeTheme('green')" href="javascript:void(0)" data-theme="green" class="green-theme" ng-class="{'working':$root.dashboardData.baseUser.defTheme == 'green'}">2</a></li>
                                    <li><a ng-click="changeTheme('red')" href="javascript:void(0)" data-theme="red" class="red-theme" ng-class="{'working':$root.dashboardData.baseUser.defTheme == 'red'}">3</a></li>
                                    <li><a ng-click="changeTheme('blue')" href="javascript:void(0)" data-theme="blue" class="blue-theme" ng-class="{'working':$root.dashboardData.baseUser.defTheme == 'blue'}">4</a></li>
                                    <li><a ng-click="changeTheme('purple')" href="javascript:void(0)" data-theme="purple" class="purple-theme" ng-class="{'working':$root.dashboardData.baseUser.defTheme == 'purple'}">5</a></li>
                                    <li><a ng-click="changeTheme('megna')" href="javascript:void(0)" data-theme="megna" class="megna-theme" ng-class="{'working':$root.dashboardData.baseUser.defTheme == 'megna'}">6</a></li>
                                    <li class="d-block m-t-30"><b><?php echo $panelInit->language['darkSidebar']; ?></b></li>
                                    <li><a ng-click="changeTheme('default-dark')" href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme" ng-class="{'working':$root.dashboardData.baseUser.defTheme == 'default-dark'}">7</a></li>
                                    <li><a ng-click="changeTheme('green-dark')" href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme" ng-class="{'working':$root.dashboardData.baseUser.defTheme == 'green-dark'}">8</a></li>
                                    <li><a ng-click="changeTheme('red-dark')" href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme" ng-class="{'working':$root.dashboardData.baseUser.defTheme == 'red-dark'}">9</a></li>
                                    <li><a ng-click="changeTheme('blue-dark')" href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme" ng-class="{'working':$root.dashboardData.baseUser.defTheme == 'blue-dark'}">10</a></li>
                                    <li><a ng-click="changeTheme('purple-dark')" href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme" ng-class="{'working':$root.dashboardData.baseUser.defTheme == 'purple-dark'}">11</a></li>
                                    <li><a ng-click="changeTheme('megna-dark')" href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme" ng-class="{'working':$root.dashboardData.baseUser.defTheme == 'megna-dark'}">12</a></li>
                                </ul>
                            <?php } ?>
                            <br/>
                            <?php if($role == "admin"){ ?>
                                <span class="d-block"><?php echo $panelInit->language['chgAcademicyears']; ?></span>
                                <form class="form">
                                    <div class="form-group m-t-10 row">
                                        <div class="col-12">
                                            <select class="form-control" id="selectedAcYear" ng-model="dashboardData.selectedAcYear">
                                                <option ng-selected="year.id == '<?php echo $panelInit->selectAcYear; ?>'" ng-repeat="year in $root.dashboardData.academicYear" value="@{{year.id}}" ng-if="year.isDefault == '0'">@{{year.yearTitle}}</option>
                                                <option ng-selected="year.id == '<?php echo $panelInit->selectAcYear; ?>'" ng-repeat="year in $root.dashboardData.academicYear" value="@{{year.id}}" ng-if="year.isDefault == '1'">@{{year.yearTitle}} - Default Year</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group m-b-0">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success btn-flat pull-right ng-binding" ng-click="chgAcYear()"><?php echo $panelInit->language['chgYear']; ?></button>
                                        </div>
                                    </div>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <div class="preloader" id="overlay" style="opacity:0.9;">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                </svg>
            </div>
            <footer class="footer" <?php if($panelInit->settingsArray['leftmenuScroller'] != "e"){ ?> style='position:fixed !important;' <?php } ?>>
                <?php echo $panelInit->settingsArray['footer']; ?> -  <a target="_BLANK" href="{{URL::to('/terms')}}"><?php echo $panelInit->language['schoolTerms']; ?></a>
            </footer>
        </div>

        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <input type="hidden" id="rooturl" value="{{URL::asset('/')}}"/>
    <input type="hidden" id="utilsScript" value="{{URL::asset('assets/js/utils.js')}}"/>
    <script src="{{URL::asset('assets/plugins/jquery/jQuery-2.1.4.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{URL::asset('assets/plugins/bootstrap/js/tether.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/bootstrap/js/popper.min.js')}}" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{URL::asset('assets/js/jquery.slimscroll.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{URL::asset('assets/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{URL::asset('assets/js/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{URL::asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{URL::asset('assets/plugins/echarts/echarts-all.js')}}"></script>

    <script src="{{URL::asset('assets/js/custom.min.js')}}"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{URL::asset('assets/js/schoex.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('assets/js/intlTelInput.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/ckeditor/ckeditor.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/toast-master/js/jquery.toast.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.colorbox-min.js')}}"></script>
    <script src="{{URL::asset('assets/js/moment.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/humanize-duration/humanize-duration.js')}}"></script>

    <script type="text/javascript" src="{{URL::asset('assets/plugins/global-calendars/jquery.plugin.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/plugins/global-calendars/jquery.calendars.all.js')}}"></script>
    <?php if($panelInit->settingsArray['gcalendar'] != "gregorian"){ ?>
        <?php
        $gcalendar = $panelInit->settingsArray['gcalendar'];
        if($gcalendar == "ethiopic"){
            $gcalendar = "ethiopian";
        }

        ?>
        <script type="text/javascript" src="{{URL::asset('assets/plugins/global-calendars/jquery.calendars.'.$gcalendar.'.min.js')}}"></script>
    <?php } ?>

    <script src="{{URL::asset('assets/js/Angular/angular.min.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('assets/js/Angular/AngularModules.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('assets/js/Angular/app.js')}}"></script>
    <script src="{{URL::asset('assets/js/Angular/routes.js')}}" type="text/javascript"></script>
    <?php if( isset($panelInit->settingsArray['gTrackId']) AND $panelInit->settingsArray['gTrackId'] != "" ): ?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', '<?php echo $panelInit->settingsArray['gTrackId']; ?>', 'auto');
            ga('send', 'pageview');
        </script>
    <?php endif; ?>
</body>

</html>

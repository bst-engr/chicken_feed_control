<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="navbar-default sidebar"  role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul id="side-menu" class="nav in">
        @if (Sentry::check() && Sentry::getUser()->hasAccess('dashboard'))
        <li {{ (\Request::segment(1) == 'home') ? "class=active" : ""}}>
            <a href="{{action('DashboardController@index')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>
        @endif
        @if (Sentry::check() && Sentry::getUser()->hasAccess('performance_reports'))
        <li {{ (\Request::segment(1) == 'reports') ? "class=activ1e" : ""}}>
            <a href="#"><i class="fa fa-fw fa-file"></i> Performance Reports <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="#">Flock Wise Reports<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        @if (Sentry::check() && Sentry::getUser()->hasAccess('daily_reports'))
                        <li>
                            <a href="#">Daily Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-fourth-level">
                                <li>
                                    <a href="{{action('ReportsController@dailyFeedReport')}}">Feed Report</a>
                                </li>
                                <li>
                                    <a href="{{action('ReportsController@dailyWaterConsumptionReport')}}">Daily Water Consumption / Bird</a>
                                </li>
                                <li>
                                    <a href="{{action('ReportsController@getDailyMortalityReport')}}">Mortality</a>
                                </li>
                                <li>
                                    <a href="{{action('ReportsController@getDailyTempratureReport')}}">Daily Temprature</a>
                                </li>
                                <li>
                                    <a href="{{action('ReportsController@getDailyHumidityReport')}}">Daily Humidity</a>
                                </li>
                                <li>
                                    <a href="{{action('ReportsController@getEggWeightReport')}}">Daily Egg Weight</a>
                                </li>
                                <li>
                                    <a href="{{action('ReportsController@getEggProductionReport')}}">Daily Egg Production</a>
                                </li>
                                
                            </ul>
                        </li>
                        @endif
                        @if (Sentry::check() && Sentry::getUser()->hasAccess('weekly_reports'))
                        <li>
                            <a href="#">Weekly Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-fourth-level">
                                <li>
                                    <a href="{{action('ReportsController@getBodyWeightReport')}}">Body Weight</a>
                                </li>
                                <li>
                                    <a href="{{action('ReportsController@getUniformityReport')}}">Uniformity</a>
                                </li>
                                <li>
                                    <a href="{{action('ReportsController@getManureRemovalReport')}}">Manure Removal</a>
                                </li>
                                <li>
                                    <a href="{{action('ReportsController@getLightIntensityReport')}}">Light Intensity</a>
                                </li>
                                <li>
                                    <a href="{{action('ReportsController@getWindVelocityReport')}}">Wind Velocity</a>
                                </li>
                                <li>
                                    <a href="{{action('ReportsController@eggsPerHenHousedReport')}}">Eggs Per Hen Housed</a>
                                </li>
                               
                            </ul>
                        </li>
                        @endif
                        @if (Sentry::check() && Sentry::getUser()->hasAccess('consolidated_reports'))
                        <li>
                            <a href="#">Consolidated Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-fourth-level">
                                <li>
                                    <a href="{{action('ReportsController@getDailyConsolidatedReport')}}">Daily Consolidated</a>
                                </li>
                                 <li>
                                    <a href="{{action('ReportsController@getWeeklyConsolidatedReport')}}">Weekly Consolidated</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Sentry::check() && Sentry::getUser()->hasAccess('blood_titers'))
                        <li>
                            <a href="#">Monthly Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-fourth-level">
                                <li>
                                    <a href="{{action('ReportsController@getTitersReport')}}">Blood Titers</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Sentry::check() && Sentry::getUser()->hasAccess('periodical_reports'))
                        <li>
                            <a href="#">Periodical Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-fourth-level">
                                <li>
                                    <a href="{{action('ReportsController@periodicalReports',array(1))}}">Day One Shed disinfection</a>
                                </li>
                                <li>
                                    <a href="{{action('ReportsController@periodicalReports',array(2))}}">Disease Attack Report</a>
                                </li>
                                <li>
                                    <a href="{{action('ReportsController@periodicalReports',array(3))}}">Other Reports</a>
                                </li>
                                
                            </ul>
                        </li>
                        @endif
                    </ul>
                    
                </li>
                
                @if (Sentry::check() && Sentry::getUser()->hasAccess('comparison_reports'))
                <li>
                    <a href="#">Comparison Reports<span class="fa arrow"></span></a>
                    <ul class="nav nav-fourth-level">
                        <li>
                            <a href="{{action('ReportsController@getFlockComparisonRerport')}}">Comparative Report</a>
                        </li>
                        <li {{ (\Request::segment(2) == 'administration') ? "" : ""}}>
                            <a href="{{action('TiterController@vacComparison')}}"><i class="fa fa-fw fa-eyedropper"></i> Vaccine Administration</a>
                        </li>
                    </ul>
                </il>
                 @endif
                
            </ul>
        </li>
        @endif
        <li>
            <a href="#"><i class="fa fa-fw fa-wrench"></i> House keeping <span class="fa arrow"></span></a>            
            <ul class="nav nav-second-level">
                @if (Sentry::check() && (Sentry::getUser()->hasAccess('users') || Sentry::getUser()->hasAccess('admin')) )
                <li {{ (\Request::segment(1) == 'flocks') ? "class=active" : ""}}>
                    <a href="{{action('FlocksController@index')}}"><i class="fa fa-fw fa-building"></i> Flocks</a>
                </li>
                @endif
                @if (Sentry::check() && Sentry::getUser()->hasAccess('manage_titers'))
                <li {{ (\Request::segment(1) == 'disease') ? "class=active" : ""}}>
                    <a href="{{action('DiseasesController@index')}}"><i class="fa fa-fw fa-bug"></i> Manage Titer</a>
                </li>
                 @endif
                @if (Sentry::check() && Sentry::getUser()->hasAccess('manage_vaccines'))
                <li {{ (\Request::segment(1) == 'vaccine') ? "class=active" : ""}}>
                    <a href="{{action('VaccinesController@index')}}"><i class="fa fa-fw fa-eyedropper"></i> Manage Vaccines</a>
                </li>
                 @endif
                @if (Sentry::check() && Sentry::getUser()->hasAccess('manage_mortalities'))
                <li {{ (\Request::segment(1) == 'disease') ? "class=active" : ""}}>
                    <a href="{{action('MortalityController@index')}}"><i class="fa fa-fw fa-bug"></i> Manage Mortalities</a>
                </li>
                 @endif
                
            </ul>
        </li>
        
        

        
        
        @if (Sentry::check() && Sentry::getUser()->hasAccess('daily_feed'))
       <!--  <li {{ (\Request::segment(1) == 'timelog') ? "class=active" : ""}}>
            <a href="{{ route('timelog.index') }}"><i class="fa fa-clock-o"></i> Daily Feed</a>
        </li> -->
        @endif
    </ul>
</div>
</div>

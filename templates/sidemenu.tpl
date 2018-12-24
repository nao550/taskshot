  <div class="nav-side-menu">
    <div class="brand"><h1><a href="./tasks.php">Task Shot</a></h1></div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">

      <ul id="menu-content" class="menu-content collapse out">
          <li  data-toggle="collapse" data-target="#daterange" class="collapsed" id="DateRangeCollapse" aria-expanded="true">
              <a href="#"><i class="fa fa-calendar fa-lg fa-fw sidebar-icon"></i> DateRange <span class="arrow"></span></a>
          </li>
          <ul class="sub-menu collapse in" id="daterange">
              <li><a href="./endtasks.php?mode=endtasks"><i class="fa fa-angle-double-right"></i> End Tasks</a></li>
              <li><a href="./tasks.php"><i class="fa fa-angle-double-right"></i> All</a></li>
              <li><a href="./tasks.php?eddate={$arDayrange['runout']['ed']}"><i class="fa fa-angle-double-right"></i> Expired</a></li>
              <li><a href="./tasks.php?stdate={$arDayrange['today']['st']}&eddate={$arDayrange['today']['ed']}"><i class="fa fa-angle-double-right"></i> Today</a></li>
              <li><a href="./tasks.php?stdate={$arDayrange['next3day']['st']}&eddate={$arDayrange['next3day']['ed']}"><i class="fa fa-angle-double-right"></i> 3 days</a></li>
              <li><a href="./tasks.php?stdate={$arDayrange['thisweek']['st']}&eddate={$arDayrange['thisweek']['ed']}"><i class="fa fa-angle-double-right"></i> Week</a></li>
              <li><a href="./tasks.php?stdate={$arDayrange['thismonth']['st']}&eddate={$arDayrange['thismonth']['ed']}"><i class="fa fa-angle-double-right"></i> Month</a></li>
          </ul>

        <li  data-toggle="collapse" data-target="#tagcloud" class="collapsed">
          <a href="#"><i class="fa fa-puzzle-piece fa-lg fa-fw sidebar-icon"></i> Tags <span class="arrow"></span></a>
        </li>
        <ul class="sub-menu collapse" id="tagcloud">
          <li><a href="#"><i class="fa fa-angle-double-right"></i> Devices</a></li>
          <li><a href="#"><i class="fa fa-angle-double-right"></i> Groups</a></li>
          <li><a href="#"><i class="fa fa-angle-double-right"></i> SIM Cards</a></li>
          <li><a href="#"><i class="fa fa-angle-double-right"></i> Users</a></li>
        </ul>

        <li  data-toggle="collapse" data-target="#settings" class="collapsed">
          <a href="#"><i class="fa fa-sliders fa-lg fa-fw sidebar-icon"></i> Settings <span class="arrow"></span></a>
        </li>
        <ul class="sub-menu collapse" id="settings">
          <li><a href="#"><i class="fa fa-angle-double-right"></i> Profile</a></li>
          <li><a href="settings.php"><i class="fa fa-angle-double-right"></i> Settings</a></li>
          <li><a href="#" onClick="logout()"><i class="fa fa-angle-double-right"></i> Logout</a></li>
        </ul>

      </ul>
    </div>
  </div>

{include file='header.tpl'}
  <link rel="stylesheet" type="text/css" href="./css/slidemenu.css" />
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="./js/tasks.js"></script>
</head>
<body>
  <div class="nav-side-menu">
    <div class="brand">Task Shot</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">

      <ul id="menu-content" class="menu-content collapse out">
          <!--
        <li>
          <a href="./tasks.php"><i class="fa fa-calendar fa-lg fa-fw sidebar-icon"></i> All</a>
        </li>

        <li>
          <a href="./tasks.php?eddate={$eddate}">
            <i class="fa fa-calendar-minus-o fa-lg fa-fw sidebar-icon"></i> Run Out
          </a>
        </li>

        <li>
          <a href="./tasks.php?stdate={$stdate}&eddate={$eddate}">
            <i class="fa fa-calendar-o fa-lg fa-fw sidebar-icon"></i> Today
          </a>
        </li>
-->
          <li  data-toggle="collapse" data-target="#daterange" class="collapsed" id="DateRangeCollapse" aria-expanded="true">
              <a href="#"><i class="fa fa-calendar fa-lg fa-fw sidebar-icon"></i> DateRange <span class="arrow"></span></a>
          </li>
          <ul class="sub-menu collapse in" id="daterange">
              <li><a href="./tasks.php"><i class="fa fa-angle-double-right"></i> All</a></li>
              <li><a href="./tasks.php?eddate={$eddate}"><i class="fa fa-angle-double-right"></i> RunOut</a></li>
              <li><a href="./tasks.php?stdate={$stdate}&eddate={$eddate}"><i class="fa fa-angle-double-right"></i> Today</a></li>
              <li><a href="#"><i class="fa fa-angle-double-right"></i> Next 3 days</a></li>
              <li><a href="#"><i class="fa fa-angle-double-right"></i> This Week</a></li>
              <li><a href="#"><i class="fa fa-angle-double-right"></i> This Month</a></li>
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
          <li><a href="#"><i class="fa fa-angle-double-right"></i> Settings</a></li>
          <li><a href="#" onClick="logout()"><i class="fa fa-angle-double-right"></i> Logout</a></li>
        </ul>

      </ul>
    </div>
  </div>
<!--
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2 sidenavi">
        <div id="sidemenu">
          <dt>DateRange</dt>
          <dd><a href="./tasks.php">all</a></dd>
          <dd><a href="./tasks.php?eddate={$eddate}">run out</a></dd>
          <dd><a href="./tasks.php?stdate={$stdate}&eddate={$eddate}">today</a></dd>
          <dd>tomorrow</dd>
          <dd>next 3 days</dd>
          <dd>this week</dd>
          <dd>this month
        </div>
      </div>
-->
  <div class="main">
    <div class="container-fluid">
      <div class="row"
       <div class="col-md-12 tasklist">
        <table class="table table-condensed" id="tasktable">
          <thead>
            <tr>
                <th>rank</th>
                <th>tag</th>
                <th>date</th>
                <th>work</th>
                <th></th>

                <!--
              <th class="col-md-1">rank</th>
              <th class="col-md-2">tag</th>
              <th class="col-md-2">date</th>
              <th class="col-md-6">work</th>
              <th class="col-md-1"></th>
              -->
            </tr>
          </thead>
          <tbody>
            <tr>
              <form class="form-inline" name="addtask" action="#" method="POST">
                <td>
                  <div class="form-group">
                    <select class="form-control" name="rank">
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                  </div>
                </td>
                <td><div class="form-group"><input type="text" class="form-control" name="tag" /></div></td>
                <td><div class="form-group"><input type="text" class="form-control" name="date" id="datepicker" /></div></td>
                <td><div class="form-group"><input type="text" class="form-control" name="work" /></div></td>
                <td>
                  <input type="hidden" id="token" name="token" value="{$token}" />
                  <button class="btn btn-default" type="submit" name="mode" value="add">add</button>
                </td>
              </form>
            </tr>
            {foreach item=tasks from=$arTask}
              <tr>
                <td class="editable taskrank">{$tasks.rank}</td>
                <td class="editable tasktag">{$tasks.tag}</td>
                <td class="editable taskdate">{$tasks.date}</td>
                <td class="editable taskwork">{$tasks.work}</td>
                <td class="taskcd"><span hidden>{$tasks.cd}</span>
                  <button class="btn btn-default" name="endTask" onClick="endTask({$tasks.cd})">End</button>
                </td>
              </tr>
            {/foreach}
          </tbody>
        </table>
      </div>
    </div>
      </div>
    </div>

{include file='footer.tpl'}

{include file='header.tpl'}
  <link rel="stylesheet" type="text/css" href="./css/slidemenu.css" />
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
{include file='sidemenu.tpl'}
  <div class="main">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <h2>Display Settings</h2>
          <hr />
          <form class="form-inline" action="#" name="settingfrm" method="post">
            <div class="form-group">
              <label for="starTaskRange">Initial Display</label>
              <select class="form-control" id="startTaskRange" name="startTaskRange" >
                <option vaule="all">All</option>
                <option value="runout">RunOut</option>
                <option value="today">Today</option>
                <option value="3days">3 days</option>
                <option value="week">Week</option>
                <option value="month">Month</option>
              </select>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="./js/tasks.js"></script>

{include file='footer.tpl'}

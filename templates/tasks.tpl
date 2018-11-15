{include file='header.tpl'}
  <link rel="stylesheet" type="text/css" href="./css/slidemenu.css" />
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
{include file='sidemenu.tpl'}
  <div class="main">
    <div class="container-fluid">
      <div class="row"
       <div class="col-md-12 tasklist">
        <table class="table table-condensed" id="tasktable">
          <thead>
            <tr>
                <th>Rank</th>
                <th>Tag</th>
                <th>Date</th>
                <th>Work</th>
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
                <!--
                <td>
                  <div class="form-group">
                    <select class="form-control" name="rank" id="rank">
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3√</option>
                    </select>
                  </div>
                </td>
                <td><div class="form-group"><input type="text" class="form-control" name="tag" /></div></td>
                <td><div class="form-group"><input type="text" class="form-control" name="date" id="datepicker" autocomplete="off" /></div></td>
                <td><div class="form-group"><input type="text" class="form-control" name="work" /></div>
                </td>
                -->

                <td colspan="4">
                  <div class="form-group">
                    <input type="text" class="form-control" name="inputtask">
                  </div>
                </td>

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
  <script src="./js/tasks.js"></script>
{include file='footer.tpl'}

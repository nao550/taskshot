{include file='header.tpl'}

<body>
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-2">
        <div class="sidenavi">
          <div class="pagetitle"><h1>TaskShot</h1></div>
          <div class="sidemenu">
            <dt>DateRange</dt>
            <dd><a href="./tasks.php">all</a></dd>
            <dd><a href="./tasks.php?eddate={$eddate}">run out</a></dd>
            <dd><a href="./tasks.php?stdate={$stdate}&eddate={$eddate}">today</a></dd>
            <dd>tomorrow</dd>
            <dd>next 3 days</dd>
            <dd>this week</dd>
            <dd>this month</dd>
          </div>
        </div>
      </div>
      <div class="col-md-10">
        <div class="main">
          <table class="table">
            <thead>
              <tr>
                <th class="col-md-1">rank</th>
                <th class="col-md-2">tag</th>
                <th class="col-md-2">date</th>
                <th class="col-md-6">work</th>
                <th class="col-md-1"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <form class="form-inline" name="addtask" action="#" method="POST">
                  <div class="form-group">
                    <td>
                      <select class="form-control" name="rank">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                      </select>
                    </td>
                    <td><input type="text" class="form-control" name="tag" /></td>
                    <td><input type="text" class="form-control" name="date" /></td>
                    <td><input type="text" class="form-control" name="work" /></td>
                    <td>
                      <input type="hidden" id="token" name="token" value="{$token}" />
                      <button class="btn" type="submit" name="mode" value="add">add</button>
                  </div>
                </form>
              </tr>
              {foreach item=tasks from=$arTask}
                <tr>
                  <form class="form-inline" name="task" action="#" method="post">
                    <div class="form-group">
                      <td id="taskrank">{$tasks.rank}</td>
                      <td id="tasktag">{$tasks.tag}</td>
                      <td id="taskdate">{$tasks.date}</td>
                      <td id="taskwork">{$tasks.work}</td>
                      <td>
                        <input type="hidden" id="taskcd" name="taskcd" value="{$tasks.cd}" />
                        <button class="btn" type="submit" name="mode" value="end">end</button>
                      </td>
                    </div>
                  </form>
                </tr>
              {/foreach}
            </tbody>
          </table>
          <form class="form-inline" name="logout" action="#" method="post">
            <input type="hidden" name="mode" value="logout" />
            <input class="form-control" type="submit" value="logout" />
          </form>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-10 col-md-offset-1">

      </div>
    </div>
  </div>

{include file='footer.tpl'}

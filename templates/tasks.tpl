{include file='header.tpl'}

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="header">
          <div class="pagetitle"><h1>TaskShot</h1></div>
        </div>
        <div class="main">
          <table class="table">
            <thead>
              <tr>
                <th class="col-md-1">flg</th>
                <th class="col-md-1">lank</th>
                <th class="col-md-2">tag</th>
                <th class="col-md-2">date</th>
                <th class="col-md-5">work</th>
                <th class="col-md-1"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <form class="form-inline" name="addtask" action="#" method="POST">
                  <div class="form-group">
                    <td></td>
                    <td><input type="text" class="form-control" name="lank" /></td>
                    <td><input type="text" class="form-control" name="tag" /></td>
                    <td><input type="text" class="form-control" name="date" /></td>
                    <td><input type="text" class="form-control" name="work" /></td>
                    <td>
                      <input type="hidden" name="token" value="{$token}" />
                      <button class="btn" type="submit" name="mode" value="add">add</button>
                  </div>
                </form>
              </tr>
              {foreach item=tasks from=$arTask}
                <tr>
                  <form class="form-inline" name="task" action="#" method="post">
                    <div class="form-group">
                      <td>
                        <input type="hidden" name="cd" value="{$tasks.cd}" />
                        <button class="btn" type="submit" name="mode" value="end">end</button>
                      </td>
                      <td>{$tasks.lank}</td>
                      <td>{$tasks.tag}</td>
                      <td>{$tasks.date}</td>
                      <td>{$tasks.work}</td>
                      <td>
                        <button class="btn" type="submit" name="mode" value="up">up</button>
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

{include file='header.tpl'}
  <link rel="stylesheet" type="text/css" href="./css/slidemenu.css" />
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

  <div class="container-fluid">
    <div class="col-xs-12">
      <form class="form-horizontal"  name="addtask" action="tasks.php" method="POST">
        <div class="form-group">
          <label class="control-label col-xs-1" for="work">Task</label>
          <div class="col-xs-11">
            <input type="text" class="form-control" id="work" name="work" value="{$task.work}" />
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-1" for="date">Date</label>
          <div class="col-xs-11">
            <input type="text" class="form-control" id="date" name="date" value="{$task.date}" />
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-1" for="tag">Tag</label>
          <div class="col-xs-11">
            <input type="text" class="form-control" id="tag" name="tag" value="{$task.tag}" />
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-xs-1" for="rank">Rank</label>
          <div class="col-xs-11">
            <select class="form-control" name="rank" id="rank">
              <option value=""></option>
              <option value="0"{if $task.rank eq '0'}selected="selected"{/if}>0</option>
              <option value="1"{if $task.rank eq '1'}selected="selected"{/if}>1</option>
              <option value="2"{if $task.rank eq '2'}selected="selected"{/if}>2</option>
              <option value="3"{if $task.rank eq '3'}selected="selected"{/if}>3</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-1" for="rank">Memo</label>
          <div class="col-xs-11">
            <textarea class="form-control" name="memo" rows="4" >{$task.memo}</textarea>
          </div>
        </div>

        <div class="from-croup">
          <div class="col-xs-2">
            <input type="hidden" id="cd" name="cd" value="{$task.cd}" />
            <input type="hidden" id="token" name="token" value="{$token}" />
            <button class="btn btn-default" type="submit" name="mode" value="upTask">Update</button>
          </div>
          <div class="col-xs-1 col-xs-offset-9">
            <button class="btn btn-danger" type="submit" name="mode" value="delTask">Del</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="./js/tasks.js"></script>

{include file='footer.tpl'}

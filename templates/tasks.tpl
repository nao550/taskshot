{include file='header.tpl'}
  <link rel="stylesheet" type="text/css" href="./css/slidemenu.css" />
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
{include file='sidemenu.tpl'}
  <div class="main">
    <div class="container-fluid">
      <div class="row tasklist">
        <form name="addtask" action="#" method="POST">
          <div class="col-xs-10">
            <input type="text" class="form-control" name="linetask" />
          </div>
          <div class="col-xs-2">
            <input type="hidden" id="token" name="token" value="{$token}" />
            <button class="btn btn-default" type="submit" name="mode" value="add">add</button>
          </div>
        </form>
      </div>
      {foreach item=tasks from=$arTask}
        <div class="row tasklist align-self-center">
          <div class="col-xs-10 taskline" style="padding-top: 3px;padding-bottom: 2px">
            <div class="cd hidden" >{$tasks.cd}</div>
            <span class="task
              {if $tasks.rank == '0'}
                rank0
              {elseif $tasks.rank == '1'}
                rank1
              {elseif $tasks.rank == '2'}
                rank2
              {elseif $tasks.rank == '3'}
                rank3
              {/if}
                  ">
              {$tasks.work}&nbsp;
              {foreach from=","|explode:$tasks.tag item="tag"}
                <span class="badge badge-secondary">{$tag}</span>
              {/foreach}
            </span>
            <span class="date">
              {$tasks.date}
            </span>
          </div>
          <div class="col-xs-2">
            <button class="btn btn-default" name="endTask" onClick="endTask({$tasks.cd})">End
            </button>
            <dutton>

          </div>
        </div>
      {/foreach}
    </div>
  </div>

  <script src="./js/tasks.js"></script>

{include file='footer.tpl'}

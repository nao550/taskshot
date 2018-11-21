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
          {foreach item=tasks from=$arTask}
            <div class="row tasklist align-self-center">
              <div class="col-xs-10 editable">
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
                <form name="reverttask" action="#" method="post" style="margin-bottom: 0px";>
                  <input type="hidden" name="taskcd" value="{$tasks.cd}" />
                  <input type="hidden" id="token" name="token" value="{$token}" />
                  <input type="hidden" name="mode" value="RevertTask" />
                  <button type="submit" class="btn btn-default" name="RevertTask">Revert</button>
                </form>
              </div>
            </div>
          {/foreach}
        </div>
      </div>
    </div>
    <script src="./js/endtasks.js"></script>
  </div>
  {include file='footer.tpl'}

{include file='header.tpl'}

</head>
<body>
    <div class="container-fluid">
       <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <div class="header">
              <div class="pagetitle"><h1>TaskShot</h1></div>
            </div>
            <div class="main">
              <form class="form-signin" action="#" method="post">
                <h2 class="form-signin-heading">Please sign in</h2>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
                <input type="hidden" id="mode" name="mode" value="login" />
                <input type="hidden" id="token" name="token" value="{$token}" />
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="inputRemember" name="inputRemember" /> Remember me
                  </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
              </form>
            </div>
          </div>
       </div>
    </div>

{include file='footer.tpl'}

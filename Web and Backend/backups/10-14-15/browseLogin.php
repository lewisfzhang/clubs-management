<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Club Sign In</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <script src="js/ie-emulation-modes-warning.js"></script>
    <style>
      .center {
        margin: auto;
      }
    </style>

  </head>

  <body>

    <div class="container">

        <form class="form-signin" action="" method="get">
          <br><br><br>
          <h2 class="center form-signin-heading">Student Sign In</h2>
          <br><br><br>
          <label for="studentid" class="sr-only">Student ID</label>
          <input type="text" name="studentid" id="studentid" class="form-control" placeholder="Student ID" required autofocus>
          <!--<div class="checkbox">
            <label>
              <input type="checkbox" value="remember-me"> Remember me
            </label>
          </div> -->
          <button style="margin-top: 20px;"class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>

      </div>

    </div>

    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
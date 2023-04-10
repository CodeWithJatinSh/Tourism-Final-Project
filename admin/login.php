<!-- 
  This code includes a PHP configuration file and a header file, 
  and then starts a HTML page with a login page style. It also 
  calls a JavaScript function "start_loader()" to begin loading 
  the page.
-->
<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>
  <!-- 
    This is a HTML code for a login box that includes a form for 
    users to enter their login credentials. The login box has a 
    title "Login" and a message "Sign in to start your session". 
    The form contains two input fields for username and password, 
    along with corresponding icons, and a "Sign In" button. 

    Additionally, there is a link to the website homepage, 
    and a commented-out link to a "forgot password" page. T
    he code is wrapped in a div with class "login-box".

  -->
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="./" class="h1"><b>Login</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="login-frm" action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <a href="<?php echo base_url ?>">Go to Website</a>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- 
  This is a set of JavaScript code that is included in an HTML file. 
  It includes three script tags that link to external JavaScript files: 
  jQuery, Bootstrap 4, and AdminLTE. These scripts provide various 
  functionality such as event handling, styling, and animations to 
  the HTML page. 
-->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- 
  The purpose of this code is to stop a loading animation that 
  was started earlier in the page, indicating that the page has 
  finished loading and is now ready to be interacted with.
-->
<script>
  $(document).ready(function(){
    end_loader();
  })
</script>
</body>
</html>
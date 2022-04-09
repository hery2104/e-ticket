<?php
// echo $newpass=password_hash('admin1', PASSWORD_DEFAULT);
// echo phpinfo();
include 'admin/backend.php';
$db=new backend;
// session_start();
if ($db->islogin()!="") {
  $db->redirect('admin/index.php');
}
if (isset($_POST['btn-login'])) {
  $uname=$_POST['txt_uname'];
  $upass=$_POST['txt_password'];

  if ($db->login($uname,$upass)) {
    $db->redirect('admin/index.php');
  }else{
    $error="Wrong Details!";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon.png">
  <title>Administrator | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.css" rel="stylesheet">
  <!-- Font Awesome -->
  <style type="text/css">
    /*
 * Specific styles of signin component
 */
/*
 * General styles
 */
 body, html {
  height: 100%;
  background-repeat: no-repeat;
  background-color: #eaeaea;
}

.card-container.card {
  max-width: 350px;
  padding: 40px 40px;
}

.btn {
  font-weight: 700;
  height: 36px;
  -moz-user-select: none;
  -webkit-user-select: none;
  user-select: none;
  cursor: default;
}

/*
 * Card component
 */
 .card {
  background-color: #fff;
  /* just in case there no content*/
  padding: 20px 25px 30px;
  margin: 0 auto 25px;
  margin-top: 50px;
  /* shadows and rounded borders */
  -moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  border-radius: 2px;
  -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}

.profile-img-card {
  max-width: 400px;
  height: 96px;
}

/*
 * Form styles
 */
 .profile-name-card {
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  margin: 10px 0 0;
  min-height: 1em;
}

.reauth-email {
  display: block;
  color: #404040;
  line-height: 2;
  margin-bottom: 10px;
  font-size: 14px;
  text-align: center;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

.form-signin #inputEmail,
.form-signin #inputPassword {
  direction: ltr;
  height: 44px;
  font-size: 16px;
}

.form-signin input[type=email],
.form-signin input[type=password],
.form-signin input[type=text],
.form-signin button {
  width: 100%;
  display: block;
  margin-bottom: 10px;
  z-index: 1;
  position: relative;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

.form-signin .form-control:focus {
  border-color: rgb(104, 145, 162);
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
  box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
}

.btn.btn-signin {
  /*background-color: #4d90fe; */
  background-color:#4267b2;
  /* background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
  padding: 0px;
  font-weight: 700;
  font-size: 14px;
  height: 36px;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  border: none;
  -o-transition: all 0.218s;
  -moz-transition: all 0.218s;
  -webkit-transition: all 0.218s;
  transition: all 0.218s;
}

.btn.btn-signin:hover,
.btn.btn-signin:active,
.btn.btn-signin:focus {
  background-color: #e52f48;
}

.forgot-password {
  color: rgb(104, 145, 162);
}

.forgot-password:hover,
.forgot-password:active,
.forgot-password:focus{
  color: rgb(12, 97, 33);
}
</style>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
 <div class="card card-container">
  <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
<div class="row">
	<img id="profile-img" style="max-width: 350px;padding: -20px !important;margin-top: -40px !important;margin-left: -25px !important;margin-top: -40px !important;margin-right: -40px !important;margin-bottom: 40px;" src="images/tiomaz.jpg" />
            <!-- <p id="profile-name" class="profile-name-card">Suzuya Hotel</p> -->
</div>
<div class="row">
	
  <center>
    <?php 
    if (isset($error)) { ?>
    <div class="alert alert-danger">
       &nbsp; Username atau password salah !
    </div>
    <?php
  }elseif (isset($_GET['logged'])) {
    ?>
    <div class="alert alert-success">
       &nbsp; Anda telah logout !
    </div>
    <?php
  }elseif (isset($_SESSION['errors'])) {
    ?>
    <div class="alert alert-success">
       &nbsp; <?php echo $_SESSION['errors']; ?>
    </div>
    <?php
  }
  ?>
</center>
</div>
<div class="row">
	<form class="form-signin" method="POST">
  <span id="reauth-email" class="reauth-email"></span>
  <input type="text" id="inputEmail" class="form-control" name="txt_uname" placeholder="Isikan Username" required autofocus>
  <input type="password" id="inputPassword" class="form-control" name="txt_password" placeholder="Isikan Password" required>
  <div id="remember" class="checkbox">
  </div>
  <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="btn-login">Log in</button>
</form>
</div><!-- /card-container -->

<div class="social-auth-links text-center">

</div>
<!-- /.login-box-body -->
</div>
</form>
</div>


</body>
</html>

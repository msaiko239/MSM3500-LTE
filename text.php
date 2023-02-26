<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>

<body>
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<style>
aside {
  color: #fff;
  width: 250px;
  padding-left: 20px;
  height: 100vh;
  background-image: linear-gradient(30deg , #0048bd, #44a7fd);
  border-top-right-radius: 80px;
  position: absolute;
  left: 0;
}

aside a {
  font-size: 19px;
  color: #fff;
  display: block;
  padding: 12px;
  padding-left: 30px;
  text-decoration: none;
  -webkit-tap-highlight-color:transparent;
}

aside a:hover {
  color: #3f5efb;
  background: #fff;
  outline: none;
  position: relative;
  background-color: #fff;
  border-top-left-radius: 20px;
  border-bottom-left-radius: 20px;
}

aside a i {
  margin-right: 5px;
}

aside a:hover::after {
  content: "";
  position: absolute;
  background-color: transparent;
  bottom: 100%;
  right: 0;
  height: 35px;
  width: 35px;
  border-bottom-right-radius: 18px;
  box-shadow: 0 20px 0 0 #fff;
}

aside a:hover::before {
  content: "";
  position: absolute;
  background-color: transparent;
  top: 38px;
  right: 0;
  height: 35px;
  width: 35px;
  border-top-right-radius: 18px;
  box-shadow: 0 -20px 0 0 #fff;
}

aside p {
  margin: 0;
  padding: 40px 0;
}

body {
  font-family: 'Roboto';
  width: 100%;
  height: 100vh;
  margin: 0;
}
bgimage {
  background-image: url("/images/int.jpg");
  background-repeat: no-repeat;
  background-size: auto;
}

.social {
  height: 0;
}

.social i:before {
  width: 14px;
  height: 14px;
  font-size: 14px;
  position: fixed;
  color: #fff;
  background: #0077B5;
  padding: 10px;
  border-radius: 50%;
  top:5px;
  right:5px;
}
</style>
<aside>
  <p> Menu </p>
  <a href="index.php">
    <i class="fa fa-home" aria-hidden="true"></i>
    Home
  </a>
  <a href="config.php">
    <i class="fa fa-gear" aria-hidden="true"></i>
    Configure Interface
  </a>
  <a href="sendpage.php">
    <i class="fa fa-envelope-o" aria-hidden="true"></i>
    Send Message
  </a>
  <a href="status.php">
    <i class="fa fa-check-square-o" aria-hidden="true"></i>
    Service Status
  </a>
  <a href="input.php">
    <i class="fa fa-file-text-o" aria-hidden="true"></i>
    View Log
  </a>
  <a href="service.php">
    <i class="fa fa-file" aria-hidden="true"></i>
    Service Output
  </a>
</aside>

<div style="margin-left:15%">
<div class="w3-container" id="bgimage">
<br></br>
<div style="padding-left:16px">
<img src="images/sendmsg.jpg">
</div>
<br></br>
<div class="form">
<?php
$msg = $_POST['msg'];
$msisdn = $_POST['msisdn'];
$cmd = escapeshellcmd("sudo python3 /var/lib/asterisk/agi-bin/page.py '$msisdn' '$msg' '9999' '0'");
$output = shell_exec($cmd);
echo 'Your message - ' . $msg . ' was sent to user - ' . $msisdn;
//echo $msisdn;
//echo $cmd;
//echo $output
?>
</div>
<br></br>
<div class="form">
    <button onclick="window.location.href='sendpage.php';">
      Click to go Back
    </button>
</div>

</body>

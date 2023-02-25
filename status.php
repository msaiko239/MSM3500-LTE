<html>
 <head>
  <title>Message Server</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #6495ED;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #6495ED;
  color: white;
}

.box {
   display: flex;
   align-items:center;
}
.padding2
{
width:80px;
height:50px;
padding: 2px 20px 2px 20px;
}
.padding
{
width:80px;
height:80px;
padding: 2px 20px 2px 20px;
}
.img
{
    float: right;
    background-color: #FFFFFF;
    width:580px;
    height:380px;
    padding: 2px 150px 2px 2px;
}
.formfield * {
  vertical-align: top;

}
.banner {
padding: 16px 0px 0px 10px;
}
.form {
padding: 0px 0px 0px 10px;
}
.stat {
    position: absolute;
}
</style>
</head>
<body>

<div class="topnav">
  <a href="index.php">Home</a>
  <a href="config.php">Configure Interface</a>
  <a href="sendpage.php">Message Staff</a>
  <a class="active" href="status.php">Service Status</a>
  <a href="input.php">Log</a>
  <a href="service.php">Shell output</a>
</div>

<div class="banner">
<img src="images/servstat.jpg">
</div>
<br>
</br>
<div>
<img src="images/int.png" class="img">
</div>
<div class="stat">
<?php

$output = shell_exec('systemctl status asterisk.service');
$needle = "running";

if (strpos($output, $needle) !==false) {
  echo '<img src="images/MSMservicerunning.jpg" />';
  echo '<p>The MSM Service is Running</p>';
  echo '<a href="/restart.php" /><p> Click Here to Restart </p>';
  echo '<a href="/stop.php" /><p> Click Here to Stop </p>';
  echo '<p><a href="/reboot.php" /> Click Here to Reboot</p></a>';
} else {
  echo '<a href="/start.php" /><img src="images/MSMservicestopped.jpg"/p>';
  echo '<p>The MSM Service is Stopped Click the Banner to Start</p>';
  echo '<a href="/reboot.php" /><p>Click Here to Reboot</p></a>';
}
?>
</div>
<br></br>

  <div style="position: absolute; bottom: 10; left: 10; width: 1000px; text-align:left;">
           Message Server Rev 1.2
  </div>
</br>
 </body>
</html>

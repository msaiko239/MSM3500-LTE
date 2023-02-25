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
  <a class="active" href="sendpage.php">Message Staff</a>
  <a href="status.php">Service Status</a>
  <a href="input.php">Log</a>
  <a href="service.php">Shell output</a>
</div>

<div class="banner">
<img src="images/srvlog.jpg">
</div>
<br>
</br>
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
<br></br>

  <div style="position: absolute; bottom: 10; left: 10; width: 10000px; text-align:left;">
            Message Server Rev 1.2
  </div>
</br>
 </body>
</html>

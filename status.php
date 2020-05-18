<html>
 <head>
  <title>Message Server</title>
 </head>
<body>
<br>
 <?php echo '<img src="images/servstat.jpg"./'; ?> 
</br>
<?php

$output = shell_exec('systemctl status asterisk.service');
$needle = "running";

if (strpos($output, $needle) !==false) {
  echo '<img src="images/MSMservicerunning.jpg" />';
  echo '<p>The MSM Service is Running</>';
  echo '<a href="/restart.php" /><p> Click Here to Restart </>';
  echo '<a href="/stop.php" /><p> Click Here to Stop </>';
  echo '<a href="/reboot.php" /><p>Click Here to Reboot</>';
} else {
  echo '<a href="/start.php" /><img src="images/MSMservicestopped.jpg"/>';
  echo '<p>The MSM Service is Stopped Click the Banner to Start</>';
  echo '<a href="/reboot.php" /><p>Click Here to Reboot</>';
}
?>
<br>
</br>
<br>
<a href="index.php">Home</a>
<br>
  <div style="position: absolute; bottom: 10; left: 10; width: 10000px; text-align:left;">
            Message Server Rev 1.0
  </div>
</br>
</body>
</html>
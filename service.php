<html>
 <head>
  <title>Message Server</title>
 </head>
<body>
<br>
 <?php echo '<img src="images/srvlog.jpg"./'; ?> 
</br>
<?php

$output = shell_exec('sudo journalctl -u asterisk.service -n10');
echo "<pre>$output</pre>";
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

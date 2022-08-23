<html>
 <head>
  <title>Message Server</title>
 </head>
<body>
<h1>Message Sent</h1>
<br>
<?php
$msg = $_POST['msg'];
$msisdn = $_POST['msisdn'];
$cmd = escapeshellcmd("sudo python3 /var/www/html/manpage.py '$msisdn' '$msg' '9999' '0'");
$output = shell_exec($cmd);
echo 'Your message - ' . $msg . ' was sent to user - ' . $msisdn;
//echo $msisdn;
//echo $cmd;
//echo $output
?>
</br>
<br>
<a href="index.php">Home</a>
</br>
<br>
  <div style="position: absolute; bottom: 10; left: 10; width: 10000px; text-align:left;">
            Message Server Rev 1.1
  </div>
</br>

</body>
</html>

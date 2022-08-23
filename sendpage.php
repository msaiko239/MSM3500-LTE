<html>
 <head>
  <title>Message Server</title>
 </head>
<style>
.formfield * {
  vertical-align: top;
}
</style>
<body>
<br>
 <?php echo '<img src="images/sendmsg.jpg"./'; ?>
</br>
<br></br>
<br>
<form name="myform" method="POST" action="text.php">
    <p class="formfield">
    <label>Message:</label>
    <textarea type='textarea' id='msg' name='msg'></textarea>
    </p>
    <label>Staff Member:</label>
    <select name='msisdn' value='test' style='width: 200px;'>
    <option value="" disabled selected>Select Staff Ext</option>
        <?php
        ini_set("display_errors",1);
        error_reporting(E_ALL);
        $obj = file_get_contents('http://raemis:password@192.168.100.2/api/subscriber');
        $colm = (array_column(json_decode($obj), 'msisdn'));

        foreach($colm as $item){
                echo "<option id='val' name='val' value='$item'>$item</option>";
                echo "<br>";
            }
        ?>
    </select>
<br>
</br>
    <input type='image' name 'submit' src='/images/hNfHB.png' alt='Submit' style='width: 200px;'></input>
<?php
$msg = 'msg';
$msisdn = 'msisdn';
echo shell_exec("python3 /var/www/html/manpage.py '$msisdn' '$msg' '8888' '0'"); ?>
</form>
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

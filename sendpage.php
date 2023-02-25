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
    padding: 2px 350px 2px 2px;
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
<img src="images/sendmsg.jpg">
</div>
<br>
</br>
<div>
<img src="images/int.png" class="img">
</div>
<br>
<form name="myform" method="POST" action="text.php" class="form">
    <p class="formfield">
    <label>Message:</label>
    <textarea type='textarea' id='msg' name='msg'></textarea>
    </p>
    <label>Staff Member:</label>
    <select name='msisdn' value='test' style='width: 200px;'>
    <option value="" disabled selected>Select Staff Ext</option>
        <?php
        $filepath = 'config.ini';
        $parsed_ini = parse_ini_file($filepath);
        $ip = ($parsed_ini['IP']);
        $user = ($parsed_ini['User']);
        $pass = ($parsed_ini['Pass']);

        $arrContextOptions=array(
            "ssl"=>array(
                "allow_self_signed"=> true,
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        ini_set("display_errors",1);
        error_reporting(E_ALL);
        $obj = file_get_contents('https://' . $user . ':' . $pass . '@' . $ip . '/api/subscriber', false, stream_context_create($arrContextOptions));
        $colm = (array_column(json_decode($obj), 'msisdn'));

        foreach($colm as $item){
                echo "<option id='val' name='val' value='$item'>$item</option>";
                echo "<br>";
            }
        ?>
    </select>
<br>
</br>
    <input type='image' name 'submit' src='images/hNfHB.png' alt='Submit' style='width: 200px;'></input>
</form>
<br></br>

  <div style="position: absolute; bottom: 10; left: 10; width: 1000px; text-align:left;">
            Message Server Rev 1.2
  </div>
</br>
 </body>
</html>

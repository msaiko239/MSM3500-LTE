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
</style>
</head>
<body>

<div class="topnav">
  <a class="active" href="#home">Home</a>
  <a href="config.php">Configure Interface</a>
  <a href="sendpage.php">Message Staff</a>
  <a href="status.php">Service Status</a>
  <a href="input.php">Log</a>
  <a href="service.php">Shell output</a>
</div>

<div style="padding-left:16px">
<img src="images/MSMWelcome.jpg">
</div>
<br>
</br>
<div>
<img src="images/int.png" class="img">
</div>

<a href="config.php">
<div class="box">
    <img src="images/config.png" class="padding">
    <span style="">Configure Interface</span>
</div>
</a>
<a href="sendpage.php">
<div class="box">
    <img src="images/send-message-icon.png" class="padding2">
    <span style="">Message Staff</span>
</div>
</a>
<a href="status.php">
<div class="box">
    <img src="images/srv.png" class="padding">
    <span style="">Service Status</span>
</div>
</a>
<a href="input.php">
<div class="box">
    <img src="images/log-file-format.svg" class="padding">
    <span style="">Log</span>
</div>
</a>
<a href="service.php">
<div class="box">
    <img src="images/srvoutput.png" class="padding">
    <span style="">Shell Output</span>
</div>
</a>
<br></br>

  <div style="position: absolute; bottom: 10; left: 10; width: 10000px; text-align:left;">
            Message Server Rev 1.2
  </div>
</br>
 </body>
</html>
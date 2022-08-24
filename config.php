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
height:60px;
padding: 2px 20px 2px 20px;
}
.padding
{
width:80px;
height:80px;
padding: 2px 20px 2px 20px;
}
.pads
{
  padding: 20px 20px 20px 20px;
}
.img
{
    float: right;
    background-color: #FFFFFF;
    width:580px;
    height:380px;
    padding: 2px 350px 2px 2px;
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
  <a class="active" href="config.php">Configure Interface</a>
  <a href="sendpage.php">Message Staff</a>
  <a href="status.php">Service Status</a>
  <a href="input.php">Log</a>
  <a href="service.php">Shell output</a>
</div>

<div class="banner">
<img src="images/Raemisip.jpg">
</div>
<div>
<img src="images/int.png" class="img">
</div>
<?php

//put the file path here
$filepath = 'config.ini';

//after the form submit

if($_POST){
	$data = $_POST;
	//update ini file, call function
	update_ini_file($data, $filepath);
}

//this is the function going to update your ini file
	function update_ini_file($data, $filepath) {
		$content = "";

		//parse the ini file to get the sections
		//parse the ini file using default parse_ini_file() PHP function
		$parsed_ini = parse_ini_file($filepath, true);

		foreach($data as $section=>$values){
			//append the section
			$content .= "[".$section."]\n";
			//append the values
			foreach($values as $key=>$value){
				$content .= $key."=".$value."\n";
			}
		}

		//write it into file
		if (!$handle = fopen($filepath, 'w')) {
			return false;
		}

		$success = fwrite($handle, $content);
		fclose($handle);

		return $success;
	}
?>
<?php

//parse the ini file using default parse_ini_file() PHP function
$parsed_ini = parse_ini_file($filepath, true);

?>
<div class="form">
<form action="" method="post" class="pads" id="my_form">
	<?php

	foreach($parsed_ini as $section=>$values){
		echo "<h3>$section</h3>";
		//keep the section as hidden text so we can update once the form submitted
		echo "<input type='hidden' value='$section' name='$section' />";
		//print all other values as input fields, so can edit.
		//note the name='' attribute it has both section and key
		foreach($values as $key=>$value){
			echo "<p>".$key.": <input type='text' name='{$section}[$key]' value='$value' />"."</p>";
		}
		echo "<br>";
	}

	?>
	<input type="submit" value="Update INI" onclick="alert('Configuration IP Changed')">
</form>
</div>

<br></br>

  <div style="position: absolute; bottom: 10; left: 10; width: 10000px; text-align:left;">
            Message Server Rev 1.2
  </div>
</br>
 </body>
</html>
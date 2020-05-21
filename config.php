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
<html>
 <head>
  <title>Message Server</title>
 </head>
<body>
<br>
 <?php echo '<img src="images/usbip.jpg"./'; ?> 
</br>
<br>
<?php 

//parse the ini file using default parse_ini_file() PHP function
$parsed_ini = parse_ini_file($filepath, true);

?>

<form action="" method="post">
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
	<input type="submit" value="Update INI" />
</form>
</br>
<br>
<a href="index.php">Home</a>
</br>
<br>
  <div style="position: absolute; bottom: 10; left: 10; width: 10000px; text-align:left;">
            Message Server Rev 1.0
  </div>
</br>

</body>
</html>

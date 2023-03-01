<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style_sheet.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  </head>
  <body>
    <aside>
      <p> Menu </p>
      <a href="index.php">
        <i class="fa fa-home" aria-hidden="true"></i>
        Home
      </a>
      <a href="sendpage.php">
        <i class="fa fa-envelope-o" aria-hidden="true"></i>
        Send Message
      </a>
      <a href="status.php">
        <i class="fa fa-check-square-o" aria-hidden="true"></i>
        Service Status
      </a>
      <a href="input.php">
        <i class="fa fa-file-text-o" aria-hidden="true"></i>
        View Log
      </a>
      <a href="service.php">
        <i class="fa fa-file" aria-hidden="true"></i>
        Service Output
      </a>
    </aside>
    <div style="margin-left:15%">
      <div class="w3-container" id="bgimage">
        <div style="padding-left:16px">
        <img src="images/Raemisip.jpg">
        </div>
        <br>
        </br>
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
        <div class="form">
          <form action="" method="post" class="pads" id="my_form">
	        <?php
                $filepath = 'config.ini';
                $parsed_ini = parse_ini_file($filepath, true);
	        foreach($parsed_ini as $section=>$values){
	                echo "<h3>$section</h3>";
	                //keep the section as hidden text so we can update once the form submitted
	                echo "<input type='hidden' value='$section' name='$section' />";
                        $parsed_ini2 = parse_ini_file($filepath);
                        $ip = ($parsed_ini2['IP']);
                        $user = ($parsed_ini2['User']);
                        $pass = ($parsed_ini2['Pass']);
                        echo "<p> IP      :    <input type='text' name='{$section}[IP]' value='$ip' />"."</p>";
                        echo "<p> User: <input type='text' name='{$section}[User]' value='$user' />"."</p>";
                        echo "<p> Pass: <input type='text' name='{$section}[Pass]' value='' /> Cannot use ?{}|&~![()^\" "."</p>";
	        }

	        ?>
	        <input type="submit" value="Update INI" onclick="alert('Configuration Updated')">
          </form>
        </div>
      </div>
    </div>
  </body>
</html>

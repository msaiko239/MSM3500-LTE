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
      <a href="index.html">
        <i class="fa fa-home" aria-hidden="true"></i>
        Home
      </a>
      <a href="config.php">
        <i class="fa fa-gear" aria-hidden="true"></i>
        Configure Interface
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
      <div class="base">
        <br></br>
        <div style="padding-left:16px">
          <img src="images/sendmsg.jpg">
        </div>
        <br></br>
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
    </div>
  </body>
</html>

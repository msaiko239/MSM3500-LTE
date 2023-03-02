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
      <a href="sendpage.php">
        <i class="fa fa-envelope-o" aria-hidden="true"></i>
        Send Message
      </a>
      <a href="status.php">
        <i class="fa fa-check-square-o" aria-hidden="true"></i>
        Service Status
      </a>
      <a href="service.php">
        <i class="fa fa-file" aria-hidden="true"></i>
        Service Output
      </a>
    </aside>
    <div class="div_log">
      <div style="padding-left:16px">
        <img src="images/commlog.jpg">
      </div>
      <br></br>
      <div>
        <?php
        $myfile = file_get_contents( "/var/log/axi.log" );
        echo "<pre>" . $myfile . "</pre>";
        ?>
      </div>
    </div>
  </body>
</html>

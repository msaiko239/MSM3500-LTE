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
      <img src="images/servstat.jpg">
    </div>
    <br></br>
    <div class="base">
      <div class="column">
        <br></br>
        <div class="center">
        <?php

        $output = shell_exec('systemctl status asterisk.service');
        $needle = "running";

        if (strpos($output, $needle) !==false) {
          echo '<h2 class="center2">Asterisk</h2>
                <div> <img class="center_img" src="images/green_light.png" />
                  <p class="center2">Asterisk is Running</p>
                  <p class="center2">Asterisk is used to process SIP messages</p>
                  <p class="center2"><a href="/restart.php">Click Here to Restart</a></p>
                  <p class="center2"><a href="/stop.php">Click Here to Stop</a></p>
                  <p class="center2"><a href="/reboot.php">Click Here to Reboot</a></p></div>';
        } else {
          echo '<h2 class="center2">Asterisk</h2>
                <div> <a href="/start.php" /><img class="center_img" src="images/red_light.png"/>
                  <p class="center2"><a href="/start.php">Asterisk is Stopped Click to Start</a></p>
                  <p class="center2"><a href="/reboot.php">Click Here to Reboot</a></p></div>';
        }
        ?>
        </div>
      </div>
      <div class="column">
        <br></br>
        <div class="center">
        <?php

        $output = shell_exec('systemctl status axi.service');
        $needle = "running";

        if (strpos($output, $needle) !==false) {
          echo '<h2 class="center2">AXI Service</h2>
                <div> <img class="center_img" src="images/green_light.png" />
                  <p class="center2">The AXI Service is Running</p>
                  <p class="center2">The AXI service is used to process the messages and send them to Raemis</p>
                  <p class="center2"><a href="/restart_axi.php">Click Here to Restart</a></p>
                  <p class="center2"><a href="/stop_axi.php">Click Here to Stop</a></p>
                  <p class="center2"><a href="/reboot.php">Click Here to Reboot</a></p></div>';
        } else {
          echo '<h2 class="center2">AXI Service</h2>
                <div> <a href="/start.php" /><img class="center_img" src="images/red_light.png"/>
                  <p class="center2"><a href="/start_axi.php">The AXI Service is Stopped Click to Start</a></p>
                  <p class="center2"><a href="/reboot.php">Click Here to Reboot</a></p></div>';
        }
        ?>
        </div>
      </div>
      <div class="column">
      <br></br>
        <div class="center">
        <?php

        $output = shell_exec('systemctl status rabbitmq-server.service');
        $needle = "running";

        if (strpos($output, $needle) !==false) {
          echo '<h2 class="center2">Message Queing</h2>
                <div> <img class="center_img" src="images/green_light.png" />
                  <p class="center2">The Message Queing Server is Running</p>
                  <p class="center2">Message Queing is used to communicate between processes</p>
                  <p class="center2"><a href="/restart_mq.php">Click Here to Restart</a></p>
                  <p class="center2"><a href="/stop_mq.php">Click Here to Stop</a></p>
                  <p class="center2"><a href="/reboot.php">Click Here to Reboot</a></p></div>';
        } else {
          echo '<h2 class="center2">Message Queing</h2>
                <div> <a href="/start.php" /><img class="center_img" src="images/red_light.png"/>
                  <p class="center2"><a href="/start_mq.php">The Message Queing Server is Stopped Click to Start</a></p>
                  <p class="center2"><a href="/reboot.php">Click Here to Reboot</a></p></div>';
        }
        ?>
        </div>
      </div>
    </div>
  </body>
</html>

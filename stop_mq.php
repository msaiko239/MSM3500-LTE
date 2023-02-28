<?php
shell_exec('sudo systemctl stop rabbitmq-server.service');
header("Location: /status.php");
?>

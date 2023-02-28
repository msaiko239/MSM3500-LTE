<?php
shell_exec('sudo systemctl restart rabbitmq-server.service');
header("Location: /status.php");
?>

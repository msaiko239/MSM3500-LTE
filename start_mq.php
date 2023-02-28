<?php
shell_exec('sudo systemctl start rabbitmq-server.service');
header("Location: /status.php");
?>

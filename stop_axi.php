<?php
shell_exec('sudo systemctl stop axi.service');
header("Location: /status.php");
?>

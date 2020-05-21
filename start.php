<?php
shell_exec('sudo systemctl start asterisk.service');
header("Location: /status.php");
?>

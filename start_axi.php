<?php
shell_exec('sudo systemctl start axi.service');
header("Location: /status.php");
?>

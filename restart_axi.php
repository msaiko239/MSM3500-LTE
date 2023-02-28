<?php
shell_exec('sudo systemctl restart axi.service');
header("Location: /status.php");
?>

<?php
shell_exec('sudo systemctl stop asterisk.service');
header("Location: /status.php");
?>
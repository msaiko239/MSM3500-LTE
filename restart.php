<?php
shell_exec('sudo systemctl restart asterisk.service');
header("Location: /status.php");
?>

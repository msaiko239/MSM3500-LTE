<html>
 <head>
  <title>Message Server</title>
 </head>
<body>
<br>
 <?php echo '<img src="images/commlog.jpg"./'; ?> 
</br>
<?php

$row = 1;
if (($handle = fopen("/var/log/axi/input.csv", "r")) !== FALSE) {
    
    echo '<table border="1">';
    
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        if ($row == 1) {
            echo '<thead><tr>';
        }else{
            echo '<tr>';
        }
        
        for ($c=0; $c < $num; $c++) {
            //echo $data[$c] . "<br />\n";
            if(empty($data[$c])) {
               $value = "&nbsp;";
            }else{
               $value = $data[$c];
            }
            if ($row == 1) {
                echo '<th>'.$value.'</th>';
            }else{
                echo '<td>'.$value.'</td>';
            }
        }
        
        if ($row == 1) {
            echo '</tr></thead><tbody>';
        }else{
            echo '</tr>';
        }
        $row++;
    }
    
    echo '</tbody></table>';
    fclose($handle);
}
?>
<br>
<a href="index.php">Home</a>
</br>
<br>
 Message Server Rev 1.1
</br>
</body>
</html>

<?php
$con=mysql_connect("192.186.222.198","kisansanchar","lL5071300") or die("Failed to connect to MySQL: " . mysqli_connect_error());
// Check connection

mysql_select_db ("kisansanchar_dev") or die ("not connected");

$result = mysql_query("SELECT id,name FROM india where name like '%(%' limit 0,50000");
while($row = mysql_fetch_assoc($result)) {
  $rowarray[] = $row;
}
echo "<pre>";print_r( $rowarray);echo '</pre>';
?>
<?php
$file = fopen("server", "w");
fwrite($file, '');
fclose($file);
echo "<meta http-equiv='refresh' content='0;url=?page'>";
exit;
?>
<?php
$te_time = "";
$te_formated_time = "";
$te_id = $entry->getId();
	
$spojeni = mysqli_connect(DBHOST, DBUSER, DBPASS, "cis_extra"); // Konstanty převzaty ze souboru \include\ost-config.php

$get_teid = mysqli_query($spojeni, "SELECT * from cis_times WHERE `thread_entry_id` = $te_id");
while ($zaznam = mysqli_fetch_array ($get_teid)) {$te_time = $zaznam["time"];}

if (is_numeric($te_time)) {$te_formated_time = ", ".__('Time spent')." ".date('H:i', mktime(0,$te_time));}
?>
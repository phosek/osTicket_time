<?php
if (isset($_POST['time_spent']))
{
	$spojeni = mysqli_connect(DBHOST, DBUSER, DBPASS, "cis_extra"); // Konstanty převzaty ze souboru \include\ost-config.php
	$spojeni_ost = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

	//Načtem thread_entry_id z databáze - najdeme ho podle thread_id a response
	$te_table = TABLE_PREFIX."thread_entry";
	$te_tid   = $ticket->getThread()->getId();
	$get_teid = mysqli_query($spojeni_ost, "SELECT * from $te_table WHERE `thread_id` = $te_tid AND `body` = '$te_response'");
	while ($zaznam = mysqli_fetch_array ($get_teid)) {$te_id = $zaznam["id"];}

	if (isset($te_id))
	{
		$te_time = $_POST['time_spent'];
		$te_staff_id = $thisstaff->getId();
		$te_date = date('Y-m-d H:i:s');

		mysqli_query($spojeni, "INSERT INTO `cis_times` SET `thread_entry_id` = \"$te_id\", 
																	   `time` = \"$te_time\", 
																   `staff_id` = \"$te_staff_id\", 
																	   `body` = \"$te_response\", 
																	`created` = \"$te_date\"");
	}
}
?>
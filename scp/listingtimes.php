<?php
require('staff.inc.php');
$nav->setTabActive('dashboard');
require(STAFFINC_DIR.'header.inc.php');

$times_date_from = date('Y-m-01'). " 00:00:00";
$times_date_to = date('Y-m-t'). " 23:59:59";
$times_staff_id = $thisstaff->getid();
$times_dept_id = $thisstaff->getDeptId();

if (isset($_GET['times_staff_id'])) {$times_staff_id = $_GET['times_staff_id'];}
if (isset($_GET['times_date_from'])) {$times_date_from = $_GET['times_date_from'];}
if (isset($_GET['times_date_to'])) {$times_date_to = $_GET['times_date_to'];} 

$spojeni = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); // Konstanty převzaty ze souboru \include\ost-config.php
$times_staffs = mysqli_query($spojeni, "SELECT * FROM ost_staff WHERE `dept_id` = $times_dept_id"); ?>

		<form method="GET" action="">
			<table class="list" border="0" cellspacing="1" cellpadding="0" width="940" style="table-layout: fixed">
				<thead>
					<tr>
						<th width="200"><?php echo __('From date');?></th>
						<th width="200"><?php echo __('To date');?></th>
						<th><?php echo __('Staff name');?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="text" name="times_date_from" value="<?php echo $times_date_from;?>">
						</td>
						<td>
							<input type="text" name="times_date_to" value="<?php echo $times_date_to;?>">
						</td>
						<td>
							<select name="times_staff_id"> <?php
								while($zaznam_name = mysqli_fetch_array($times_staffs))
									{ ?>
										<option value="<?php echo $zaznam_name["staff_id"];?>" <?php if ($zaznam_name["staff_id"]==$times_staff_id) {echo "selected";} ?>>
											<?php echo $zaznam_name["firstname"]." ".$zaznam_name["lastname"];?>
										</option> <?php
									} ?>
							</select>
							<button class="action-button" name="submit" type="submit" style="margin-left: 50px;" value=""><?php echo __('Use');?></button>
						</td>
					<tr>
				</tbody>
			</table>
		</form> 
		<br><br> <?php

$spojeni = mysqli_connect(DBHOST, DBUSER, DBPASS, "cis_extra"); // Konstanty převzaty ze souboru \include\ost-config.php
$data=mysqli_query($spojeni, "SELECT * from `cis_times` WHERE `staff_id` = '$times_staff_id' AND `time` > 0 AND `created` > '$times_date_from' AND `created` < '$times_date_to';");
$times_sum = 0;
?>

<table class="list" border="0" cellspacing="1" cellpadding="0" width="940" style="table-layout: fixed">
    <thead>
        <tr>
            <th width="70"><?php echo __('Ticket');?></th>
            <th><?php echo __('Description');?></th>
            <th width="150"><?php echo __('Created');?></th>
            <th width="40"><?php echo __('Time');?></th>
        </tr>
    </thead>
    <tbody> <?php
		while($zaznam=mysqli_fetch_array($data)) 
   		{
			$times_body = $zaznam["body"];
			$times_time = $zaznam["time"];
			$times_created = $zaznam["created"];
			$times_thread_entry_id = $zaznam["thread_entry_id"];
			$times_sum = $times_sum + $times_time;?>
			
			<tr>
				<td><?php echo $times_thread_entry_id;?></td>
				<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $times_body;?></td>
				<td><?php echo $times_created;?></td>
				<td><?php echo $times_time;?></td>
			</tr> <?php
		}?>
			<tr>
				<td colspan=3><?php echo __('Total');?></td>
				<td><?php echo $times_sum;?></td>
			</tr>
     </tbody>
</table>


<?php
include(STAFFINC_DIR.'footer.inc.php');
?>

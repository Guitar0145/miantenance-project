<?php
	date_default_timezone_set("Asia/Bangkok");
	$date_start = '2022-11-12 09:50:47';
	$date_stop = '2022-11-15 09:19:52';
	$diff = strtotime($date_stop) - strtotime($date_start);
						
	$fullHours   = floor($diff/(60*60));
	$fullMinutes = floor(($diff-($fullHours*60*60))/60);
	$fullSeconds = floor($diff-($fullHours*60*60)-($fullMinutes*60));
	$sum += $diff;

	echo '<span>' . $fullHours . '</span>&nbsp;ชม.';
	echo '<span>' . $fullMinutes . '</span>&nbsp;นาที';
	echo '<p>คำนวณเป็นวินาที &nbsp;' . $diff . '</p>&nbsp;';

	
?>

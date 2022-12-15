<?php

     $datetime_start = "2022-11-12 09:50:47";
     $datetime_end = "2022-11-15 09:19:52";
     $seconds = strtotime($datetime_end) - strtotime($datetime_start);

     $days    = floor($seconds / 86400);
     $hours   = floor(($seconds - ($days * 86400)) / 3600);
     $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
     $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

?>
<b>ผลต่าง :</b> <?php echo $days." วัน ".$hours." ชั่วโมง ".$minutes." นาที ".$seconds." วินาที"; ?>
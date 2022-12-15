<?php
                                                $st_name = $listall['st_name'];
                                                $st_name_red= '<div style="color:red; font-weight: bold;">เสีย</div>';
                                                $st_name_red2= '<div style="color:red; font-weight: bold;">ซ่อม</div>';
                                                $st_name_orenge = '<div class="" style="color:#FF8C00; font-weight: bold;">ปรับปรุง</div>';
                                                $st_name_blue = '<div class="" style="color:blue; font-weight: bold;">ติดตั้ง-เดิน</div>';
                                                $st_name_gray = '<div class="" style="color:gray; font-weight: bold;">อื่นๆ</div>';

                                                if ($st_name == 'เสีย') {
                                                    echo $st_name_red;
                                                } else if ($st_name == 'ซ่อม') {
                                                    echo $st_name_red2;        
                                                } else if ($st_name == 'ปรับปรุง') {
                                                    echo $st_name_orenge; 
                                                } else if ($st_name == 'ติดตั้ง-เดิน') {
                                                    echo $st_name_blue;       
                                                } else {
                                                    echo $st_name_gray;    
                                                }
                                            ?>
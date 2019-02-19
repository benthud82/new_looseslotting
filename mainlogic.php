<?php
include_once '../globalincludes/google_connect.php';

//pull in available location volume
$usevol_sql = $conn1->prepare("SELECT 
                                slotmaster_tier,
                                SUM(slotmaster_usecube) AS avail_cube,
                                SUM(slotmaster_usecube) * .85 as cap_85
                            FROM
                                gillingham.slotmaster
                            GROUP BY slotmaster_tier");  
$usevol_sql->execute();
$usevol_array = $usevol_sql->fetchAll(pdo::FETCH_ASSOC);


//pull in available location sizes
//beginning with L02
$avail_loc_sql = $conn1->prepare("SELECT DISTINCT
                                    slotmaster_dimgroup,
                                    slotmaster_usedeep,
                                    slotmaster_usehigh,
                                    slotmaster_usewide,
                                    slotmaster_usecube
                                FROM
                                    gillingham.slotmaster
                                WHERE
                                slotmaster_tier = 'L02'
                                ORDER BY slotmaster_usecube");  
$avail_loc_sql->execute();
$avail_loc_array = $avail_loc_sql->fetchAll(pdo::FETCH_ASSOC);

//Pull in all standard items and start with the smallest location they can fit into

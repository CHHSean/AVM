<?php
include('../DB.php');
// include('../controller/indirect_human_cost_controller.php');

global $conn;

foreach ($_REQUEST as $key => $val) {
    $$key = $val;
};

$Year = date('Y') - 1911;
$Month = date('n');

$date = new DateTime();


//取工序
function get_work_num($Process_ID)
{
    global $conn;
    $sql_work_num = "SELECT `property_num`, `capacity_num`
                    FROM `work_attribute`
                    WHERE `work_num` = '" . $Process_ID . "';";
    // echo $sql_work_num;
    $row = $conn->query($sql_work_num);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

//取產品成本
function get_product_num($Material_Part_No, $year, $month)
{
    global $conn;
    $sql_product_num = "SELECT p.`Row_id`,`pd_create_year`,`pd_create_month`,`product_num`,`product_name`,SUM(`mt_cost`*`material_useage`) as total_cost 
                    FROM `product`as p , material as m
                    WHERE p.`material_num` = m.`mt_num` 
                        AND `product_num` = '" . $Material_Part_No . "'  
                        AND `pd_create_year` = $year 
                        AND `pd_create_month` = $month 
                        AND `mt_create_year` = $year 
                        AND `mt_create_month` = $month 
                    GROUP BY `product_num`;";
    // echo $sql_product_num;
    $row = $conn->query($sql_product_num);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

//取人事成本
function get_human_resource_cost($Staff_ID, $year, $month)
{
    global $conn;
    $sql_human_resource_cost = "SELECT * FROM human_resource_cost 
                                WHERE em_year = $year AND em_month = $month AND em_id = '" . $Staff_ID . "';";
    // echo $sql_human_resource_cost;
    $row = $conn->query($sql_human_resource_cost);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

//取機器成本
function get_machine_cost($Machine_ID, $year, $month)
{
    global $conn;
    $sql_machine_cost = "SELECT * FROM machine_cost 
                         WHERE mc_start_year = $year  
                            AND mc_start_month = $month  
                            AND mc_id = '" . $Machine_ID . "';";
    // echo $sql_machine_cost;
    $row = $conn->query($sql_machine_cost);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

//計算工單平均成本
function average_work_order_cost_controller($wo_year, $wo_month)
{
    global $conn;

    $sql_c = "SELECT SUM(`em_total_expense`) as sum_em_total_expense
            FROM `indirect_human_cost`
            WHERE `em_status` = 1 AND `em_year` = $wo_year AND `em_month` = $wo_month;";
    // echo $sql_c;
    $row_c = $conn->query($sql_c);
    $result_c = $row_c->fetchAll(PDO::FETCH_ASSOC);
    // print_r($result_c);

    $sql_n = "SELECT `wo_num` 
            FROM `work_order` 
            WHERE `wo_year` = $wo_year AND `wo_month` = $wo_month;";
    // echo $sql_n;
    $row_n = $conn->query($sql_n);
    $result_n = $row_n->fetchAll(PDO::FETCH_ASSOC);
    // print_r($result_n);

    $average_cost = $result_c[0]['sum_em_total_expense'] / $result_n[0]['wo_num'];
    // echo( $result_c[0]['sum_em_total_expense'] / $result_n[0]['wo_num']);

    return $average_cost;
}

//產能屬性成本分析表
function sel_production_data()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;

        if ($year >= $start_year && $year <= $end_year && $month >= $start_month && $month <= $end_month) {

            //取工序
            $work_num = get_work_num($real_data[0]['Data'][$a]['Process_ID']);
            // print_r($work_num);

            $property_num = intval($work_num[0]['property_num']);
            $capacity_num = intval($work_num[0]['capacity_num']);

            $sql_property_name = "SELECT a.`type_name` as property_name, c.`type_name` as capacity_name
                            FROM `work_attribute` as b 
                            LEFT JOIN `attri_name` as a on a.`type_id` = $property_num
                            LEFT JOIN `attri_name` as c on c.`type_id` = $capacity_num
                            WHERE `work_num` =  '" . $real_data[0]['Data'][$a]['Process_ID'] . "';";
            // echo $sql_property_name;

            $row = $conn->query($sql_property_name);
            $result_p = $row->fetchAll(PDO::FETCH_ASSOC);
            // print_r($result_p);

            //取人事成本
            $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['Staff_ID'], $year, $month);
            // print_r($human_resource_cost);

            //取機器成本
            $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['Machine_ID'], $year, $month);
            // print_r($machine_cost);



            $tmp = array(
                //日期
                "Date" => $real_data[0]['Data'][$a]['Date'],
                //工序名稱
                "Process_ID" => $result_p[0]['property_name'],
                //機器成本
                "Machine_cost" => $machine_cost,
                //人事成本
                "Human_cost" => $human_resource_cost,
                //原因
                "Reason" => $real_data[0]['Data'][$a]['Reason'],
            );
            array_push($arr, $tmp);
        }
    }
    $len_arr = count($arr);

    $mac_cap_cost = 0;
    $mac_non_cost = 0;
    $mac_indirect_cost = 0;
    $mac_idle_cost = 0;
    $arr_pro_mac = array();
    for ($i = 0; $i < $len_arr; $i++) {
        if ($arr[$i]['Process_ID'] == "有生產力作業") {
            $mac_cap_cost += $arr[$i]['Machine_cost'];
            // echo $arr[$i]['cost'];
        } else if ($arr[$i]['Process_ID'] == "無生產力作業") {
            $mac_non_cost += $arr[$i]['Machine_cost'];
        } else if ($arr[$i]['Process_ID'] == "間接生產力作業") {
            $mac_indirect_cost += $arr[$i]['Machine_cost'];
        } else if ($arr[$i]['Process_ID'] == "閒置產能作業") {
            $mac_idle_cost += $arr[$i]['Machine_cost'];
        }
    }
    $mac_total = $mac_cap_cost +  $mac_non_cost + $mac_indirect_cost + $mac_idle_cost;
    $tmp_mac = array(
        "project" => "機台",
        "cap_cost" =>  $mac_cap_cost,
        "cap_per" => round($mac_cap_cost / $mac_total) * 100,
        "non_cost" =>  $mac_non_cost,
        "non_per" => round($mac_non_cost / $mac_total) * 100,
        "indirect_cost" =>  $mac_indirect_cost,
        "indirect_per" => round($mac_indirect_cost / $mac_total) * 100,
        "ind_reason" => "",
        "idle_cost" =>  $mac_idle_cost,
        "idle_per" => round($mac_idle_cost / $mac_total) * 100,
        "id_reason" => "",

    );

    array_push($arr_pro_mac, $tmp_mac);

    $hum_cap_cost = 0;
    $hum_non_cost = 0;
    $hum_indirect_cost = 0;
    $hum_idle_cost = 0;
    $arr_pro_hum = array();
    for ($i = 0; $i < $len_arr; $i++) {
        if ($arr[$i]['Process_ID'] == "有生產力作業") {
            $hum_cap_cost += $arr[$i]['Human_cost'];
            // echo $arr[$i]['cost'];
        } else if ($arr[$i]['Process_ID'] == "無生產力作業") {
            $hum_non_cost += $arr[$i]['Human_cost'];
        } else if ($arr[$i]['Process_ID'] == "間接生產力作業") {
            $hum_indirect_cost += $arr[$i]['Human_cost'];
        } else if ($arr[$i]['Process_ID'] == "閒置產能作業") {
            $hum_idle_cost += $arr[$i]['Human_cost'];
        }
    }
    $hum_total = $hum_cap_cost +  $hum_non_cost + $hum_indirect_cost + $hum_idle_cost;
    $tmp_hum = array(
        "project" => "機台",
        "cap_cost" =>  $hum_cap_cost,
        "cap_per" => round($hum_cap_cost / $hum_total) * 100,
        "non_cost" =>  $hum_non_cost,
        "non_per" => round($hum_non_cost / $hum_total) * 100,
        "indirect_cost" =>  $hum_indirect_cost,
        "indirect_per" => round($hum_indirect_cost / $hum_total) * 100,
        "ind_reason" => "",
        "idle_cost" =>  $hum_idle_cost,
        "idle_per" => round($hum_idle_cost / $hum_total) * 100,
        "id_reason" => "",
    );

    array_push($arr_pro_hum, $tmp_hum);

    $cap_cost = $mac_cap_cost + $hum_cap_cost;
    $non_cost = $mac_non_cost + $hum_non_cost;
    $indirect_cost = $mac_indirect_cost + $hum_indirect_cost;
    $idle_cost = $mac_idle_cost + $hum_idle_cost;
    $total_cost = $mac_total + $hum_total;
    $arr_pro_total = array();
    $tmp_total = array(
        "project" => "機台",
        "cap_cost" =>  $cap_cost,
        "cap_per" => round($hum_cap_cost / $total_cost) * 100,
        "non_cost" =>  $non_cost,
        "non_per" => round($hum_non_cost / $total_cost) * 100,
        "indirect_cost" =>  $indirect_cost,
        "indirect_per" => round($hum_indirect_cost / $total_cost) * 100,
        "ind_reason" => "",
        "idle_cost" =>  $idle_cost,
        "idle_per" => round($hum_idle_cost / $total_cost) * 100,
        "id_reason" => "",

    );

    array_push($arr_pro_total, $tmp_total);

    $arr_fin = array($arr_pro_mac, $arr_pro_hum, $arr_pro_total);


    echo json_encode($arr_fin);
}

//工單產能屬性成本分析表
function sel_work_production_data()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();


    for ($a = 0; $a < $len; $a++) {
        $cap_cost = 0;
        $non_cost = 0;
        $indirect_cost = 0;
        $idle_cost = 0;
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;
        if ($year >= $start_year && $year <= $end_year && $month >= $start_month && $month <= $end_month) {
            //取工序
            $work_num = get_work_num($real_data[0]['Data'][$a]['Process_ID']);
            // print_r($work_num);

            $property_num = intval($work_num[0]['property_num']);
            $capacity_num = intval($work_num[0]['capacity_num']);

            $sql_property_name = "SELECT a.`type_name` as property_name, c.`type_name` as capacity_name
                            FROM `work_attribute` as b 
                            LEFT JOIN `attri_name` as a on a.`type_id` = $property_num
                            LEFT JOIN `attri_name` as c on c.`type_id` = $capacity_num
                            WHERE `work_num` =  '" . $real_data[0]['Data'][$a]['Process_ID'] . "';";
            // echo $sql_property_name;

            $row = $conn->query($sql_property_name);
            $result_p = $row->fetchAll(PDO::FETCH_ASSOC);
            // print_r($result_p);

            //取人事成本
            $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['Staff_ID'], $year, $month);
            // print_r($human_resource_cost);

            //取機器成本
            $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['Machine_ID'], $year, $month);
            // print_r($machine_cost);

            //間接成本
            $average_work_order_cost = average_work_order_cost_controller($year, $month);
            // print_r($average_work_order_cost);

            if ($result_p[0]['property_name'] == "有生產力作業") {

                $cap_cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                    + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                    + $average_work_order_cost);

                $total_cost = $cap_cost + $non_cost + $indirect_cost + $idle_cost;

                $tmp = array(
                    //日期
                    "Date" => $real_data[0]['Data'][$a]['Date'],
                    //工單號
                    "Work_Ticked_No" => $real_data[0]['Data'][$a]["Work_Ticked_No"],
                    //有生產力作業
                    "cap_cost" =>  $cap_cost,
                    "cap_per" => round($cap_cost / $total_cost) * 100,
                    //無生產力作業
                    "non_cost" =>  $non_cost,
                    "non_per" => round($non_cost / $total_cost) * 100,
                    // 間接生產力作業
                    "indirect_cost" =>  $indirect_cost,
                    "indirect_per" => round($indirect_cost / $total_cost) * 100,
                    "ind_Reason" => "",
                    // 閒置產能作業
                    "idle_cost" =>  $idle_cost,
                    "idle_per" => round($idle_cost / $total_cost) * 100,
                    "id_Reason" => "",
                );
            } elseif ($result_p[0]['property_name'] == "無生產力作業") {
                $non_cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                    + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                    + $average_work_order_cost);

                $total_cost = $cap_cost + $non_cost + $indirect_cost + $idle_cost;

                $tmp = array(
                    //日期
                    "Date" => $real_data[0]['Data'][$a]['Date'],
                    //工單號
                    "Work_Ticked_No" => $real_data[0]['Data'][$a]["Work_Ticked_No"],
                    //有生產力作業
                    "cap_cost" =>  $cap_cost,
                    "cap_per" => round($cap_cost / $total_cost) * 100,
                    //無生產力作業
                    "non_cost" =>  $non_cost,
                    "non_per" => round($non_cost / $total_cost) * 100,
                    // 間接生產力作業
                    "indirect_cost" =>  $indirect_cost,
                    "indirect_per" => round($indirect_cost / $total_cost) * 100,
                    "ind_Reason" => "",
                    // 閒置產能作業
                    "idle_cost" =>  $idle_cost,
                    "idle_per" => round($idle_cost / $total_cost) * 100,
                    "id_Reason" => "",
                );
            } elseif ($result_p[0]['property_name'] == "間接生產力作業") {
                $indirect_cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                    + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                    + $average_work_order_cost);

                $total_cost = $cap_cost + $non_cost + $indirect_cost + $idle_cost;

                $tmp = array(
                    //日期
                    "Date" => $real_data[0]['Data'][$a]['Date'],
                    //工單號
                    "Work_Ticked_No" => $real_data[0]['Data'][$a]["Work_Ticked_No"],
                    //有生產力作業
                    "cap_cost" =>  $cap_cost,
                    "cap_per" => round($cap_cost / $total_cost) * 100,
                    //無生產力作業
                    "non_cost" =>  $non_cost,
                    "non_per" => round($non_cost / $total_cost) * 100,
                    // 間接生產力作業
                    "indirect_cost" =>  $indirect_cost,
                    "indirect_per" => round($indirect_cost / $total_cost) * 100,
                    "ind_Reason" => $real_data[0]['Data'][$a]['Reason'],
                    // 閒置產能作業
                    "idle_cost" =>  $idle_cost,
                    "idle_per" => round($idle_cost / $total_cost) * 100,
                    "id_Reason" => "",
                );
            } elseif ($result_p[0]['property_name'] == "閒置產能作業") {
                $idle_cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                    + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                    + $average_work_order_cost);

                $total_cost = $cap_cost + $non_cost + $indirect_cost + $idle_cost;

                $tmp = array(
                    //日期
                    "Date" => $real_data[0]['Data'][$a]['Date'],
                    //工單號
                    "Work_Ticked_No" => $real_data[0]['Data'][$a]["Work_Ticked_No"],
                    //有生產力作業
                    "cap_cost" =>  $cap_cost,
                    "cap_per" => round($cap_cost / $total_cost) * 100,
                    //無生產力作業
                    "non_cost" =>  $non_cost,
                    "non_per" => round($non_cost / $total_cost) * 100,
                    // 間接生產力作業
                    "indirect_cost" =>  $indirect_cost,
                    "indirect_per" => round($indirect_cost / $total_cost) * 100,
                    "ind_Reason" => "",
                    // 閒置產能作業
                    "idle_cost" =>  $idle_cost,
                    "idle_per" => round($idle_cost / $total_cost) * 100,
                    "id_Reason" => $real_data[0]['Data'][$a]['Reason'],
                );
            }
            array_push($arr, $tmp);
        }
    }
    $len_arr = count($arr);


    $tot_cap_cost = 0;
    $tot_non_cost = 0;
    $tot_indirect_cost = 0;
    $tot_idle_cost = 0;
    $arr_tot = array();
    for ($i = 0; $i < $len_arr; $i++) {
        $tot_cap_cost += $arr[$i]['cap_cost'];
        $tot_non_cost += $arr[$i]['non_cost'];
        $tot_indirect_cost += $arr[$i]['indirect_cost'];
        $tot_idle_cost += $arr[$i]['idle_cost'];
    }
    $total = $tot_cap_cost + $tot_non_cost + $tot_indirect_cost + $tot_idle_cost;
    $tmp_tot = array(
        //日期
        "Date" => $real_data[0]['Data'][$a]['Date'],
        //總成本
        "Work_Ticked_No" => "總成本",
        //有生產力作業
        "cap_cost" =>  $tot_cap_cost,
        "cap_per" => round($tot_cap_cost / $total) * 100,
        //無生產力作業
        "non_cost" =>  $tot_non_cost,
        "non_per" => round($tot_non_cost / $total) * 100,
        // 間接生產力作業
        "indirect_cost" =>  $tot_indirect_cost,
        "indirect_per" => round($tot_indirect_cost / $total) * 100,
        "ind_Reason" => "",
        // 閒置產能作業
        "idle_cost" =>  $tot_idle_cost,
        "idle_per" => round($tot_idle_cost / $total) * 100,
        "id_Reason" => "",
    );

    array_push($arr_tot, $tmp_tot);

    $arr_fin = array($arr, $arr_tot);

    echo json_encode($arr_fin);
}




$OpType();

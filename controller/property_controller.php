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

//品質屬性成本分析表
function sel_property_data()
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

    $mac_prevent_cost = 0;
    $mac_identi_cost = 0;
    $mac_external_cost = 0;
    $mac_internal_cost = 0;
    $arr_pro_mac = array();
    for ($i = 0; $i < $len_arr; $i++) {
        if ($arr[$i]['Process_ID'] == "預防作業") {
            $mac_prevent_cost += $arr[$i]['Machine_cost'];
            // echo $arr[$i]['cost'];
        } else if ($arr[$i]['Process_ID'] == "鑑定作業") {
            $mac_identi_cost += $arr[$i]['Machine_cost'];
        } else if ($arr[$i]['Process_ID'] == "外部失敗作業") {
            $mac_external_cost += $arr[$i]['Machine_cost'];
        } else if ($arr[$i]['Process_ID'] == "內部失敗作業") {
            $mac_internal_cost += $arr[$i]['Machine_cost'];
        }
    }
    $mac_total = $mac_prevent_cost +  $mac_identi_cost + $mac_external_cost + $mac_internal_cost;
    $tmp_mac = array(
        "project" => "機台",
        "prevent_cost" =>  $mac_prevent_cost,
        "prevent_per" => round($mac_prevent_cost / $mac_total) * 100,
        "identi_cost" =>  $mac_identi_cost,
        "identi_per" => round($mac_identi_cost / $mac_total) * 100,
        "external_cost" =>  $mac_external_cost,
        "external_per" => round($mac_external_cost / $mac_total) * 100,
        "ex_reason" => "",
        "internal_cost" =>  $mac_internal_cost,
        "internal_per" => round($mac_internal_cost / $mac_total) * 100,
        "in_reason" => "",

    );

    array_push($arr_pro_mac, $tmp_mac);

    $hum_prevent_cost = 0;
    $hum_identi_cost = 0;
    $hum_external_cost = 0;
    $hum_internal_cost = 0;
    $arr_pro_hum = array();
    for ($i = 0; $i < $len_arr; $i++) {
        if ($arr[$i]['Process_ID'] == "預防作業") {
            $hum_prevent_cost += $arr[$i]['Human_cost'];
            // echo $arr[$i]['cost'];
        } else if ($arr[$i]['Process_ID'] == "鑑定作業") {
            $hum_identi_cost += $arr[$i]['Human_cost'];
        } else if ($arr[$i]['Process_ID'] == "外部失敗作業") {
            $hum_external_cost += $arr[$i]['Human_cost'];
        } else if ($arr[$i]['Process_ID'] == "內部失敗作業") {
            $hum_internal_cost += $arr[$i]['Human_cost'];
        }
    }
    $hum_total = $hum_prevent_cost +  $hum_identi_cost + $hum_external_cost + $hum_internal_cost;
    $tmp_hum = array(
        "project" => "人工",
        "prevent_cost" =>  $hum_prevent_cost,
        "prevent_per" => round($hum_prevent_cost / $hum_total) * 100,
        "identi_cost" =>  $hum_identi_cost,
        "identi_per" => round($hum_identi_cost / $hum_total) * 100,
        "external_cost" =>  $hum_external_cost,
        "external_per" => round($hum_external_cost / $hum_total) * 100,
        "ex_reason" => "",
        "internal_cost" =>  $hum_internal_cost,
        "internal_per" => round($hum_internal_cost / $hum_total) * 100,
        "in_reason" => "",
    );

    array_push($arr_pro_hum, $tmp_hum);

    $prevent_cost = $mac_prevent_cost + $hum_prevent_cost;
    $identi_cost = $mac_identi_cost + $hum_identi_cost;
    $external_cost = $mac_external_cost + $hum_external_cost;
    $internal_cost = $mac_internal_cost + $hum_internal_cost;
    $total_cost = $mac_total + $hum_total;
    $arr_pro_total = array();
    $tmp_total = array(
        "project" => "總成本",
        "prevent_cost" =>  $prevent_cost,
        "prevent_per" => round($prevent_cost / $total_cost) * 100,
        "identi_cost" =>  $identi_cost,
        "identi_per" => round($identi_cost / $total_cost) * 100,
        "external_cost" =>  $external_cost,
        "external_per" => round($external_cost / $total_cost) * 100,
        "ex_reason" => "",
        "internal_cost" =>  $internal_cost,
        "internal_per" => round($internal_cost / $total_cost) * 100,
        "in_reason" => "",

    );

    array_push($arr_pro_total, $tmp_total);

    $arr_fin = array($arr_pro_mac, $arr_pro_hum, $arr_pro_total);


    echo json_encode($arr_fin);
}

//工單品質屬性成本分析表
function sel_work_property_data()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();


    for ($a = 0; $a < $len; $a++) {
        $prevent_cost = 0;
        $identi_cost = 0;
        $external_cost = 0;
        $internal_cost = 0;
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

            if ($result_p[0]['property_name'] == "預防作業") {

                $prevent_cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                    + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                    + $average_work_order_cost);

                $total_cost = $prevent_cost + $identi_cost + $external_cost + $internal_cost;

                $tmp = array(
                    //日期
                    "Date" => $real_data[0]['Data'][$a]['Date'],
                    //工單號
                    "Work_Ticked_No" => $real_data[0]['Data'][$a]["Work_Ticked_No"],
                    //預防作業成本
                    "prevent_cost" =>  $prevent_cost,
                    "prevent_per" => round($prevent_cost / $total_cost) * 100,
                    //鑑定作業成本
                    "identi_cost" =>  $identi_cost,
                    "identi_per" => round($identi_cost / $total_cost) * 100,
                    // 外部失敗作業成本
                    "external_cost" =>  $external_cost,
                    "external_per" => round($external_cost / $total_cost) * 100,
                    "ex_Reason" => "",
                    // 內部失敗作業成本
                    "internal_cost" =>  $internal_cost,
                    "internal_per" => round($internal_cost / $total_cost) * 100,
                    "in_Reason" => "",
                );
            } elseif ($result_p[0]['property_name'] == "鑑定作業") {
                $identi_cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                    + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                    + $average_work_order_cost);

                $total_cost = $prevent_cost + $identi_cost + $external_cost + $internal_cost;

                $tmp = array(
                    //日期
                    "Date" => $real_data[0]['Data'][$a]['Date'],
                    //工單號
                    "Work_Ticked_No" => $real_data[0]['Data'][$a]["Work_Ticked_No"],
                    //預防作業成本
                    "prevent_cost" =>  $prevent_cost,
                    "prevent_per" => round($prevent_cost / $total_cost) * 100,
                    //鑑定作業成本
                    "identi_cost" =>  $identi_cost,
                    "identi_per" => round($identi_cost / $total_cost) * 100,
                    // 外部失敗作業成本
                    "external_cost" =>  $external_cost,
                    "external_per" => round($external_cost / $total_cost) * 100,
                    "ex_Reason" => "",
                    // 內部失敗作業成本
                    "internal_cost" =>  $internal_cost,
                    "internal_per" => round($internal_cost / $total_cost) * 100,
                    "in_Reason" => "",
                );
            } elseif ($result_p[0]['property_name'] == "外部失敗作業") {
                $external_cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                    + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                    + $average_work_order_cost);

                $total_cost = $prevent_cost + $identi_cost + $external_cost + $internal_cost;

                $tmp = array(
                    //日期
                    "Date" => $real_data[0]['Data'][$a]['Date'],
                    //工單號
                    "Work_Ticked_No" => $real_data[0]['Data'][$a]["Work_Ticked_No"],
                    //預防作業成本
                    "prevent_cost" =>  $prevent_cost,
                    "prevent_per" => round($prevent_cost / $total_cost) * 100,
                    //鑑定作業成本
                    "identi_cost" =>  $identi_cost,
                    "identi_per" => round($identi_cost / $total_cost) * 100,
                    // 外部失敗作業成本
                    "external_cost" =>  $external_cost,
                    "external_per" => round($external_cost / $total_cost) * 100,
                    "ex_Reason" => $real_data[0]['Data'][$a]['Reason'],
                    // 內部失敗作業成本
                    "internal_cost" =>  $internal_cost,
                    "internal_per" => round($internal_cost / $total_cost) * 100,
                    "in_Reason" => "",
                );
            } elseif ($result_p[0]['property_name'] == "內部失敗作業") {
                $internal_cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                    + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                    + $average_work_order_cost);

                $total_cost = $prevent_cost + $identi_cost + $external_cost + $internal_cost;

                $tmp = array(
                    //日期
                    "Date" => $real_data[0]['Data'][$a]['Date'],
                    //工單號
                    "Work_Ticked_No" => $real_data[0]['Data'][$a]["Work_Ticked_No"],
                    //預防作業成本
                    "prevent_cost" =>  $prevent_cost,
                    "prevent_per" => round($prevent_cost / $total_cost) * 100,
                    //鑑定作業成本
                    "identi_cost" =>  $identi_cost,
                    "identi_per" => round($identi_cost / $total_cost) * 100,
                    // 外部失敗作業成本
                    "external_cost" =>  $external_cost,
                    "external_per" => round($external_cost / $total_cost) * 100,
                    "ex_Reason" => "",
                    // 內部失敗作業成本
                    "internal_cost" =>  $internal_cost,
                    "internal_per" => round($internal_cost / $total_cost) * 100,
                    "in_Reason" => $real_data[0]['Data'][$a]['Reason'],
                );
            }
            array_push($arr, $tmp);
        }
    }
    $len_arr = count($arr);


    $tot_prevent_cost = 0;
    $tot_identi_cost = 0;
    $tot_external_cost = 0;
    $tot_internal_cost = 0;
    $arr_tot = array();
    for ($i = 0; $i < $len_arr; $i++) {
        $tot_prevent_cost += $arr[$i]['prevent_cost'];
        $tot_identi_cost += $arr[$i]['identi_cost'];
        $tot_external_cost += $arr[$i]['external_cost'];
        $tot_internal_cost += $arr[$i]['internal_cost'];
    }
    $total = $tot_prevent_cost + $tot_identi_cost + $tot_external_cost + $tot_internal_cost;
    $tmp_tot = array(
        //日期
        "Date" => "",
        //總成本
        "Work_Ticked_No" => "總成本",
        //預防作業成本
        "prevent_cost" =>  $tot_prevent_cost,
        "prevent_per" => round($tot_prevent_cost / $total) * 100,
        //鑑定作業成本
        "identi_cost" =>  $tot_identi_cost,
        "identi_per" => round($tot_identi_cost / $total) * 100,
        // 外部失敗作業成本
        "external_cost" =>  $tot_external_cost,
        "external_per" => round($tot_external_cost / $total) * 100,
        "ex_Reason" => "",
        // 內部失敗作業成本
        "internal_cost" =>  $tot_internal_cost,
        "internal_per" => round($tot_internal_cost / $total) * 100,
        "in_Reason" => "",
    );

    array_push($arr_tot, $tmp_tot);

    $arr_fin = array($arr, $arr_tot);

    echo json_encode($arr_fin);
}




$OpType();

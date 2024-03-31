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
//工單成本分析表
function sel_all_order_data_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        $material_cost = 0;
        $mac_cost = 0;
        $hum_cost = 0;
        $total_cost = 0;
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;
        if ($year >= $start_year && $year <= $end_year && $month >= $start_month && $month <= $end_month) {
            //取材料成本
            $product_num = get_product_num($real_data[0]['Data'][$a]['Material_Part_No'],  $year, $month);
            // print_r($product_num);

            //取人事成本
            $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['Staff_ID'],  $year, $month);
            // print_r($human_resource_cost);

            //取機器成本
            $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['Machine_ID'],  $year, $month);
            // print_r($machine_cost);

            //間接成本
            $average_work_order_cost = average_work_order_cost_controller($start_year,  $year, $month);
            // print_r($average_work_order_cost);


            $hum_cost = $real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate'];
            $mac_cost = $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate'];
            $material_cost = $real_data[0]['Data'][$a]['Counters'] * $product_num[0]['total_cost'];
            $total_cost = $hum_cost + $mac_cost + $material_cost + $average_work_order_cost;

            $tmp = array(
                //日期
                "Date" => $real_data[0]['Data'][$a]['Date'],
                //工單號
                "Work_Ticked_No" => $real_data[0]['Data'][$a]["Work_Ticked_No"],
                //完成數量
                "Counters" => $real_data[0]['Data'][$a]['Counters'],
                //材料成本
                "material_cost" => $material_cost,
                "material_cost_per" => round($material_cost / $total_cost) * 100,
                //機台成本
                "mac_cost" => $mac_cost,
                "mac_cost_per" => round($mac_cost / $total_cost) * 100,
                //人工成本
                "hum_cost" => $hum_cost,
                "hum_cost_per" => round($hum_cost / $total_cost) * 100,
                //間接人工成本
                "average_work_order_cost" => $average_work_order_cost,
                "average_work_order_cost_per" => round($average_work_order_cost / $total_cost) * 100,
                //工單總成本
                "total_cost" => $total_cost,
                //每單位總成本
                "avg_cost" => $total_cost / $real_data[0]['Data'][$a]['Counters'],
            );

            array_push($arr, $tmp);
        }
    }
    echo json_encode($arr);
}



$OpType();

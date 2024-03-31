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

//產品成本分析表
function sel_product_cost_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        $product_cost = 0;
        $counters =0;
        for ($b = 0; $b < count($real_data[0]['Data'][$a]['M']); $b++) {
            $cost = 0;
            $year = intval(substr($real_data[0]['Data'][$a]['M'][$b]['Date'], 0, 4)) - 1911;
            // echo $year;

            $month = intval(substr($real_data[0]['Data'][$a]['M'][$b]['Date'], 5, 2));
            // echo $month;
            if ($year >= $start_year && $year <= $end_year && $month >= $start_month && $month <= $end_month) {

                //取產品成本
                $product_num = get_product_num($real_data[0]['Data'][$a]['Material_Part_No'], $year, $month);
                // print_r($product_num);

                //取人事成本
                $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['M'][$b]['Staff_ID'], $year, $month);
                // print_r($human_resource_cost);

                //取機器成本
                $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['M'][$b]['Machine_ID'], $year, $month);
                // print_r($machine_cost);

                //間接成本
                $average_work_order_cost = average_work_order_cost_controller($year, $month);
                // print_r($average_work_order_cost);


                $cost = ($real_data[0]['Data'][$a]['M'][$b]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                    + $real_data[0]['Data'][$a]['M'][$b]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                    + $real_data[0]['Data'][$a]['M'][$b]['Counters'] * $product_num[0]['total_cost']
                    + $average_work_order_cost);
                $counters += $real_data[0]['Data'][$a]['M'][$b]['Counters'];
                $product_cost += $cost;
                // echo $product_cost;

                $tmp = array(
                    //日期
                    "Date" => $real_data[0]['Data'][$a]['M'][$b]['Date'],
                    //產品名稱
                    "product_name" => $product_num[0]['product_name'],
                    //產品數量
                    "counters" => $counters,
                    //產品總成本
                    "totle_cost" => $product_cost,
                    //產品每單位成本
                    "avg_cost" => $product_cost/$counters,
                );

                array_push($arr, $tmp);
            }
        }
    }

    echo json_encode($arr);
}



$OpType();

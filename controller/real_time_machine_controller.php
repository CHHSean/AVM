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

//--------------------------------------------------------------------------------------

//工廠管理(工廠成本)
function factory_manage_1()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };
    // print_r($_REQUEST);
    // print_r($real_data[0]['Data'][0]['Date']);

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        // example : print_r($real_data[0]['Data'][$a]);
        $cost = 0;
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;

        //取工序
        $work_num = get_work_num($real_data[0]['Data'][$a]['Process_ID']);
        // print_r($work_num);

        //取產品成本
        $product_num = get_product_num($real_data[0]['Data'][$a]['Material_Part_No'], $year, $month);
        // print_r($product_num);

        //取人事成本
        $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['Staff_ID'], $year, $month);
        // print_r($human_resource_cost);

        //取機器成本
        $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['Machine_ID'], $year, $month);
        // print_r($machine_cost);

        //間接成本
        $average_work_order_cost = average_work_order_cost_controller($year, $month);
        // print_r($average_work_order_cost);

        // echo ($product_num[0]['total_cost']);

        $cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
            + $real_data[0]['Data'][$a]['Update_Machine_Time'] * $machine_cost[0]['mc_min_rate']
            + $real_data[0]['Data'][$a]['Part_Quantity'] * $product_num[0]['total_cost']
            + $average_work_order_cost);

        $tmp = array(
            //日期
            "Date" => $real_data[0]['Data'][$a]['Date'],
            //工單號
            "Work_Ticked_No" => $real_data[0]['Data'][$a]["Work_Ticked_No"],
            //工廠成本
            "factory_cost" => $cost,
        );
        array_push($arr, $tmp);
    }
    echo json_encode($arr);
}

//工廠管理(內部失敗作業)
function factory_manage_2()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        // example : print_r($real_data[0]['Data'][$a]);
        $cost = 0;
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;

        //取工序
        $work_num = get_work_num($real_data[0]['Data'][$a]['Process_ID']);
        // print_r($work_num);

        //取產品成本
        $product_num = get_product_num($real_data[0]['Data'][$a]['Material_Part_No'], $year, $month);
        // print_r($product_num);

        //取人事成本
        $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['Staff_ID'], $year, $month);
        // print_r($human_resource_cost);

        //取機器成本
        $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['Machine_ID'], $year, $month);
        // print_r($machine_cost);

        //間接成本
        $average_work_order_cost = average_work_order_cost_controller($year, $month);
        // print_r($average_work_order_cost);

        // echo ($product_num[0]['total_cost']);


        if ($work_num[0]['property_num'] == 4) {
            $cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                + $real_data[0]['Data'][$a]['Part_Quantity'] * $product_num[0]['total_cost']
                + $average_work_order_cost);
        }

        $tmp = array(
            //日期
            "Date" => $real_data[0]['Data'][$a]['Date'],
            //內部失敗作業成本
            "cost" => $cost,
        );
        array_push($arr, $tmp);
    }
    echo json_encode($arr);
}

//工廠管理(無生產力作業)
function factory_manage_3()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        // example : print_r($real_data[0]['Data'][$a]);
        $cost = 0;
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;

        //取工序
        $work_num = get_work_num($real_data[0]['Data'][$a]['Process_ID']);
        // print_r($work_num);

        //取產品成本
        $product_num = get_product_num($real_data[0]['Data'][$a]['Material_Part_No'], $year, $month);
        // print_r($product_num);

        //取人事成本
        $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['Staff_ID'], $year, $month);
        // print_r($human_resource_cost);

        //取機器成本
        $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['Machine_ID'], $year, $month);
        // print_r($machine_cost);

        //間接成本
        $average_work_order_cost = average_work_order_cost_controller($year, $month);
        // print_r($average_work_order_cost);

        if ($work_num[0]['capacity_num'] == 6) {
            $cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                + $real_data[0]['Data'][$a]['Part_Quantity'] * $product_num[0]['total_cost']
                + $average_work_order_cost);
        }

        $tmp = array(
            //日期
            "Date" => $real_data[0]['Data'][$a]['Date'],
            //無生產力作業成本
            "cost" => $cost,
        );
        array_push($arr, $tmp);
    }
    echo json_encode($arr);
}

//產品管理(產品成本)
function product_manage_1()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();
    $arr_p = array();

    for ($a = 0; $a < $len; $a++) {
        $product_cost = 0;
        for ($b = 0; $b < count($real_data[0]['Data'][$a]['M']); $b++) {
            $cost = 0;
            $year = intval(substr($real_data[0]['Data'][$a]['M'][$b]['Date'], 0, 4)) - 1911;
            // echo $year;

            $month = intval(substr($real_data[0]['Data'][$a]['M'][$b]['Date'], 5, 2));
            // echo $month;

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

            $product_cost += $cost;
            // echo $product_cost;

            $p_tmp = array(
                //日期
                "Date" => $real_data[0]['Data'][$a]['M'][$b]['Date'],
                //產品號碼
                "Material_Part_No" => $real_data[0]['Data'][$a]['Material_Part_No'],
                //產品名稱
                "product_name" => $product_num[0]['product_name'],
                "Data" => array(
                    //工單號
                    "Work_Ticked_No" => $real_data[0]['Data'][$a]['M'][$b]['Work_Ticked_No'],
                    //產品成本
                    "cost" => $cost,
                ),
            );

            array_push($arr_p, $p_tmp);
        }

        $total_tmp[$real_data[0]['Data'][$a]['Material_Part_No']] = $product_cost;
        // $total_tmp[] = $product_cost;
        // array_push($arr_pro_cost, $total_tmp);

    }
    arsort($total_tmp);
    
    $len_d = count($arr_p);
    // echo $len_d;

    //取前五筆資料
    for($t = 0; $t< 5; $t++){
        for($a = 0; $a<$len_d; $a++){
            $a += 1;
            if(array_keys($total_tmp)[$t] == $arr_p[$a]['Material_Part_No'] ){
                // $tmp = array(
                //     //日期
                //     "Date" => $arr_p[$a]['Date'],
                //     //產品號碼
                //     "Material_Part_No" => $arr_p[$a]['Material_Part_No'],
                //     //產品名稱
                //     "product_name" => $arr_p[$a]['product_name'],
                //     "Data" => array(
                //         //工單號
                //         "Work_Ticked_No" => $arr_p[$a]['Data']['Work_Ticked_No'],
                //         //產品成本
                //         "cost" => $arr_p[$a]['Data']['cost'],
                //     ),
                // );
                $tmp = array(
                    //產品號碼
                    "Material_Part_No" => $arr_p[$a]['Material_Part_No'],
                    "total_tmp" => $total_tmp[array_keys($total_tmp)[$t]]
                );
                array_push($arr, $tmp);
            }
        }    
    }

    // print_r($arr);
    // print_r($total_tmp);
    // print_r(array_keys($total_tmp)[0]);

    echo json_encode($arr);    
}   

//產品管理(每單位成本)
function product_manage_2()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();


    for ($a = 0; $a < $len; $a++) {
        $product_cost = 0;
        $count = 0;
        $product_name = "";
        for ($b = 0; $b < count($real_data[0]['Data'][$a]['M']); $b++) {
            $cost = 0;
            $year = intval(substr($real_data[0]['Data'][$a]['M'][$b]['Date'], 0, 4)) - 1911;
            // echo $year;

            $month = intval(substr($real_data[0]['Data'][$a]['M'][$b]['Date'], 5, 2));
            // echo $month;

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

            $count += $real_data[0]['Data'][$a]['M'][$b]['Counters'];
            $product_name = $product_num[0]['product_name'];


            $cost = ($real_data[0]['Data'][$a]['M'][$b]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                + $real_data[0]['Data'][$a]['M'][$b]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                + $real_data[0]['Data'][$a]['M'][$b]['Counters'] * $product_num[0]['total_cost']
                + $average_work_order_cost);

            $product_cost += $cost;
            // echo $product_cost;
        }

        $tmp = array(
            //產品料號
            "product_num" => $real_data[0]['Data'][$a]['Material_Part_No'],
            //產品名稱
            "product_name" => $product_name,
            //完成數量
            "count" => $count,
            //每單位成本
            "unit_cost" => $product_cost/$count,
        );

        array_push($arr,$tmp);

    }
    
    // print_r($arr);
    echo json_encode($arr);
}

//產能管理(全部工單之產能屬性成本佔比圖)
function capacity_manage_1()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        $cost = 0;
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;

        //取工序
        $work_num = get_work_num($real_data[0]['Data'][$a]['Process_ID']);
        // print_r($work_num);

        $property_num = intval($work_num[0]['property_num']);
        $capacity_num = intval($work_num[0]['capacity_num']);

        $sql_capacity_name = "SELECT a.`type_name` as property_name, c.`type_name` as capacity_name
                            FROM `work_attribute` as b 
                            LEFT JOIN `attri_name` as a on a.`type_id` = $property_num
                            LEFT JOIN `attri_name` as c on c.`type_id` = $capacity_num
                            WHERE `work_num` =  '" . $real_data[0]['Data'][$a]['Process_ID'] . "';";
        $row = $conn->query($sql_capacity_name);
        $result_c = $row->fetchAll(PDO::FETCH_ASSOC);

        //取人事成本
        $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['Staff_ID'], $year, $month);
        // print_r($human_resource_cost);

        //取機器成本
        $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['Machine_ID'], $year, $month);
        // print_r($machine_cost);

        //間接成本
        $average_work_order_cost = average_work_order_cost_controller($year, $month);
        // print_r($average_work_order_cost);


        $cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
            + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
            + $average_work_order_cost);

        $tmp = array(
            //日期
            "Date" => $real_data[0]['Data'][$a]['Date'],
            //工序名稱
            "Process_ID" => $result_c[0]['capacity_name'],
            //成本
            "cost" => $cost,
        );
        array_push($arr, $tmp);
    }

    $len_arr = count($arr);
    $cap_cost = 0;
    $non_cost = 0;
    $indirect_cost = 0;
    $idle_cost = 0;
    $arr_cap_pie = array();
    for ($i = 0; $i < $len_arr; $i++) {
        if ($arr[$i]['Process_ID'] == "有生產力作業") {
            $cap_cost += $arr[$i]['cost'];
            // echo $arr[$i]['cost'];
        } else if ($arr[$i]['Process_ID'] == "無生產力作業") {
            $non_cost += $arr[$i]['cost'];
        } else if ($arr[$i]['Process_ID'] == "間接生產力作業") {
            $indirect_cost += $arr[$i]['cost'];
        } else if ($arr[$i]['Process_ID'] == "閒置產能作業") {
            $idle_cost += $arr[$i]['cost'];
        }
    }
    $tmp = array(
        "cap_cost" =>  $cap_cost,
        "non_cost" =>  $non_cost,
        "indirect_cost" =>  $indirect_cost,
        "idle_cost" =>  $idle_cost,
    );

    array_push($arr_cap_pie, $tmp);

    echo json_encode($arr_cap_pie);
}

//產能管理(無生產力作業成本)
function capacity_manage_2()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        $cost = 0;
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;

        //取工序
        $work_num = get_work_num($real_data[0]['Data'][$a]['Process_ID']);
        // print_r($work_num);

        //取人事成本
        $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['Staff_ID'], $year, $month);
        // print_r($human_resource_cost);

        //取機器成本
        $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['Machine_ID'], $year, $month);
        // print_r($machine_cost);

        //間接成本
        $average_work_order_cost = average_work_order_cost_controller($year, $month);
        // print_r($average_work_order_cost);

        if ($work_num[0]['capacity_num'] == 6) {
            $cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                + $average_work_order_cost);
            $tmp = array(
                //日期
                "Date" => $real_data[0]['Data'][$a]['Date'],
                //工單
                "Work_Ticked_No" => $real_data[0]['Data'][$a]['Work_Ticked_No'],
                //成本
                "cost" => $cost,
            );
            array_push($arr, $tmp);
        }
    }
    echo json_encode($arr);
}

//產能管理(無生產力作業成本發生之原因)
function capacity_manage_3()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        $cost = 0;
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;

        //取工序
        $work_num = get_work_num($real_data[0]['Data'][$a]['Process_ID']);
        // print_r($work_num);

        //取人事成本
        $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['Staff_ID'], $year, $month);
        // print_r($human_resource_cost);

        //取機器成本
        $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['Machine_ID'], $year, $month);
        // print_r($machine_cost);

        //間接成本
        $average_work_order_cost = average_work_order_cost_controller($year, $month);
        // print_r($average_work_order_cost);

        if ($work_num[0]['capacity_num'] == 6) {
            $cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                + $average_work_order_cost);
            $Reason = $real_data[0]['Data'][$a]['Reason'];
        
            $tmp = array(
                //日期
                "Date" => $real_data[0]['Data'][$a]['Date'],
                //原因
                "Reason" => $Reason,
                //成本
                "cost" => $cost,
            );
            array_push($arr, $tmp);
        }
        
    }
    echo json_encode($arr);
}

//品質管理(全部工單之品質屬性成本佔比圖)
function property_manage_1()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        $cost = 0;
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;

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


        $cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
            + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
            + $average_work_order_cost);

        $tmp = array(
            //日期
            "Date" => $real_data[0]['Data'][$a]['Date'],
            //工序名稱
            "Process_ID" => $result_p[0]['property_name'],
            //成本
            "cost" => $cost,
        );
        array_push($arr, $tmp);
    }
    $len_arr = count($arr);
    $prevent_cost = 0;
    $identi_cost = 0;
    $external_cost = 0;
    $internal_cost = 0;
    $arr_pro_pie = array();
    for ($i = 0; $i < $len_arr; $i++) {
        if ($arr[$i]['Process_ID'] == "預防作業") {
            $prevent_cost += $arr[$i]['cost'];
            // echo $arr[$i]['cost'];
        } else if ($arr[$i]['Process_ID'] == "鑑定作業") {
            $identi_cost += $arr[$i]['cost'];
        } else if ($arr[$i]['Process_ID'] == "外部失敗作業") {
            $external_cost += $arr[$i]['cost'];
        } else if ($arr[$i]['Process_ID'] == "內部失敗作業") {
            $internal_cost += $arr[$i]['cost'];
        }
    }
    $tmp = array(
        "prevent_cost" =>  $prevent_cost,
        "identi_cost" =>  $identi_cost,
        "external_cost" =>  $external_cost,
        "internal_cost" =>  $internal_cost,
    );

    array_push($arr_pro_pie, $tmp);

    echo json_encode($arr_pro_pie);
}

//品質管理(內部失敗作業成本)
function property_manage_2()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        $cost = 0;
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;

        //取工序
        $work_num = get_work_num($real_data[0]['Data'][$a]['Process_ID']);
        // print_r($work_num);

        //取人事成本
        $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['Staff_ID'], $year, $month);
        // print_r($human_resource_cost);

        //取機器成本
        $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['Machine_ID'], $year, $month);
        // print_r($machine_cost);

        //間接成本
        $average_work_order_cost = average_work_order_cost_controller($year, $month);
        // print_r($average_work_order_cost);

        if ($work_num[0]['property_num'] == 4) {
            $cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                + $average_work_order_cost);
                
            $tmp = array(
                //日期
                "Date" => $real_data[0]['Data'][$a]['Date'],
                //工單
                "Work_Ticked_No" => $real_data[0]['Data'][$a]['Work_Ticked_No'],
                //成本
                "cost" => $cost,
            );
            array_push($arr, $tmp);
        }
        
    }

    echo json_encode($arr);
}

//品質管理(內部失敗作業成本發生之原因)
function property_manage_3()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        $cost = 0;
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;

        //取工序
        $work_num = get_work_num($real_data[0]['Data'][$a]['Process_ID']);
        // print_r($work_num);

        //取人事成本
        $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['Staff_ID'], $year, $month);
        // print_r($human_resource_cost);

        //取機器成本
        $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['Machine_ID'], $year, $month);
        // print_r($machine_cost);

        //間接成本
        $average_work_order_cost = average_work_order_cost_controller($year, $month);
        // print_r($average_work_order_cost);

        if ($work_num[0]['property_num'] == 4) {
            $cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
                + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
                + $average_work_order_cost);
            $Reason = $real_data[0]['Data'][$a]['Reason'];

            $tmp = array(
            //日期
            "Date" => $real_data[0]['Data'][$a]['Date'],
            //原因
            "Reason" => $Reason,
            //成本
            "cost" => $cost,
            );
            array_push($arr, $tmp);
        }
    }
    echo json_encode($arr);
}

//工單(工單管理)
function work_order()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };
    // print_r($_REQUEST);
    // print_r($real_data[0]['Data'][0]['Date']);

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        // example : print_r($real_data[0]['Data'][$a]);
        $cost = 0;
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;

        //取人事成本
        $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['Staff_ID'], $year, $month);
        // print_r($human_resource_cost);

        //取機器成本
        $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['Machine_ID'], $year, $month);
        // print_r($machine_cost);

        //間接成本
        $average_work_order_cost = average_work_order_cost_controller($year, $month);
        // print_r($average_work_order_cost);

        $cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
            + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
            + $average_work_order_cost);

        $tmp = array(
            //日期
            "Date" => $real_data[0]['Data'][$a]['Date'],
            //工單號
            "Work_Ticked_No" => $real_data[0]['Data'][$a]["Work_Ticked_No"],
            //成本
            "cost" => $cost,
        );
        array_push($arr, $tmp);
    }
    echo json_encode($arr);
}

//工序(作業管理)
function work_num()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };
    // print_r($_REQUEST);
    // print_r($real_data[0]['Data'][0]['Date']);

    $len = count($real_data[0]['Data']);
    $arr = array();

    for ($a = 0; $a < $len; $a++) {
        // example : print_r($real_data[0]['Data'][$a]);
        $cost = 0;
        $year = intval(substr($real_data[0]['Data'][$a]['Date'], 0, 4)) - 1911;
        // echo $year;

        $month = intval(substr($real_data[0]['Data'][$a]['Date'], 5, 2));
        // echo $month;

        //取工序名稱
        $sql_work_name = "SELECT `work_name`  
                        FROM `work_attribute`
                        WHERE `work_num` =  '" . $real_data[0]['Data'][$a]['Process_ID'] . "'";
        $row = $conn->query($sql_work_name);
        $result_n = $row->fetchAll(PDO::FETCH_ASSOC);

        // print_r($result_n);

        //取人事成本
        $human_resource_cost = get_human_resource_cost($real_data[0]['Data'][$a]['Staff_ID'], $year, $month);
        // print_r($human_resource_cost);

        //取機器成本
        $machine_cost = get_machine_cost($real_data[0]['Data'][$a]['Machine_ID'], $year, $month);
        // print_r($machine_cost);

        //間接成本
        $average_work_order_cost = average_work_order_cost_controller($year, $month);
        // print_r($average_work_order_cost);

        $cost = ($real_data[0]['Data'][$a]["Update_Staff_Time"] * $human_resource_cost[0]['em_min_rate']
            + $real_data[0]['Data'][$a]["Update_Machine_Time"] * $machine_cost[0]['mc_min_rate']
            + $average_work_order_cost);

        $tmp = array(
            //日期
            "Date" => $real_data[0]['Data'][$a]['Date'],
            //作業名稱
            "work_name" => $result_n[0]['work_name'],
            //成本
            "cost" => $cost,
        );
        array_push($arr, $tmp);
    }
    echo json_encode($arr);
}

$OpType();

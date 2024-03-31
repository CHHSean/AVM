<?php
include('../DB.php');

global $conn;

foreach ($_REQUEST as $key => $val) {
    $$key = $val;
};

$Year = date('Y') - 1911;
$Month = date('n');

$date = new DateTime();

function sel_data_job_cost_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $len = count($real_data);
    // echo $len;


    $total_human_cost = 0;
    $toatl_machine_cost = 0;
    for ($i = 0; $i < $len; $i++) {
        $sql_human_resource_cost = "SELECT * FROM human_resource_cost WHERE em_year = '" . $real_data[$i]['YEAR']-1911 . "' AND em_month = '" . $real_data[$i]['MONTH'] . "' AND em_id = '" . $real_data[$i]['EMP_NO'] . "'";
        // echo $sql_human_resource_cost;
        $row = $conn->query($sql_human_resource_cost);
        $result_h = $row->fetchAll(PDO::FETCH_ASSOC);
        // print_r($result_h);

        $sql_machine_cost = "SELECT * FROM machine_cost WHERE mc_start_year = '" . $real_data[$i]['YEAR']-1911 . "' AND mc_start_month = '" . $real_data[$i]['MONTH'] . "' AND mc_id = '" . $real_data[$i]['MCM_NO'] . "'";
        // echo $sql;
        $row = $conn->query($sql_machine_cost);
        $result_m = $row->fetchAll(PDO::FETCH_ASSOC);

        if ((count($result_h) > 0) && (count($result_m) > 0)) {
            for ($n = 0; $n < count($result_m); $n++) {
                $total_human_cost += $real_data[$i]["EMP_WORK_TIME"] * $result_h[$n]['em_min_rate'];
                $toatl_machine_cost += $real_data[$i]["EMP_WORK_TIME"] * $result_m[$n]['mc_min_rate'];
            }
        }
    }

    $arr = array();
    for ($i = 0; $i < $len; $i++) {
        $sql_human_resource_cost = "SELECT * FROM human_resource_cost WHERE em_year = '" . $real_data[$i]['YEAR']-1911 . "' AND em_month = '" . $real_data[$i]['MONTH'] . "' AND em_id = '" . $real_data[$i]['EMP_NO'] . "'";
        // echo $sql_human_resource_cost;
        $row = $conn->query($sql_human_resource_cost);
        $result_h = $row->fetchAll(PDO::FETCH_ASSOC);
        // print_r($result_h);

        $sql_machine_cost = "SELECT * FROM machine_cost WHERE mc_start_year = '" . $real_data[$i]['YEAR']-1911 . "' AND mc_start_month = '" . $real_data[$i]['MONTH'] . "' AND mc_id = '" . $real_data[$i]['MCM_NO'] . "'";
        // echo $sql;
        $row = $conn->query($sql_machine_cost);
        $result_m = $row->fetchAll(PDO::FETCH_ASSOC);
        // print_r($result_m);

        if ((count($result_h) > 0) && (count($result_m) > 0)) {
            for ($n = 0; $n < count($result_m); $n++) {
                $human_cost = $real_data[$i]["EMP_WORK_TIME"] * $result_h[$n]['em_min_rate'];
                $machine_cost = $real_data[$i]["EMP_WORK_TIME"] * $result_m[$n]['mc_min_rate'];
                $add_cost = $human_cost + $machine_cost;
                $tmp = array(
                    // 日期
                    "REAL_DATE" => $real_data[$i]['YEAR'] . '-' . $real_data[$i]['MONTH'],
                    // 作業編號(工序編號)
                    "OP_NO" => $real_data[$i]["OP_NO"],
                    // 直接人工編號
                    "EMP_NO" => $real_data[$i]["EMP_NO"],
                    //直接人工費用
                    "human_cost" =>  round($human_cost),
                    // 直接人工佔比
                    "total_human_cost" => round(($human_cost / $total_human_cost) * 100),
                    // 機器編號
                    "MCM_NO" => $result_m[$n]['mc_id'],
                    // 機器費用
                    "machine_cost" =>  round($machine_cost),
                    // 機器佔比
                    "toatl_machine_cost" => round(($machine_cost / $toatl_machine_cost) * 100),
                    //作業名稱
                    "OP_NAME" => $real_data[$i]['OP_NAME'],
                    //成本
                    "add_cost" =>  round($add_cost)
                );
                array_push($arr, $tmp);
            }
        }
    }
    echo json_encode($arr);
}

$OpType();

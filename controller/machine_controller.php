<?php
include('../DB.php');

foreach ($_REQUEST as $key => $val) {
    $$key = $val;
};

$today = date('Y/m/d H:i:s');

function setting_mc_id_option()
{
    global $conn;
    // global $Year;
    // global $M;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };
    // echo 'test';
    $sql = "SELECT mc_id FROM machine_cost WHERE mc_start_year = $Year AND mc_start_month = $Month;";
    // echo $sql;
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_OBJ);
    echo json_encode(array("data" => $result, "status" => '200', "message" => "成功。"));
}

function Last_confirmation()
{
    global $conn;
    // global $Year;
    // global $M;
    
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };
    if($mc_id=="null"){
        $sql = "SELECT * FROM machine_cost WHERE mc_start_year = '$Year' AND mc_start_month = '$Month' AND mc_id = IFNULL(null,mc_id);";
    }else{
        $sql = "SELECT * FROM machine_cost WHERE mc_start_year = '$Year' AND mc_start_month = '$Month' AND mc_id = IFNULL('$mc_id',mc_id);";
    }

    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_OBJ);
    echo json_encode(array("data" => $result, "status" => '200', "message" => "成功。"));
}

$OpType();

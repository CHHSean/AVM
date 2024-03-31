<?php
include('../DB.php');
include('../src/PHPExcel-1.8/Classes/PHPExcel.php');
include('../src/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
require_once('../src/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
foreach ($_REQUEST as $key => $val) {
    $$key = $val;
};

$today = date('Y/m/d H:i:s');
$Year = date('Y') - 1911;
$Month = date('m');
$M = intval($Month);

//查詢所有資料
function sel_data_machine_cost_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT `mc_Row_id`, concat(cast(`mc_start_year` as varchar(3)),'-',cast(`mc_start_month` as varchar(3))) as 'YM', `mc_id`, `mc_name`, `mc_brand`, `mc_buy_year`, `mc_estimated_use_min`, `mc_dep_expense`, `mc_water_cost`, `mc_electricity_cost`, `mc_fuel_cost`, `mc_maintenance_cost`, `mc_upkeep_cost`, `mc_rental_expense`, `mc_parts_cost`, `mc_other_cost1`, `mc_other_cost2`, `mc_other_cost3`, `mc_other_cost4`, `mc_other_cost5`, `mc_total_expense`, `mc_min_rate`
            FROM `machine_cost`
            WHERE `mc_status` = 1 AND `mc_start_year` = $mc_start_year AND `mc_start_month` = $mc_start_month";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}

//查詢單筆資料
function sel_single_machine_cost_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT *
            FROM `machine_cost`
            WHERE `mc_status` = 1 AND `mc_Row_id` = $Row_id";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}

//刪除資料
function del_data_machine_cost_controller()
{
    global $conn;
    global $today;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "UPDATE `machine_cost` 
            SET `mc_mod_time` = '$today', `mc_mod_user` = '$login_user',`mc_status`= 2
            WHERE `mc_Row_id` = $Row_id";
    // echo $sql;
    $row = $conn->prepare($sql);
    $row->execute();
}

//解析CSV
function input_csv($handle)
{
    global $conn;
    global $today;

    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };
    // $out = array();
    // $n = 0;
    // foreach ($data as $i => $val) {
    //     $out[$n][$i] = $val;
    // }
    // $n++;
    // return $out;

    $i = 0;
    while ($data = fgetcsv($handle, 10000)) {
        if ($i == 0) {
            $i++;
            continue;
        };
        $total = 0;
        $avg_rate = 0;
        if (!empty($data[0])) {
            $total = $data[7] + $data[8] + $data[9] + $data[10] + $data[11] + $data[12] + $data[13] + $data[14] + $data[15] + $data[16] + $data[17] + $data[18] + $data[19];
            $avg_rate = $total / $data[6];
            $sql = "INSERT INTO `machine_cost`(`mc_start_year`, `mc_start_month`, `mc_id`, `mc_name`, `mc_brand`, `mc_buy_year`, `mc_estimated_use_min`, `mc_dep_expense`, `mc_water_cost`, `mc_electricity_cost`, `mc_fuel_cost`, `mc_maintenance_cost`, `mc_upkeep_cost`, `mc_rental_expense`, `mc_parts_cost`, `mc_other_cost1`, `mc_other_cost2`, `mc_other_cost3`, `mc_other_cost4`, `mc_other_cost5`, `mc_total_expense`, `mc_min_rate`, `mc_create_time`, `mc_create_user`, `mc_status`)
                                       VALUES ('$data[0]'     ,'$data[1]'       ,'$data[2]','$data[3]','$data[4]','$data[5]'    ,'$data[6]'            ,'$data[7]'       ,'$data[8]'      ,'$data[9]'            ,'$data[10]'    ,'$data[11]'           ,'$data[12]'      ,'$data[13]'         ,'$data[14]'     , '$data[15]'     , '$data[16]'     , '$data[17]'     , '$data[18]'     , '$data[19]'     , '$total'          , '$avg_rate'  , '$today'        , '$login_user'   ,1);";
            $row = $conn->prepare($sql);
            $row->execute();
        };
    };
    return true;
}

//檢查Excel 當月是否已上傳
function check_machine_cost()
{
    global $conn;
    global $Year;
    global $M;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT `mc_start_year`, `mc_start_month` FROM `machine_cost` WHERE `mc_start_year`= $Year AND `mc_start_month`=$M;";

    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

//上傳
function up_file_dow_control()
{
    global $Year;
    global $M;
    // print_r($_FILES);

    $file_tmp_name = $_FILES['excel']['tmp_name'];
    // print_r($file_tmp_name);
    // exit;
    if (empty($file_tmp_name)) {
        echo '請選擇要匯入的CSV檔案！';
        exit;
    }
    $handle = fopen($file_tmp_name, 'r');
    // print_r($handle);
    // exit;
    $chk = check_machine_cost();
    if (empty($chk)) {
        $file = input_csv($handle); //解析csv
        if ($file) {
            echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
        }
    } else {
        if ($chk[0]['mc_start_year'] == $Year && $chk[0]['mc_start_month'] != $M) {
            // print('123');
            $file = input_csv($handle); //解析csv
            if ($file) {
                echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
            }
        } else if ($chk[0]['mc_start_year'] == $Year && $chk[0]['mc_start_month'] == $M) {
            // print('456');
            echo json_encode(array("data" => "", "status" => '404', "message" => "當月已上傳過。如要更改，請到查詢資料做修改"));
        }
    }
}

//修改
function edit_single_data_machine_cost_controller()
{
    global $conn;
    global $today;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "UPDATE `machine_cost` 
            SET `mc_start_year`     ='$mc_start_year',
                `mc_start_month`    ='$mc_start_month',
                `mc_id`             ='$mc_id',
                `mc_name`           ='$mc_name',
                `mc_brand`          ='$mc_brand',
                `mc_buy_year`       ='$mc_buy_year',
                `mc_estimated_use_min` ='$mc_estimated_use_min',
                `mc_dep_expense`    ='$mc_dep_expense',
                `mc_water_cost`     ='$mc_water_cost',
                `mc_electricity_cost`    ='$mc_electricity_cost',
                `mc_fuel_cost`      ='$mc_fuel_cost',
                `mc_maintenance_cost`    ='$mc_maintenance_cost',
                `mc_upkeep_cost`    ='$mc_upkeep_cost',
                `mc_rental_expense` ='$mc_rental_expense',
                `mc_parts_cost`     ='$mc_parts_cost',
                `mc_other_cost1`    ='$mc_other_cost1',
                `mc_other_cost2`    ='$mc_other_cost2',
                `mc_other_cost3`    ='$mc_other_cost3',
                `mc_other_cost4`    ='$mc_other_cost4',
                `mc_other_cost5`    ='$mc_other_cost5',
                `mc_total_expense`  ='$mc_total_expense',
                `mc_min_rate`       ='$mc_min_rate',
                `mc_mod_time`       ='$today',
                `mc_mod_user`       ='$login_user'
            WHERE `mc_Row_id`=$Row_id";
    // echo $sql;
    $row = $conn->prepare($sql);
    $row->execute();

    echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
}

//單筆新增，檢查當月及機器是否上傳過
function chk_Machine_num_controller()
{
    global $conn;
    global $today;
    global $M;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT * FROM `machine_cost` WHERE `mc_start_year`= $mc_start_year AND `mc_start_month`=$mc_start_month AND `mc_id` = '$mc_id';";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
        echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
    } else if (!empty($result)) {
        echo json_encode(array("data" => "", "status" => '404', "message" => "當月機器編號，已上傳過。如要更改，請到查詢做修改"));
    }
}

//單筆新增
function add_single_data_controller()
{
    global $conn;
    global $today;

    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $total = $mc_dep_expense + $mc_water_cost + $mc_electricity_cost + $mc_fuel_cost + $mc_maintenance_cost + $mc_upkeep_cost + $mc_rental_expense + $mc_parts_cost + $mc_other_cost1 + $mc_other_cost2 + $mc_other_cost3 + $mc_other_cost4 + $mc_other_cost5;
    $avg_rate = $total / $mc_estimated_use_min;
    $sql = "INSERT INTO `machine_cost`(`mc_start_year`, `mc_start_month`, `mc_id`, `mc_name`, `mc_brand`, `mc_buy_year`, `mc_estimated_use_min`, `mc_dep_expense`, `mc_water_cost`, `mc_electricity_cost`, `mc_fuel_cost`, `mc_maintenance_cost`, `mc_upkeep_cost`, `mc_rental_expense`, `mc_parts_cost`, `mc_other_cost1`, `mc_other_cost2`, `mc_other_cost3`, `mc_other_cost4`, `mc_other_cost5`, `mc_total_expense`, `mc_min_rate`, `mc_create_time`, `mc_create_user`, `mc_status`)
                               VALUES ('$mc_start_year','$mc_start_month','$mc_id','$mc_name','$mc_brand','$mc_buy_year','$mc_estimated_use_min','$mc_dep_expense','$mc_water_cost','$mc_electricity_cost','$mc_fuel_cost','$mc_maintenance_cost','$mc_upkeep_cost','$mc_rental_expense','$mc_parts_cost','$mc_other_cost1','$mc_other_cost2','$mc_other_cost3','$mc_other_cost4','$mc_other_cost5','$total','$avg_rate','$today','$login_user', 1);";
    $row = $conn->prepare($sql);
    $row->execute();

    echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
}

//下拉式年選擇
function sel_year_controller()
{

    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT  DISTINCT `mc_start_year`
            FROM `machine_cost` 
            WHERE `mc_status` = 1
            ORDER BY `mc_start_year` DESC;";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}

//下拉式月選擇
function sel_month_controller()
{

    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT  DISTINCT `mc_start_month`
            FROM `machine_cost` 
            WHERE `mc_status` = 1 AND `mc_start_year` = $mc_start_year
            ORDER BY `mc_start_month` DESC;";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode($result);
}

//下載EXCEL
function dow_excel()
{

    // $Request = new Request();
    // $data        = $Request->request();
    // $data        = $Request->getUriParamter();
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    // $header_title = $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
    $objPHPExcel->getActiveSheet()->setCellValue('A1', '年');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', '月');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', '機器編號');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', '機器名稱');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', '機器廠牌');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', '機器購買年份');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', '機器預計使用分鐘（每月）');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', '機器折舊費用（每月）');
    $objPHPExcel->getActiveSheet()->setCellValue('I1', '機器水費（每月）');
    $objPHPExcel->getActiveSheet()->setCellValue('J1', '機器電費（每月）');
    $objPHPExcel->getActiveSheet()->setCellValue('K1', '機器燃油費（每月）');
    $objPHPExcel->getActiveSheet()->setCellValue('L1', '機器保養費（每月）');
    $objPHPExcel->getActiveSheet()->setCellValue('M1', '機器維修費（每月）');
    $objPHPExcel->getActiveSheet()->setCellValue('N1', '機器場地費（每月）');
    $objPHPExcel->getActiveSheet()->setCellValue('O1', '機器零件費（每月）');
    $objPHPExcel->getActiveSheet()->setCellValue('P1', '其他費用1');
    $objPHPExcel->getActiveSheet()->setCellValue('Q1', '其他費用2');
    $objPHPExcel->getActiveSheet()->setCellValue('R1', '其他費用3');
    $objPHPExcel->getActiveSheet()->setCellValue('S1', '其他費用4');
    $objPHPExcel->getActiveSheet()->setCellValue('T1', '其他費用5');
    // print_r(mb_convert_encoding($Machines, 'UTF-8', 'big5'));
    $len = count($Machines);
    // echo $Machines[0]['Machine_No'];
    // echo $len;
    // echo json_encode(array("data" => "$Machines[0]", "status" => '200', "message" => "成功"));
    global $Year;
    global $M;
    for ($i = 0; $i < $len; $i++) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2), $Year);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2), $M);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2), $Machines[$i]['Machine_No']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2), $Machines[$i]['Machine_Name']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2), 'N');
        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2), 'N');
    }
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // 設定下載 Excel 的檔案名稱
    header('Content-Disposition: attachment;filename="' . 'data' . '.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('../file/report.xlsx');
    header('Location:../file/report.xlsx');
    exit;
}

$OpType();

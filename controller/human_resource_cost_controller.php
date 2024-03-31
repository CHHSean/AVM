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

//查詢全部
function sel_data_human_resource_cost_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT Row_id,em_year,em_month,em_id,em_name,em_sex,em_age,em_job_name,em_work_hour,em_salary,em_labor_insurance,em_labor_refund,em_ey,em_perform_bonus,em_split_bill,em_use_machine,em_other_cost1,em_other_cost2,em_other_cost3,em_other_cost4,em_other_cost5,em_total_expense,em_min_rate
    FROM `human_resource_cost`
    WHERE `em_status` = 1  AND `em_year` = $em_year AND `em_month` = $em_month";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}

//查詢單筆資料
function sel_single_human_resource_cost_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT *
            FROM `human_resource_cost`
            WHERE `em_status` = 1 AND `Row_id` = $Row_id";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}

//單筆新增
function add_single_data_controller()
{
    global $conn;
    global $today;

    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $total = $em_salary + $em_labor_insurance + $em_labor_refund + $em_ey + $em_perform_bonus + $em_split_bill + $em_other_cost1 + $em_other_cost2 + $em_other_cost3 + $em_other_cost4 + $em_other_cost5; //$em_use_machine
    $avg_rate = $total / $em_work_hour;
    $sql = "INSERT INTO `human_resource_cost`(em_year ,em_month ,em_id   ,em_name   ,em_sex   ,em_age ,em_job_name   ,em_work_hour   ,em_salary   ,em_labor_insurance   ,em_labor_refund    ,em_ey  ,em_perform_bonus   ,em_split_bill   ,em_use_machine   ,em_other_cost1   ,em_other_cost2   ,em_other_cost3   ,em_other_cost4   ,em_other_cost5   ,em_total_expense,em_min_rate, `em_create_time`, `em_create_user`, `em_status`)
                                      VALUES ($em_year,$em_month,'$em_id','$em_name','$em_sex',$em_age,'$em_job_name','$em_work_hour','$em_salary','$em_labor_insurance','$em_labor_refund','$em_ey','$em_perform_bonus','$em_split_bill','$em_use_machine','$em_other_cost1','$em_other_cost2','$em_other_cost3','$em_other_cost4','$em_other_cost5','$total'        ,'$avg_rate','$today'         ,'$login_user'    , 1);";
    // echo $sql;
    $row = $conn->prepare($sql);
    $row->execute();

    echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
}

//檢查單筆，當月人事成本，是否重複
function chk_human_resource_num_controller()
{
    global $conn;
    global $Year;
    global $M;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT * FROM `human_resource_cost` WHERE `em_year`= $em_year AND `em_month`= $em_month AND `em_id` = '$em_id';";
    // echo $sql;
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
        echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
    } else if (!empty($result)) {
        echo json_encode(array("data" => "", "status" => '404', "message" => "當月人事成本，已上傳過。如要更改，請到查詢做修改"));
    }
}

//單筆刪除
function del_data_human_resource_cost_controller()
{
    global $conn;
    global $today;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "UPDATE `human_resource_cost` 
            SET `em_mod_time` = '$today', `em_mod_user` = '$login_user',`em_status`= 2
            WHERE `Row_id` = $Row_id";
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
        if (!empty($data[0])) {
            $sql = "INSERT INTO `human_resource_cost`(em_year     ,em_month     ,em_id        ,em_name    ,em_sex       ,em_age      ,em_job_name  ,em_work_hour  ,em_salary    ,em_labor_insurance   ,em_labor_refund,em_ey     ,em_perform_bonus  ,em_split_bill ,em_use_machine ,em_other_cost1 ,em_other_cost2 ,em_other_cost3 ,em_other_cost4 ,em_other_cost5  ,em_total_expense  ,em_min_rate  , `em_create_time`, `em_create_user`, `em_status`)
                                              VALUES ($data[0]    ,$data[1]     ,'$data[2]'   ,'$data[3]' ,'$data[4]'   ,$data[5]    ,'$data[6]'   ,'$data[7]'    ,'$data[8]'   ,'$data[9]'           ,'$data[10]'               ,'$data[11]'       ,'$data[12]'   ,'$data[13]'    ,'$data[14]'    , '$data[15]'   , '$data[16]'   , '$data[17]'    , '$data[18]'      , '$data[19]', '$data[20]', '$data[21]' , '$today'        , '$login_user'   ,1);";
            // echo $sql;                                              
            $row = $conn->prepare($sql);
            $row->execute();
        };
    };
    return true;
}

//檢查Excel 當月是否已上傳
function check_human_cost()
{
    global $conn;
    global $Year;
    global $M;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT `em_year`, `em_month` FROM `human_resource_cost` WHERE `em_year`= $Year AND `em_month`=$M;";

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
    $chk = check_human_cost();
    if (empty($chk)) {
        $file = input_csv($handle); //解析csv
        if ($file) {
            echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
        }
    } else {
        if ($chk[0]['em_year'] == $Year && $chk[0]['em_month'] != $M) {
            // print('123');
            $file = input_csv($handle); //解析csv
            if ($file) {
                echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
            }
        } else if ($chk[0]['em_year'] == $Year && $chk[0]['em_month'] == $M) {
            // print('456');
            echo json_encode(array("data" => "", "status" => '404', "message" => "當月已上傳過。如要更改，請到查詢資料做修改"));
        }
    }
}

//修改
function edit_single_data_human_resource_cost_controller()
{
    global $conn;
    global $today;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "UPDATE `human_resource_cost` 
            SET `em_year`            =$em_year,
                `em_month`          =$em_month,
                `em_id`             ='$em_id',
                `em_name`           ='$em_name',
                `em_sex`            ='$em_sex',
                `em_age`            =$em_age,
                `em_job_name`       ='$em_job_name',
                `em_work_hour`      ='$em_work_hour',
                `em_salary`         ='$em_salary',
                `em_labor_insurance` ='$em_labor_insurance',
                `em_labor_refund`    ='$em_labor_refund',
                `em_ey`             ='$em_ey',
                `em_perform_bonus`  ='$em_perform_bonus',
                `em_split_bill`     ='$em_split_bill',
                `em_use_machine`    ='$em_use_machine',
                `em_other_cost1`    ='$em_other_cost1',
                `em_other_cost2`    ='$em_other_cost2',
                `em_other_cost3`    ='$em_other_cost3',
                `em_other_cost4`    ='$em_other_cost4',
                `em_other_cost5`    ='$em_other_cost5',
                `em_total_expense`  ='$em_total_expense',
                `em_min_rate`       ='$em_min_rate',
                `em_mod_time`       ='$today',
                `em_mod_user`       ='$login_user'
            WHERE `Row_id`=$Row_id";
    // echo $sql;
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

    $sql = "SELECT  DISTINCT `em_year`
            FROM `human_resource_cost` 
            WHERE `em_status` = 1
            ORDER BY `em_year` DESC;";
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

    $sql = "SELECT  DISTINCT `em_month`
            FROM `human_resource_cost` 
            WHERE `em_status` = 1 AND `em_year` = $em_year
            ORDER BY `em_month` DESC;";
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
    $objPHPExcel->getActiveSheet()->setCellValue('C1', '員工編號');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', '姓名');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', '性別');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', '年鹷');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', '作業名稱');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', '工時');
    $objPHPExcel->getActiveSheet()->setCellValue('I1', '薪資');
    $objPHPExcel->getActiveSheet()->setCellValue('J1', '勞健保');
    $objPHPExcel->getActiveSheet()->setCellValue('K1', '勞退金');
    $objPHPExcel->getActiveSheet()->setCellValue('L1', '年終');
    $objPHPExcel->getActiveSheet()->setCellValue('M1', '績效奬金');
    $objPHPExcel->getActiveSheet()->setCellValue('N1', '應分攤的費用');
    $objPHPExcel->getActiveSheet()->setCellValue('O1', '操作的機械');
    $objPHPExcel->getActiveSheet()->setCellValue('P1', '費用1');
    $objPHPExcel->getActiveSheet()->setCellValue('Q1', '費用2');
    $objPHPExcel->getActiveSheet()->setCellValue('R1', '費用3');
    $objPHPExcel->getActiveSheet()->setCellValue('S1', '費用4');
    $objPHPExcel->getActiveSheet()->setCellValue('T1', '費用5');
    $objPHPExcel->getActiveSheet()->setCellValue('U1', '總費用');
    $objPHPExcel->getActiveSheet()->setCellValue('V1', '每分鐘員工費率');
    // print_r(mb_convert_encoding($Machines, 'UTF-8', 'big5'));
    // $len = count($Machines);
    // echo $Machines[0]['Machine_No'];
    // echo $len;
    // echo json_encode(array("data" => "$Machines[0]", "status" => '200', "message" => "成功"));
    // global $Year;
    // global $M;
    // for ($i = 0; $i < $len; $i++) {
    //     $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2), $Year);
    //     $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2), $M);
    //     $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2), $Machines[$i]['Machine_No']);
    //     $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2), $Machines[$i]['Machine_Name']);
    //     $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2), 'N');
    //     $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2), 'N');
    // }
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
    $objWriter->save('../file/human_cost.xlsx');
    header('Location:../file/human_cost.xlsx');
    exit;
}
$OpType();

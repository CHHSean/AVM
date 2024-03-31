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

//解析CSV
function chk_input_csv($handle)
{
    global $conn;
    global $today;


    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $y = 0;
    $msg = true;
    $data_array = array();
    while (($chk_data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($y == 0) {
            $y++;
            continue;
        };
        $sql = "SELECT `work_num` FROM `work_attribute` WHERE `work_num` = '$chk_data[0]'";
        // echo $sql;
        $row = $conn->query($sql);
        $result = $row->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            // print_r($result);
            array_push($data_array, $result[0]['work_num']);
            $msg = false;
        }
    }
    fclose($handle);
    return  [$msg, $data_array];
}

function input_csv($chk_handle, $chk_msg)
{
    global $conn;
    global $today;


    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $i = 0;

    if ($chk_msg != false) {
        // echo $msg;
        while ($data = fgetcsv($chk_handle, 10000)) {
            if ($i == 0) {
                $i++;
                continue;
            };
            // print_r($data[0]);
            if (!empty($data[0])) {

                $str_1 = $data[2];
                $pro_num = intval(substr($str_1, 0, 1));
                $str_2 = $data[3];
                $cap_num = intval(substr($str_2, 0, 1));
                $sql = "INSERT INTO `work_attribute`(`work_num` , `work_name` , `property_num` , `capacity_num`, `create_time`, `status`)
                                            VALUES ('$data[0]'   ,'$data[1]',   '$pro_num',        '$cap_num',   '$today',          '1')";
                $row = $conn->prepare($sql);
                $row->execute();
            };
        };
        return true;
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
    // print_r($_REQUEST);
    // $pro_num = intval(substr($property, 0, 1));
    // $cap_num = intval(substr($capacity, 0, 1));

    $sql = "INSERT INTO `work_attribute`(`work_num`, `work_name`, `property_num`, `capacity_num`, `create_time`, `create_user`, `status`)
                                VALUES ('$work_num' , '$work_name' , $property , $capacity ,     '$today' ,   '$login_user' ,   1);";
    $row = $conn->prepare($sql);
    $row->execute();

    echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
}

//單筆新增，檢查是否已新增過的作業編號
function chk_work_num_controller()
{
    global $conn;

    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT `work_num` FROM `work_attribute`
            WHERE `work_num`= '$work_num' ;";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
        echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
    } else if (!empty($result)) {
        echo json_encode(array("data" => "", "status" => '404', "message" => "此作業代碼，已上傳過。如要更改，請到查詢做修改"));
    }
}

//查詢全部
function sel_data_work_attribute_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT w.`Row_id`,w.`work_num`,w.`work_name`,a.type_name as property,b.type_name as capacity FROM `work_attribute` as w 
            LEFT JOIN attri_name as a on w.property_num = a.type_id
            LEFT JOIN attri_name as b on w.capacity_num = b.type_id
            WHERE w.status = 1
            ORDER BY w.`Row_id` ASC";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}

//查詢單筆資料
function sel_single_work_attribute_controller()
{

    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

     $sql = "SELECT w.`Row_id`,w.`work_num`,w.`work_name`,a.type_name as property,b.type_name as capacity,w.property_num,w.capacity_num FROM `work_attribute` as w 
            LEFT JOIN attri_name as a on w.property_num = a.type_id
            LEFT JOIN attri_name as b on w.capacity_num = b.type_id
            WHERE w.`Row_id` = $Row_id AND w.status = 1";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}
//單筆刪除
function del_data_work_attribute_controller()
{

    global $conn;
    global $today;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "UPDATE `work_attribute` 
            SET `create_user` = '$login_user',`status`= 2
            WHERE `Row_id` = $Row_id";
    $row = $conn->prepare($sql);
    $row->execute();
}

//修改
function edit_single_data_work_attribute_controller()
{
    global $conn;
    global $today;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };
    // print_r($_REQUEST);
    // $pro_num = intval(substr($property, 0, 1));
    // $cap_num = intval(substr($capacity, 0, 1));

    $sql = "UPDATE `work_attribute` 
            SET `work_num` = '$work_num',
                `work_name` = '$work_name',
                `property_num` = $property,
                `capacity_num` = $capacity
            WHERE `Row_id` = $Row_id";
    
    $row = $conn->prepare($sql);
    $row->execute();
    echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
}

//上傳
function up_file_dow_control()
{
    // global $Year;
    // global $M;
    // print_r($_FILES);

    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };
    // print_r($_REQUEST);
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
    $chk_msg = chk_input_csv($handle);
    $chk_handle = fopen($file_tmp_name, 'r');
    if ($chk_msg[0] == true) {
        $file = input_csv($chk_handle, $chk_msg[0]); //解析csv
        if ($file == true) {
            echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
        }
    } else {
        $len = count($chk_msg[1]);
        $str = '';
        for ($a = 0; $a < $len; $a++) {
            $str .= $chk_msg[1][$a] . ',';
        }

        echo json_encode(array("data" => "$str", "status" => '404', "message" => "失敗"));
    }
}

//下載
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
    $objPHPExcel->getActiveSheet()->setCellValue('A1', '作業代碼');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', '作業名稱');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', '品質屬性');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', '產能屬性');

    $objPHPExcel->createSheet(); //建立新的工作表
    $objPHPExcel->setActiveSheetIndex(1); //現編輯頁
    $objPHPExcel->getActiveSheet()->setCellValue('A1', '1.預防作業');
    $objPHPExcel->getActiveSheet()->setCellValue('A2', '2.鑑定作業');
    $objPHPExcel->getActiveSheet()->setCellValue('A3', '3.外部失敗作業');
    $objPHPExcel->getActiveSheet()->setCellValue('A4', '4.內部失敗作業');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', '5.有生產力作業');
    $objPHPExcel->getActiveSheet()->setCellValue('B2', '6.無生產力作業');
    $objPHPExcel->getActiveSheet()->setCellValue('B3', '7.間接生產力作業');
    $objPHPExcel->getActiveSheet()->setCellValue('B4', '8.閒置產能作業');
    $objPHPExcel->getSheetByName("Worksheet 1")->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VERYHIDDEN);
    $objPHPExcel->setActiveSheetIndex(0);
    $objValidation2 = $objPHPExcel->getActiveSheet()->getCell('C2')->getDataValidation();
    $objValidation2->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
    $objValidation2->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
    $objValidation2->setAllowBlank(false);
    $objValidation2->setShowInputMessage(true);
    $objValidation2->setShowErrorMessage(true);
    $objValidation2->setShowDropDown(true);
    // $objValidation2->setErrorTitle('Invalid date');
    // $objValidation2->setError('Date is not in list.');
    // $objValidation2->setPromptTitle('Select DOB date');
    // $objValidation2->setPrompt('Please pick a date from the drop-down list.');
    $objValidation2->setFormula1("='Worksheet 1'" . '!$A$1:$A$4');
    $objValidation3 = $objPHPExcel->getActiveSheet()->getCell('D2')->getDataValidation();
    $objValidation3->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
    $objValidation3->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
    $objValidation3->setAllowBlank(false);
    $objValidation3->setShowInputMessage(true);
    $objValidation3->setShowErrorMessage(true);
    $objValidation3->setShowDropDown(true);
    $objValidation3->setFormula1("='Worksheet 1'" . '!$B$1:$B$4');



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
    $objWriter->save('../file/work_attribute.xlsx');
    header('Location:../file/work_attribute.xlsx');
    exit;
}
$OpType();

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
function input_pd_csv($handle)
{
    global $conn;
    global $today;
    global $Year;
    global $M;

    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $i = 0;
    while ($data = fgetcsv($handle, 10000)) {
        if ($i == 0) {
            $i++;
            continue;
        };
        if (!empty($data[0])) {
            $sql = "INSERT INTO `product`(`pd_create_year`, `pd_create_month`, `product_num`, `product_name`, `product_bom`, `material_num`, `material_useage`, `pd_create_user`, `pd_create_time`, `pd_status`)
                                VALUES ($Year,            $M,               '$data[0]',     '$data[1]',     '$data[2]',     '$data[3]',   $data[4],       '$login_user',      '$today',           1);";
            // echo $sql;
            $row = $conn->prepare($sql);
            $row->execute();
        };
    };
    return true;
}

function input_mt_csv($handle)
{
    global $conn;
    global $today;
    global $Year;
    global $M;

    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $i = 0;
    while ($data = fgetcsv($handle, 10000)) {
        if ($i == 0) {
            $i++;
            continue;
        };
        if (!empty($data[0])) {
            $sql = "INSERT INTO `material`(`mt_create_year`, `mt_create_month`, `mt_num`, `mt_cost`, `mt_create_user`, `mt_create_time`, `mt_status`) 
                                    VALUES ($Year,            $M,              '$data[0]',  '$data[1]','$login_user',       '$today',       1);";
            $row = $conn->prepare($sql);
            $row->execute();
        };
    };
    return true;
}

//檢查Excel 當月是否已上傳
function check_product()
{
    global $conn;
    global $Year;
    global $M;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT `pd_create_year`, `pd_create_month` FROM `product` 
    WHERE `pd_create_year`= $Year AND `pd_create_month`=$M;";

    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function check_material()
{
    global $conn;
    global $Year;
    global $M;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT `mt_create_year`, `mt_create_month` FROM `material` 
    WHERE `mt_create_year`= $Year AND `mt_create_month`=$M;";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
//上傳
function up_file_dow_pd_control()
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
    $chk = check_product();
    if (empty($chk)) {
        $file = input_pd_csv($handle); //解析csv
        if ($file) {
            echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
        }
    } else {
        if ($chk[0]['pd_create_year'] == $Year && $chk[0]['pd_create_month'] != $M) {
            // print('123');
            $file = input_pd_csv($handle); //解析csv
            if ($file) {
                echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
            }
        } else if ($chk[0]['pd_create_year'] == $Year && $chk[0]['pd_create_month'] == $M) {
            // print('456');
            echo json_encode(array("data" => "", "status" => '404', "message" => "當月已上傳過。如要更改，請到查詢資料做修改"));
        }
    }
}

function up_file_dow_mt_control()
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
    $chk = check_material();
    if (empty($chk)) {
        $file = input_mt_csv($handle); //解析csv
        if ($file) {
            echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
        }
    } else {
        if ($chk[0]['mt_create_year'] == $Year && $chk[0]['mt_create_month'] != $M) {
            // print('123');
            $file = input_mt_csv($handle); //解析csv
            if ($file) {
                echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
            }
        } else if ($chk[0]['mt_create_year'] == $Year && $chk[0]['mt_create_month'] == $M) {
            // print('456');
            echo json_encode(array("data" => "", "status" => '404', "message" => "當月已上傳過。如要更改，請到查詢資料做修改"));
        }
    }
}
//下載
function dow_pd_excel()
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
    $objPHPExcel->getActiveSheet()->setCellValue('A1', '成品料號');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', '成品名稱');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'BOM');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', '材料料號');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', '材料使用量');





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
    $objWriter->save('../file/product.xlsx');
    header('Location:../file/product.xlsx');
    exit;
}

function dow_mt_excel()
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
    $objPHPExcel->getActiveSheet()->setCellValue('A1', '材料料號');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', '材料單價');





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
    $objWriter->save('../file/material.xlsx');
    header('Location:../file/material.xlsx');
    exit;
}

//單筆新增
function add_pd_single_data_controller()
{
    global $conn;
    global $today;

    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "INSERT INTO `product`(`pd_create_year`, `pd_create_month`, `product_num`, `product_name`, `product_bom`, `material_num`, `material_useage`, `pd_create_user`, `pd_create_time`, `pd_status`)
                         VALUES ($pd_create_year ,$pd_create_month, '$product_num' , '$product_name' ,'$product_bom' , '$material_num' ,$material_useage ,'$login_user' , '$today' ,  1);";
    $row = $conn->prepare($sql);
    $row->execute();

    echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
}

function add_mt_single_data_controller()
{
    global $conn;
    global $today;

    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "INSERT INTO `material`(`mt_create_year`, `mt_create_month`, `mt_num`, `mt_cost`, `mt_create_user`, `mt_create_time`, `mt_status` )
                         VALUES ($mt_create_year ,$mt_create_month, '$mt_num' , $mt_cost ,'$login_user' , '$today' , 1 );";
    $row = $conn->prepare($sql);
    $row->execute();

    echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
}

//檢查當月當月已新增過此成品
function chk_pd_num_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT * FROM `product` WHERE `pd_create_year`= $pd_create_year AND `pd_create_month`=$pd_create_month AND `product_num` = '$product_num';";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
        echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
    } else if (!empty($result)) {
        echo json_encode(array("data" => "", "status" => '404', "message" => "當月此成品，已上傳過。如要更改，請到查詢做修改"));
    }
}

//檢查當月當月已新增過此材料
function chk_mt_num_controller()
{
    global $conn;
    global $today;
    global $M;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT * 
            FROM `material` 
            WHERE `mt_create_year`= $mt_create_year AND `mt_create_month`=$mt_create_month AND `mt_num` = '$mt_num';";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
        echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
    } else if (!empty($result)) {
        echo json_encode(array("data" => "", "status" => '404', "message" => "當月此材料，已上傳過。如要更改，請到查詢做修改"));
    }
}

//下拉式成品年選擇
function sel_pd_year_controller()
{

    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT  DISTINCT `pd_create_year`
            FROM `product` 
            WHERE `pd_status` = 1
            ORDER BY `pd_create_year` DESC;";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}

//下拉式成品月選擇
function sel_pd_month_controller()
{

    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT  DISTINCT `pd_create_month`
            FROM `product` 
            WHERE `pd_status` = 1 AND `pd_create_year` = $pd_create_year
            ORDER BY `pd_create_month` DESC;";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode($result);
}

//下拉式材料年選擇
function sel_mt_year_controller()
{

    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT  DISTINCT `mt_create_year`
            FROM `material` 
            WHERE `mt_status` = 1
            ORDER BY `mt_create_year` DESC;";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}

//下拉式成品月選擇
function sel_mt_month_controller()
{

    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT  DISTINCT `mt_create_month`
            FROM `material` 
            WHERE `mt_status` = 1 AND `mt_create_year` = $mt_create_year
            ORDER BY `mt_create_month` DESC;";

    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode($result);
}


//查詢成品全部
function sel_data_product_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql_product_num = "SELECT p.`Row_id`,`pd_create_year`,`pd_create_month`,`product_num`,`product_name`,SUM(`mt_cost`*`material_useage`) as total_cost 
                        FROM `product`as p , material as m
                        WHERE p.`material_num` = m.`mt_num` AND `pd_status` = 1  AND `pd_create_year` = $pd_create_year AND `pd_create_month` = $pd_create_month AND `mt_create_year` = $pd_create_year AND `mt_create_month` = $pd_create_month 
                        GROUP BY `product_num`;";
    // echo $sql_product_num;
    $row = $conn->query($sql_product_num);
    $result_p = $row->fetchAll(PDO::FETCH_ASSOC);

    // echo json_encode($result_p);
    $len = count($result_p);
    $arr = array();

    for ($i = 0; $i < $len; $i++) {
        $tmp = array(
            "Row_id" => $result_p[$i]['Row_id'],
            "id" => $i + 1,
            "pd_create_year" => $result_p[$i]['pd_create_year'],
            "pd_create_month" => $result_p[$i]['pd_create_month'],
            "product_num" => $result_p[$i]['product_num'],
            "product_name" => $result_p[$i]['product_name'],
            "total_cost" => $result_p[$i]['total_cost'],
        );
        // print_r($result);
        array_push($arr, $tmp);
    }
    echo json_encode($arr);
}
//查詢BOM成品
function sel_data_pdbom_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql_product = "SELECT p.`Row_id`,`pd_create_year`,`pd_create_month`,`product_num`,`product_name`,SUM(`mt_cost`*`material_useage`) as total_cost 
            FROM `product`as p , material as m
            WHERE p.`material_num` = m.`mt_num` AND `pd_status` = 1  AND `product_num` = '$display_product_num' AND `pd_create_year` = $pd_create_year AND `pd_create_month` = $pd_create_month AND `mt_create_year` = $pd_create_year AND `mt_create_month` = $pd_create_month 
            GROUP BY `product_num`";
    $row = $conn->query($sql_product);
    $result_p = $row->fetchAll(PDO::FETCH_ASSOC);
    // echo($sql);

    // echo json_encode($result_p);
    $len = count($result_p);
    $arr = array();

    for ($i = 0; $i < $len; $i++) {
        $tmp = array(
            "display_Row_id" => $i + 1,
            "display_pd_create_year" => $result_p[$i]['pd_create_year'],
            "display_pd_create_month" => $result_p[$i]['pd_create_month'],
            "display_product_num" => $result_p[$i]['product_num'],
            "display_product_name" => $result_p[$i]['product_name'],
            "display_total_cost" => $result_p[$i]['total_cost'],
        );
        // print_r($result);
        array_push($arr, $tmp);
    }

    $sql_bom = " SELECT `product_bom`, SUM(`mt_cost`*`material_useage`) as total_cost 
    FROM `product`as p , `material` as m 
    WHERE p.`material_num` = m.`mt_num` AND `product_num` = '$display_product_num' AND `pd_create_year` = $pd_create_year AND `pd_create_month` = $pd_create_month AND `mt_create_year` = $pd_create_year AND `mt_create_month` = $pd_create_month AND `pd_status` = 1 
    GROUP BY `product_bom`  ";
    $row = $conn->query($sql_bom);
    $result_b = $row->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(array("data_1" => $arr, "data_2" => $result_b));
}

// //查詢成品日期要求
// function sel_data_ym_product_controller()
// {  
//     global $conn;
//     foreach ($_REQUEST as $key => $val) {
//         global $$key;
//     };

//     $sql_product_num = "SELECT p.`Row_id`,`pd_create_year`,`pd_create_month`,`product_num`,`product_name`,SUM(`mt_cost`*`material_useage`) as total_cost 
//             FROM `product`as p , material as m
//             WHERE p.`material_num` = m.`mt_num` AND  `pd_create_year` = 110 AND `pd_create_month` = 7
//             GROUP BY product_num";
//     $row = $conn->query($sql_product_num);
//     $result_p = $row->fetchAll(PDO::FETCH_ASSOC);

//     // echo json_encode($result_p);
//     $len = count($result_p);
//     $arr = array();

//     for($i = 0; $i < $len; $i++) {
//         $tmp = array(
//             "Row_id" => $i+1,
//             "pd_create_year" => $result_p[$i]['pd_create_year'],
//             "pd_create_month" => $result_p[$i]['pd_create_month'],
//             "product_num" => $result_p[$i]['product_num'],
//             "product_name" => $result_p[$i]['product_name'],
//             "total_cost" => $result_p[$i]['total_cost'],
//         );
//         // print_r($result);
//         array_push($arr, $tmp);
//     }
//     echo json_encode($arr);      
// }

// example table

//查詢各BOM材料查詢
function sel_data_bommt_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT `product_bom`, `material_num`, `mt_cost`*`material_useage` as material_cost 
            FROM `product` as p 
            LEFT JOIN `material` as m ON m.mt_num = p.material_num 
            WHERE `product_bom` = '$product_bom' AND `pd_status` = 1 AND `mt_create_year` = $pd_create_year AND `mt_create_month` = $pd_create_month";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}


//查詢材料
function sel_data_material_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT `Row_id`,`mt_create_year`,`mt_create_month`,`mt_num`,`mt_cost` 
            FROM `material`
            WHERE mt_status = 1 AND `mt_create_year` = $mt_create_year AND `mt_create_month` = $mt_create_month
            ORDER BY `mt_create_month` ASC";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode($result);
}

// //查詢材料日期要求
// function sel_data_ym_material_controller()
// {
//     global $conn;
//     foreach ($_REQUEST as $key => $val) {
//         global $$key;
//     };

//     $sql = "SELECT `Row_id`,`mt_create_year`,`mt_create_month`,`mt_num`,`mt_cost` 
//             FROM `material`
//             WHERE mt_status = 1 AND `mt_create_year` = 110 AND `mt_create_month` = 7
//             ORDER BY `mt_create_month` ASC";
//     $row = $conn->query($sql);
//     $result = $row->fetchAll(PDO::FETCH_ASSOC);


//     echo json_encode($result);
// }

//單筆成品刪除
function del_data_product_controller()
{
    global $conn;
    global $today;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "UPDATE `product` 
            SET `pd_create_user` = '$login_user',`pd_status`= 2
            WHERE `product_num` = '$product_num' AND `pd_create_year` = $pd_create_year AND `pd_create_month` = $pd_create_month";
    $row = $conn->prepare($sql);
    $row->execute();
}

//BOM互動視窗單筆BOM刪除
function del_data_bom_controller()
{
    global $conn;
    global $today;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };
    $sql = "UPDATE product 
    SET pd_create_user = '$login_user',`pd_status`= 2
    WHERE product_bom = '$product_bom' ";
    $row = $conn->prepare($sql);
    $row->execute();
    echo json_encode(array("data" => "", "status" => '200', "message" => "刪除成功"));
}

//單筆BOM材料刪除
function del_data_bom_material_controller()
{
    global $conn;
    global $today;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "UPDATE `product` 
            SET `pd_create_user` = '$login_user',`pd_status`= 2
            WHERE `material_num` = '$material_num' AND `product_bom` = '$product_bom' AND `pd_create_year` = $pd_create_year AND `pd_create_month` = $pd_create_month";
    $row = $conn->prepare($sql);
    $row->execute();
    echo json_encode(array("data" => "", "status" => '200', "message" => "刪除成功"));
}

//單筆材料刪除
function del_data_material_controller()
{

    global $conn;
    global $today;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "UPDATE `material` 
            SET `mt_create_user` = '$login_user',`mt_status`= 2
            WHERE `Row_id` = $Row_id";
    $row = $conn->prepare($sql);
    $row->execute();
}
//查詢BOM單筆資料
function sel_single_bom_material_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT `material_num`, `material_useage` , `product_bom`
            FROM `product`
            WHERE `material_num` = $material_num AND `product_bom` = '$product_bom' AND `pd_status` = 1 AND `pd_create_year` = $pd_create_year AND `pd_create_month` = $pd_create_month";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}

//修改BOM材料
function edit_single_data_bom_material_controller()
{
    global $conn;

    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };
    $sql = "UPDATE `product` 
            SET `material_useage` = $material_useage
            WHERE `material_num` = $material_num AND `product_bom` = '$product_bom' AND  `pd_status` = 1 AND `pd_create_year` = $pd_create_year AND `pd_create_month` = $pd_create_month";

    $row = $conn->prepare($sql);

    $row->execute();
    echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
}
//查詢材料單筆資料
function sel_single_material_controller()
{

    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT `Row_id`, `mt_create_year`, `mt_create_month`, `mt_num`, `mt_cost` 
            FROM `material`
            WHERE `Row_id` = $Row_id AND  `mt_status` = 1";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}

//修改材料
function edit_single_data_material_controller()
{
    global $conn;
    global $today;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };
    $sql = "UPDATE `material` 
            SET `mt_cost` = $mt_cost
            WHERE `Row_id` = $Row_id";

    $row = $conn->prepare($sql);

    $row->execute();
    echo json_encode(array("data" => "", "status" => '200', "message" => "成功"));
}

//檢查是否已續上月資料
function check_readd(){
    global $conn;
    global $today;
    global $Year;
    global $M;

    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $sql = "SELECT `mt_create_year`, `mt_create_month` 
            FROM `material` 
            WHERE `mt_create_year` = $Year AND `mt_create_month` = $M";
    
    $row = $conn -> query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

//續上月材料資料
function re_add_material_controller()
{
    global $conn;
    global $today;
    global $Year;
    global $M;

    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };

    $chk = check_readd();
    if(empty($chk)){
        $sql = "SELECT * FROM `material` WHERE 1";

        $row = $conn->query($sql);
        $result = $row->fetchAll(PDO::FETCH_ASSOC);

        $len = count($result);

        for ($i = 0; $i < $len; $i++) {
            $mt_num = strval($result[$i]['mt_num']);
            $mt_cost = $result[$i]['mt_cost'];
            $sql_re = "INSERT INTO `material`(`mt_create_year`, `mt_create_month`, `mt_num`,   `mt_cost`, `mt_create_user`, `mt_create_time`, `mt_status`) 
                                    VALUES (   $Year,               $M,             '$mt_num',  $mt_cost, '$login_user',    '$today',           1)";

            $row_re = $conn->prepare($sql_re);

            $row_re->execute();
        }
        echo json_encode(array("data" => "", "status" => '200', "message" => "成功")); 
    }else{
        echo json_encode(array("data" => "", "status" => '404', "message" => "當月已上傳過。"));
    };     
            
};


$OpType();

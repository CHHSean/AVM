<?php
include('../DB.php');

foreach ($_REQUEST as $key => $val) {
    $$key = $val;
};

function login_login_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    }
    $sql = "SELECT `Row_id`, `company`, `account`, `password`, `name`, `email` FROM `user` WHERE `account` = '$account'  AND `password` = '$psd'";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_OBJ);
    $num = count($result);
    // echo $num;
    if ($num != 0) {
        echo json_encode(array("data" => $result, "status" => '200', "message" => "成功登入"));
    } else {
        echo json_encode(array("data" => $result, "status" => '404', "message" => "帳號或密碼錯誤，請重新輸入。"));
    };
};

//註冊
function register_login_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    }
    $sql = "SELECT `Row_id`, `company`, `account`, `password`, `name`, email FROM user WHERE account = '$account'  OR email = '$email' ";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_OBJ);
    $num = count($result);
    // echo $num;
    if ($num == 0) {
        $sql = "INSERT INTO `user`(`company`,`account`, `password`, `name`, `email`) 
                       VALUES (?        ,?        ,?          ,?      ,?)";
        $row = $conn->prepare($sql);
        $row->execute(array($company, $account, $psd, $name, $email));

        $sql = "SELECT * FROM `user` WHERE `account` = '$account' AND `password` = '$psd'";
        $row = $conn->query($sql);
        $result = $row->fetchAll(PDO::FETCH_OBJ);
        $num = count($result);
        if ($num != 0) {
            echo json_encode(array("data" => $result, "status" => '200', "message" => "成功註冊"));
        } else {
            echo json_encode(array("data" => $result, "status" => '404', "message" => "註冊失敗。"));
        };
    } else {
        echo json_encode(array("data" => $result, "status" => '404', "message" => "帳號或信箱，已註冊過。"));
    };
}

//設定公司
function setting_company_login_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    }
    $sql = "INSERT INTO `company`(`company_name`) 
                          VALUES (?              )";
    $row = $conn->prepare($sql);
    $row->execute(array($company_name));

    $sql = "SELECT * FROM `company` ORDER BY Row_id DESC LIMIT 0 , 1";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_OBJ);
    $num = count($result);
    if ($num != 0) {
        echo json_encode(array("data" => $result, "status" => '200', "message" => "成功。"));
    };
}

//註冊公司下拉選單
function sel_company_login_controller()
{
    global $conn;
    $sql = 'SELECT `Row_id`, `company_name` FROM `company`';
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
};

// 忘記密碼
function company_forgot_psd_controller()
{
    global $conn;
    foreach ($_REQUEST as $key => $val) {
        global $$key;
    };
    $sql = "SELECT `Row_id`, `company`, `account`, `password`, `name`, `email` FROM `user` WHERE `account` = '$account' AND `email` = '$email'";
    $row = $conn->query($sql);
    $result = $row->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode($result);
    $num = count($result);
    // echo $num;
    if ($num == 1) {
        $sql = "";
        $result = '';
        // echo $num;
        $sql = "UPDATE `user` 
                    SET `password`=?
                    WHERE 
                            `account`=?
                        AND `email`=?";
        // echo $sql;
        $row = $conn->prepare($sql);
        $result = $row->execute(array($psd_checked, $account, $email));
        // print_r($result);
        echo json_encode(array("data" => $result, "status" => '200', "message" => "密碼修改成功"));
    } else {
        echo json_encode(array("data" => $result, "status" => '404', "message" => "帳號或信箱輸入錯誤，請重新輸入。"));
    }
};

// function register_login_controller()
// {
//     global $conn;
//     foreach($_REQUEST as $key => $val){
//         global $$key;
//     }
//     $sql = "INSERT INTO `user`(`account`, `password`, `name`, `email`) 
//                        VALUES (?        ,?          ,?      ,?)";
//     $row = $conn->prepare($sql);
//     foreach($accounts as $key => $account){
//         $result=$row->execute(array($account,$passwords[$key],$name[$key],$email[$key]));
//         if($result){
//             echo true;
//         }else{
//             echo false;
//             exit;
//         }
//     }
// }
$OpType();

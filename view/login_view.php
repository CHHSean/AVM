<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../src/link_management.php'); ?>
    <?php include('../view/modal_share_view.php'); ?>
    <link href="../src/floating-labels.css" rel="stylesheet">
    <title>登入</title>
</head>

<body>
    <div class="form-signin">
        <div class="text-center mb-4">
            <img class="mb-4" src="../picture/AVM_logo_name.png" alt="AVM智慧製造微型即時系統" width="220">
            <h1 class="h3 mb-3 font-weight-bold" style="font-size: 28px">AVM智慧製造微型即時系統</h1>
            <span class="d-block text-muted" style="font-size: 18px;"></span>
        </div>

        <div class="input-group mb-3">
            <input type="text" id="account" class="form-control" style="height: 50px; font-size: 18px" placeholder="account">
        </div>

        <div class="input-group mb-3">
            <input type="password" id="psd" class="form-control" style="height: 50px; font-size: 18px" placeholder="Password">
        </div>

        <!-- <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="remember" value="remember-me"> Remember me
            </label>
            <p style="float: right;"> <a href="../register_view.php">加入會員</a></p>
        </div> -->

        <button class="btn btn-outline-primary btn-block" onclick="btn_uphold()">登入</button>
        <button class="btn btn-outline-info btn-block" id="forget" onclick="btn_forgot()">忘記密碼</button>
        <button class="btn btn-outline-info btn-block" id="register">註冊</button>
        <p class="mt-5 mb-3 text-muted text-center">©系統開發與維護 <a href="http://www.avm.nccu.edu.tw/" target="_blank;">整合性策略價值管理研究中心</a> </p>
    </div>
</body>

</html>

<script>
    //登入
    function btn_uphold() {
        var account = $('#account').val();
        var psd = $('#psd').val();
        data = {
            account: account,
            psd: psd,
            OpType: 'login_login_controller'
        };
        // console.log(data);
        if (account == '' || psd == '') {
            $('#err_modal').modal('show', $('#err_msg').html('帳號或密碼尚未輸入'));
        } else {
            uphold(data);
        };
    };

    // create session js
    function login_session(account) {
        if (account != "") {
            document.cookie = "user=" + account;
            // +";expire="
        }
    }

    // php get user-> if(isset($_COOKIE["user"])){$login_user = $_COOKIE["user"];}

    /* 
      //print all cookie name
      
      cookieArray = document.cookie.split(";");
      for (var i = 0; i < cookieArray.length; i++) {
        thisCookie = cookieArray[i].split("=");
        var userName = unescape(thisCookie[0]);
        
      }
     
     */

    function uphold(data) {
        $.ajax({
            url: '../controller/login_controller.php',
            data: data,
            dataType: 'json',
            type: 'POST',
        }).done(function(res) {
            if (res.status == '200') {
                $('#success_modal').modal('show', $('#suc_msg').html(res.message));
                // console.log(res.data[0].account);
                login_session(res.data[0].account);
                $('#suc_btn').click(function() {
                    window.location.href = "../view/nav_view.php";
                });
            } else {
                $('#err_modal').modal('show', $('#err_msg').html(res.message));
            }
            // 回傳帳號 res-> account
        }).fail(function(error) {
            console.log(error);
        });
    };

    //註冊
    $('#register').click(function() {
        window.location.href = "../view/register_view.php";
    });

    //忘記密碼
    function btn_forgot() {
        window.location.href = "../view/forgot_view.php";
    }
</script>
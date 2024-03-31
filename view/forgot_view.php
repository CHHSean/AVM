<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../src/link_management.php'); ?>
    <?php include('../view/modal_share_view.php'); ?>
    <title>忘記密碼</title>
</head>

<body style="background-color: #f4f4f4;">
    <?php include('../view/button_share_view.php'); ?>
    <div style="width:100%;">
        <div class="container" style="width: 25rem;margin-top:10vh;border:0.05px solid #ededed;border-radius:10px;padding:30px 25px;font-size:16px;background-color:white; z-index:2;box-shadow: 3px 3px #ededed;">
            <form class="align-items-center">
                <label for="form_test" class="form_title" style="color:#636363">忘記密碼</label>
                <hr>
                <div class="form-group">
                    <label for="account">帳號</label>
                    <input type="text" class="form-control" id="account" required>
                </div>
                <div class="form-group">
                    <label for="email">信箱</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="form-group">
                    <label for="psd">新密碼</label>
                    <input type="password" class="form-control" id="psd" required>
                </div>
                <div class="form-group">
                    <label for="psd">再輸入一次新密碼</label>
                    <input type="password" class="form-control" id="psd_checked" required>
                </div>
                <label for="match_error_msg" id="match_error_msg" style="color:white;font-size:12px;background-color:grey;padding:2px;">輸入的密碼不相同</label>
                <div class="form-group">
                    <button type="button" class="btn btn-outline-primary " id='uphold'>送出</button>
                </div>
            </form>
        </div>
        <div style="display:flex;">
            <div style="height: 150px;width: 150px;background-color: #dcf0f4;transform: rotate(45deg);"> </div>
            <div style="height: 150px;width: 150px;background-color: #dcf0f4;transform: rotate(45deg);  margin-left:82vw;"> </div>
        </div>
    </div>
</body>

</html>

<script>
    // 上一頁
    $('#btn_back').click(function() {
        window.location.href = "../view/login_view.php";
    });
    //hide button
    $('#btn_add').hide();
    $('#btn_sel').hide();
    $('#btn_mod').hide();
    $('#btn_del').hide();

    //忘記密碼
    $('#uphold').click(function() {
        var account = $('#account').val();
        var email = $('#email').val();
        var psd = $('#psd').val();
        var psd_checked = $('#psd_checked').val();
        data = {
            account: account,
            email: email,
            psd: psd,
            psd_checked: psd_checked,
            OpType: 'company_forgot_psd_controller'
        };
        if (account == '') {
            $('#err_modal').modal('show', $('#err_msg').html('帳號尚未填寫'));
        } else if (psd == '') {
            $('#err_modal').modal('show', $('#err_msg').html('密碼尚未填寫'));
        } else if (psd_checked == '') {
            $('#err_modal').modal('show', $('#err_msg').html('確任密碼尚未填寫'));
        } else if (email == '') {
            $('#err_modal').modal('show', $('#err_msg').html('信箱尚未填寫'));
        } else if (IsEmail(email) == false) {
            $('#err_modal').modal('show', $('#err_msg').html('信箱格式錯誤'));
        } else {
            forgot_psd(data);
        };
    });
    $('#match_error_msg').hide();
    //check密碼是否相同
    $('#psd_checked').change(function() {
        // console.log($('#psd_checked').val());
        // console.log($('#psd').val())
        if ($('#psd_checked').val() == $('#psd').val()) {
            $('#match_error_msg').hide();
        } else {
            $('#match_error_msg').show();
        }
    })

    //忘記密碼ajax
    function forgot_psd(data) {
        $.ajax({
            url: '../controller/login_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var str = JSON.parse(res);
            // console.log(str);
            if (str.status == '200') {
                $('#success_modal').modal('show', $('#suc_msg').html(str.message));
                $('#suc_btn').click(function() {
                    window.location.href = "../view/login_view.php";
                });
            } else {
                $('#err_modal').modal('show', $('#err_msg').html(str.message));
            }
        }).fail(function(error) {
            console.log(error);
        });
    };

    //驗證信箱
    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        };
    };
</script>
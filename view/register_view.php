<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../src/link_management.php'); ?>
    <?php include('../view/modal_share_view.php'); ?>
    <title>註冊</title>
</head>

<body style="background-color: #f4f4f4;">
    <?php include('../view/button_share_view.php'); ?>
    <div style="width:100%;">
        <div class="container" style="width: 25rem;margin-top:10vh;border:0.05px solid #ededed;border-radius:10px;padding:30px 25px;font-size:16px;background-color:white; z-index:2;box-shadow: 3px 3px #ededed;">
            <form class="align-items-center">
                <div class="form-group">
                    <label for="company">公司</label>
                    <!-- <input type="text" class="form-control" id="company"> -->
                    <select class="form-control" id="company"></select>
                </div>
                <div class="form-group">
                    <label for="account">帳號</label>
                    <input type="text" class="form-control" id="account">
                </div>
                <div class="form-group">
                    <label for="psd">密碼</label>
                    <input type="password" class="form-control" id="psd">
                </div>
                <div class="form-group">
                    <label for="name">姓名</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label for="email">信箱</label>
                    <input type="text" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-outline-primary " id='uphold'>送出</button>
                    <button type="button" class="btn btn-outline-primary " id='setting_company' style="margin-left:10px;">設定公司名稱</button>
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
    //公司
    $(async function() {
        var data = {
            OpType: 'sel_company_login_controller'
        };
        await $.ajax({
            url: '../controller/login_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
            // async: false,
        }).done(function(res) {
            var str = JSON.parse(res);
            var l = str.length;
            for (var i = 0; i < l; i++) {
                $("#company").append("<option value=" + str[i].Row_id + ">" + str[i].company_name + "</option>");
            }
        }).fail(function(error) {
            console.log(error);
        });
    });

    //送出
    $('#uphold').click(function() {
        var company = $('#company').val();
        var account = $('#account').val();
        var psd = $('#psd').val();
        var name = $('#name').val();
        var email = $('#email').val();
        data = {
            company: company,
            account: account,
            psd: psd,
            name: name,
            email: email,
            OpType: 'register_login_controller'
        };
        if (account == '') {
            $('#err_modal').modal('show', $('#err_msg').html('帳號尚未填寫'));
        } else if (psd == '') {
            $('#err_modal').modal('show', $('#err_msg').html('密碼尚未填寫'));
        } else if (name == '') {
            $('#err_modal').modal('show', $('#err_msg').html('姓名尚未填寫'));
        } else if (email == '') {
            $('#err_modal').modal('show', $('#err_msg').html('信箱尚未填寫'));
        } else if (IsEmail(email) == false) {
            $('#err_modal').modal('show', $('#err_msg').html('信箱格式錯誤'));
        } else {
            register(data);
        };
    });

    async function register(data) {
        await $.ajax({
            url: '../controller/login_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            var str = JSON.parse(res);
            // console.log(str);
            if (str.status == '200') {
                $('#success_modal').modal('show', $('#suc_msg').html(str.message));
                $('#suc_btn').click(function() {
                    window.location.href = "../view/login_view.php";
                });
            } else {
                // console.log(str.status);
                $('#err_modal').modal('show', $('#err_msg').html(str.message));
            };
        }).fail(function(error) {
            // console.log(error.status);
        })
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

    //設定公司
    $('#setting_company').click(function() {
        window.location.href = "../view/company_view.php";
    });
</script>
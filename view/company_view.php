<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../src/link_management.php'); ?>
    <?php include('../view/modal_share_view.php'); ?>
    <title>設定公司名稱</title>
</head>

<body style="background-color: #f4f4f4;">
    <?php include('../view/button_share_view.php'); ?>
    <div class="container">
        <div class="card align-items-center" style="width: 25rem;margin: 10vh auto; padding:30px 25px;border-radius:10px;box-shadow:3px 3px #ededed;">
            <form>
                <div class="form-group">
                    <label for="company">公司</label>
                    <input type="text" class="form-control" id="company_name" autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-outline-primary " id='uphold'>送出</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<script>
    // 上一頁
    $('#btn_back').click(function() {
        window.location.href = "../view/register_view.php";
    });
    //hide button
    $('#btn_add').hide();
    $('#btn_sel').hide();
    $('#btn_mod').hide();
    $('#btn_del').hide();
    //送出
    $('#uphold').click(function() {
        var company_name = $('#company_name').val();
        console.log(company_name);
        var data = {
            company_name: company_name,
            OpType: 'setting_company_login_controller'
        };
        if (company_name == '') {
            $('#err_modal').modal('show', $('#err_msg').html('公司名稱尚未填寫'));
        } else {
            setting_company(data)
        };
    });

    async function setting_company(data) {
        await $.ajax({
            url: '../controller/login_controller.php',
            data: data,
            dataType: 'json',
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            if (res.status == '200') {
                $('#success_modal').modal('show', $('#suc_msg').html(res.message));
                $('#suc_btn').click(function() {
                    window.location.href = "../view/register_view.php";
                });
            }
        }).fail(function(error) {
            console.log(error);
        });
    };
</script>
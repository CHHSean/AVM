<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../src/link_management.php'); ?>
    <?php include('../view/modal_share_view.php'); ?>
    <style>
        <?php include('../src/human_resource_cost.css'); ?>
    </style>
    <title>人事成本</title>
</head>

<body>
    <?php include('../view/button_share_view.php'); ?>
    <?php include('../view/left_bar_view.php'); ?>
    <div id="up_table">
        <h1 class="text_c">設定人事成本</h1>
        <hr class="text_line">
        <table id="config_table" class="table table-striped table-bordered table_w_h text_c">
            <thead>
                <tr>
                    <td scope="col">下載_範本</td>
                    <td scope="col" colspan="4">上傳_檔案</td>
                </tr>
            </thead>
            <tbody id="upload_row_btn">
                <!-- 人事成本 -->
                <tr>
                    <!-- 下載 -->
                    <th scope="row">
                        <button type="button" class="btn btn-outline-secondary" id="dow_excel">
                            人事成本
                        </button>
                        <!-- </a> -->
                    </th>
                    <!-- 上傳 -->
                    <td>
                        <label class="btn btn-outline-primary btn-block" for="file_1" aria-describedby="上傳檔案按鈕">上傳檔案 人事成本 </label>
                        <input type="file" name="file_1" class="d-none" id="file_1" onclick="choose_up_file(index=1)">
                        <span class="upload_csv">請上傳CSV檔</span>
                    </td>
                    <td>
                        <input type="input" id="ChooseFileName_1" class="form-control" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-info btn-block" onclick="btn_confirm(index=1)">確認</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-dark btn-block" onclick="btn_clear_file(index=1)">清除</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- 單筆新增資料 -->
    <div id="add_table">
        <h2 id="text_add_cost" class="text_c">單筆新增 人事成本</h2>
        <hr class="text_add_cost_line">
        <form class="add-form">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="em_year">年</label>
                    <input type="text" class="form-control" id="em_year">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_month">月</label>
                    <input type="text" class="form-control" id="em_month">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_id">員工編號</label>
                    <input type="text" class="form-control" id="em_id">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_name">姓名</label>
                    <input type="text" class="form-control" id="em_name">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_sex">性別</label>
                    <input type="text" class="form-control" id="em_sex">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_age">年齡</label>
                    <input type="text" class="form-control" id="em_age">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_job_name">作業名稱</label>
                    <input type="text" class="form-control" id="em_job_name">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_work_hour">工時</label>
                    <input type="text" class="form-control" id="em_work_hour">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="em_salary">薪資</label>
                    <input type="text" class="form-control" id="em_salary">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_labor_insurance">勞健保</label>
                    <input type="text" class="form-control" id="em_labor_insurance">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_labor_refund">勞退金</label>
                    <input type="text" class="form-control" id="em_labor_refund">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_ey">年終</label>
                    <input type="text" class="form-control" id="em_ey">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_perform_bonus">績效獎金</label>
                    <input type="text" class="form-control" id="em_perform_bonus">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_split_bill">應分攤費用</label>
                    <input type="text" class="form-control" id="em_split_bill">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_use_machine">操作的機械</label>
                    <input type="text" class="form-control" id="em_use_machine" value="0">
                </div>
                <div class="form-group col-md-6">
                    <!-- <label for="mc_parts_cost"></label>
                    <input type="text" class="form-control" id="mc_parts_cost"> -->
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="em_other_cost1">其他費用1</label>
                    <input type="text" class="form-control" id="em_other_cost1" value="0">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_other_cost2">其他費用2</label>
                    <input type="text" class="form-control" id="em_other_cost2" value="0">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_other_cost3">其他費用3</label>
                    <input type="text" class="form-control" id="em_other_cost3" value="0">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_other_cost4">其他費用4</label>
                    <input type="text" class="form-control" id="em_other_cost4" value="0">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_other_cost5">其他費用5</label>
                    <input type="text" class="form-control" id="em_other_cost5" value="0">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_total_expense">總費用</label>
                    <input type="text" class="form-control" id="em_total_expense">
                </div>
                <div class="form-group col-md-6">
                    <label for="em_min_rate">每分鐘費率</label>
                    <input type="text" class="form-control" id="em_min_rate">
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="single_btn">確認</button>
        </form>
    </div>
    <!-- 查詢資料 -->
    <div id="bgc_page">
        <div id="table_sheet">
            <h2 id="text_search" class="text_c">人事成本</h2>
            <hr class="text_search_line">
            <div id="top-selector">
                <label id="text_year">年&nbsp;</label>
                <select class="selectpicker" name="sel_year" id="sel_year" aria-label="Default select example"> </select>
                &nbsp;&nbsp;
                <label id="text_month">月份&nbsp;</label>
                <select class="selectpicker" name="sel_month" id="sel_month" aria-label="Default select example"> </select>
                <button class="btn btn-primary" id="search" onclick="get_selected()">搜尋</button>
            </div>
            <table id="mat_table" class="hover cell-border">
                <thead class="thead_search">
                    <tr class="th_search">
                        <th>序</th>
                        <th>年</th>
                        <th>月</th>
                        <th>編號</th>
                        <th>姓名</th>
                        <th>性別</th>
                        <th>年鹷</th>
                        <th>作業名稱</th>
                        <th>工時</th>
                        <th>薪資</th>
                        <th>勞健保</th>
                        <th>勞退金</th>
                        <th>年終</th>
                        <th>績效奬金</th>
                        <th>應分攤的費用</th>
                        <th>操作的機械</th>
                        <th>費用1</th>
                        <th>費用2</th>
                        <th>費用3</th>
                        <th>費用4</th>
                        <th>費用5</th>
                        <th>總費用</th>
                        <th>每分鐘員工費率</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="th_search_details"></tbody>
            </table>
        </div>
    </div>
<!-- 修改互動視窗 -->
<div class="modal fade bd-mod-table-modal-xl" tabindex="-1" role="dialog" id="edit_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">修改</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="add_table" class="container">
                    <h2 id="modify_text" class="text_c">修改 人事成本</h2>
                    <hr id="modify_line">
                    <form class="modify-form justify-content-center align-items-center">
                        <input type="hidden" id="edit_Row_id" readonly>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_em_year">年</label>
                                <input type="text" class="form-control" id="edit_em_year">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_em_month">月</label>
                                <input type="text" class="form-control" id="edit_em_month">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_em_id">員工編號</label>
                                <input type="text" class="form-control" id="edit_em_id">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_em_name">姓名</label>
                                <input type="text" class="form-control" id="edit_em_name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_em_sex">性別</label>
                                <input type="text" class="form-control" id="edit_em_sex">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_em_age">年齡</label>
                                <input type="text" class="form-control" id="edit_em_age">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_em_job_name">作業名稱</label>
                                <input type="text" class="form-control" id="edit_em_job_name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_em_work_hour">工時</label>
                                <input type="text" class="form-control" id="edit_em_work_hour">
                            </div>
                        </div>
                        <div id="form-calculation">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="edit_em_salary">薪資</label>
                                    <input type="text" class="form-control" id="edit_em_salary">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_em_labor_insurance">勞健保</label>
                                    <input type="text" class="form-control" id="edit_em_labor_insurance">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="edit_em_labor_refund">勞退金</label>
                                    <input type="text" class="form-control" id="edit_em_labor_refund">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_em_ey">年終</label>
                                    <input type="text" class="form-control" id="edit_em_ey">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="edit_em_perform_bonus">績效獎金</label>
                                    <input type="text" class="form-control" id="edit_em_perform_bonus">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_em_split_bill">應分攤費用</label>
                                    <input type="text" class="form-control" id="edit_em_split_bill">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="edit_em_use_machine">操作的機械</label>
                                    <input type="text" class="form-control" id="edit_em_use_machine">
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- <label for=""></label>
                                    <input type="text" class="form-control" id=""> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="edit_em_other_cost1">其他費用1</label>
                                    <input type="text" class="form-control" id="edit_em_other_cost1">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_em_other_cost2">其他費用2</label>
                                    <input type="text" class="form-control" id="edit_em_other_cost2">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="edit_em_other_cost3">其他費用3</label>
                                    <input type="text" class="form-control" id="edit_em_other_cost3">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_em_other_cost4">其他費用4</label>
                                    <input type="text" class="form-control" id="edit_em_other_cost4">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="edit_em_other_cost5">其他費用5</label>
                                    <input type="text" class="form-control" id="edit_em_other_cost5">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_em_total_expense">總費用</label>
                                <input type="text" class="form-control" id="edit_em_total_expense" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_em_min_rate">每分鐘費率</label>
                                <input type="text" class="form-control" id="edit_em_min_rate" readonly>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id='btn_edit_uphold'>確認</button>
            </div>
        </div>
    </div>
</div>
<!-- -------------------------------- -->
</body>
</html>

<script>
    // 上一頁
    $('#btn_back').click(function() {
        window.location.href = "../view/nav_view.php";
    });
    $('#btn_add').hide();
    $('#btn_sel').hide();
    $('#btn_mod').hide();
    $('#mod_btn').hide();
    $('#btn_del').hide();
    $("#add_btn").hover(function() {
        $("#add_btn").css("background-color", "#8e8e8e");
        $("#add_btn").css("color", "white");
    }, function() {
        $("#add_btn").css("background-color", "white");
        $("#add_btn").css("color", "#3a3a3a");
    });
    $("#upload_btn").hover(function() {
        $("#upload_btn").css("background-color", "#8e8e8e");
        $("#upload_btn").css("color", "white");
    }, function() {
        $("#upload_btn").css("background-color", "white");
        $("#upload_btn").css("color", "#3a3a3a");
    });
    $("#search_btn").hover(function() {
        $("#search_btn").css("background-color", "#8e8e8e");
        $("#search_btn").css("color", "white");
    }, function() {
        $("#search_btn").css("background-color", "white");
        $("#search_btn").css("color", "#3a3a3a");
    });
    // $("#mod_btn").hover(function() {
    //     $("#mod_btn").css("background-color", "#8e8e8e");
    //     $("#mod_btn").css("color", "white");
    // }, function() {
    //     $("#mod_btn").css("background-color", "white");
    //     $("#mod_btn").css("color", "#3a3a3a");
    // });
    $('#up_table').show();
    $('#add_table').hide();
    $('#table_sheet').hide();
    $('#table_sheet2').hide();
    $('#upload_btn').click(function() {
        $('#up_table').show();
        $('#add_table').hide();
        $('#table_sheet').hide();
        $('#table_sheet2').hide();
    });
    $('#add_btn').click(function() {
        $('#add_table').show();
        $('#up_table').hide();
        $('#table_sheet').hide();
        $('#table_sheet2').hide();
    });
    $('#search_btn').click(function() {
        $('#add_table').hide();
        $('#up_table').hide();
        $('#table_sheet').show();
        $('#table_sheet2').hide();
    });
    // $('#mod_btn').click(function() {
    //     $('#add_table').hide();
    //     $('#up_table').hide();
    //     $('#table_sheet').hide();
    //     $('#table_sheet2').show();
    // });

    // ------------------------------------------------------
    // 下載人事成本EXCEL
    $('#dow_excel').click(function() {
        fun_dow_excel();
    })

    function fun_dow_excel() {
        $.ajax({
            url: '../controller/human_resource_cost_controller.php',
            data: {
                'OpType': 'dow_excel'
            },
            dataType: 'text',
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            // var obj = JSON.parse(res);
            // console.log(obj);
            window.location.href = "../file/human_cost.xlsx";
        }).fail(function(error) {
            console.log(error);
        });
    }
    // ------------------------------------------------------
    var file_1;
    var formdata_1 = new FormData();
    var chgindex;

    function choose_up_file(index) {
        chgindex = index;
    };
    var file_name = [
        'human_cost.csv'
    ];

    $('#upload_row_btn').on('change', 'input[type="file"]', function() {
        file = $(this).prop('files')[0];
        switch (chgindex) {
            case 1:
                formdata_1.append('excel', file);
                break;
        }
        // console.log(file.name);
        // console.log(chgindex);
        $('#ChooseFileName_' + chgindex).val(file.name);
        //判斷檔名及副檔名，是否正確
        if (file_name[chgindex - 1] != file.name) {
            alert('檔名或副檔名錯誤，請下載範本作使用。');
            btn_clear_file(chgindex);
        };
    });
    //------------------------------------------------
    //按鈕確認傳到control，存資料庫
    function btn_confirm(index) {
        switch (index) {
            case 1:
                formdata_1.append('OpType', 'up_file_dow_control');
                formdata_1.append('login_user', "<?= $login_user ?>");
                formdata_ajax(formdata_1, index);
                break;
            default:
                break;
        };
    };

    async function formdata_ajax(formdata, index) {
        await $.ajax({
            url: '../controller/human_resource_cost_controller.php',
            data: formdata,
            // dataType: 'text',
            type: 'POST',
            processData: false,
            contentType: false,
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            if (obj.status == '200') {
                $('#success_modal').modal('show', $('#suc_msg').html(obj.message));
            } else if (obj.status == '404') {
                $('#err_modal').modal('show', $('#err_msg').html(obj.message));
            };
            // console.log(index);
            btn_clear_file(index);
        }).fail(function(error) {
            console.log(error);
        });
    };
    //------------------------------------------------
    //清除檔案、清除名字
    function btn_clear_file(index) {
        $('input[name="file_' + index + '"]').val('');
        $('#ChooseFileName_' + index).val('');
    };
    //清除單筆新增
    function clear_single_data() {
        $('#em_year').val('');
        $('#em_month').val('');
        $('#em_id').val('');
        $('#em_name').val('');
        $('#em_sex').val('');
        $('#em_age').val('');
        $('#em_job_name').val('');
        $('#em_work_hour').val('');
        $('#em_salary').val('');
        $('#em_labor_insurance').val('');
        $('#em_labor_refund').val('');
        $('#em_ey').val('');
        $('#em_perform_bonus').val('');
        $('#em_split_bill').val('');
        $('#em_use_machine').val('');
        $('#em_other_cost1').val('');
        $('#em_other_cost2').val('');
        $('#em_other_cost3').val('');
        $('#em_other_cost4').val('');
        $('#em_other_cost5').val('');
        $('#em_total_expense').val('');
        $('#em_min_rate').val('');
    }
    //------------------------------------------------
    function add_table_data() {
        var data = {
            em_year: $('#em_year').val(),
            em_month: $('#em_month').val(),
            em_id: $('#em_id').val(),
            em_name: $('#em_name').val(),
            em_sex: $('#em_sex').val(),
            em_age: $('#em_age').val(),
            em_job_name: $('#em_job_name').val(),
            em_work_hour: $('#em_work_hour').val(),
            em_salary: $('#em_salary').val(),
            em_labor_insurance: $('#em_labor_insurance').val(),
            em_labor_refund: $('#em_labor_refund').val(),
            em_ey: $('#em_ey').val(),
            em_perform_bonus: $('#em_perform_bonus').val(),
            em_split_bill: $('#em_split_bill').val(),
            em_use_machine: $('#em_use_machine').val(),
            em_other_cost1: $('#em_other_cost1').val(),
            em_other_cost2: $('#em_other_cost2').val(),
            em_other_cost3: $('#em_other_cost3').val(),
            em_other_cost4: $('#em_other_cost4').val(),
            em_other_cost5: $('#em_other_cost5').val(),
            em_total_expense: $('#em_total_expense').val(),
            em_min_rate: $('#em_min_rate').val(),
            login_user: "<?= $login_user ?>",
            OpType: ''
        };
        return data;
    };
    //單筆新增
    async function add_single_data(data) {
        var data = add_table_data();
        data['OpType'] = 'add_single_data_controller';
        await $.ajax({
            url: '../controller/human_resource_cost_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            if (obj.status == '200') {
                $('#success_modal').modal('show', $('#suc_msg').html(obj.message));
                clear_single_data();
            };
        }).fail(function(error) {
            console.log(error);
        });
    };
    //檢查是否當月已新增過人事成本
    async function chk_human_resource_num() {
        var data = add_table_data();
        data['OpType'] = 'chk_human_resource_num_controller';
        await $.ajax({
            url: '../controller/human_resource_cost_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            if (obj.status == '200') {
                add_single_data(data);
            } else if (obj.status == '404') {
                $('#err_modal').modal('show', $('#err_msg').html(obj.message));
            };
        }).fail(function(error) {
            console.log(error);
        });
    };
    // 新增、檢查
    $('#single_btn').click(function() {
        chk_human_resource_num();
    });
    //------------------------------------------------
    //查詢資料
    $('#search_btn').click(function() {
        var d = new Date();
        var month = d.getMonth()+1;
        var year = d.getFullYear() - 1911;
        clear_ym();
        sel_year();
        sel_data_human_resource_cost_controller(year,month);
    });

    function get_selected(){
        var y = $('#sel_year').val();
        var m = $('#sel_month').val();
        sel_data_human_resource_cost_controller(y,m);
    }

    function sel_data_human_resource_cost_controller(em_Y,em_M) {
        var data = {
            em_year: em_Y,
            em_month: em_M,
            OpType: 'sel_data_human_resource_cost_controller',
        };
        $.ajax({
            url: '../controller/human_resource_cost_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            data_mat_table("#mat_table", obj, {
                    deferRender: true,
                    scrollCollapse: true,
                    scroller: false,
                    info: false,
                    ordering: false,
                    etrieve: true,
                    paging: false,
                    destroy: true,
                    bLengthChange: false,
                    searching: true
                },
                [{
                    'targets': 23,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) {
                        return "<input type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='.bd-mod-table-modal-xl' value = '修改' onclick='edit($(this))'> ";
                    }
                }, {
                    'targets': 24,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) {
                        return "<input type='button' class='btn btn-outline-danger' value = '刪除' onclick='del($(this))'> ";
                    }
                }],
                [{
                        "data": "Row_id"
                    },
                    {
                        "data": "em_year"
                    },
                    {
                        "data": "em_month"
                    },
                    {
                        "data": "em_id"
                    },
                    {
                        "data": "em_name"
                    },
                    {
                        "data": "em_sex"
                    },
                    {
                        "data": "em_age"
                    },
                    {
                        "data": "em_job_name"
                    },
                    {
                        "data": "em_work_hour"
                    },
                    {
                        "data": "em_salary"
                    },
                    {
                        "data": "em_labor_insurance"
                    },
                    {
                        "data": "em_labor_refund"
                    },
                    {
                        "data": "em_ey"
                    },
                    {
                        "data": "em_perform_bonus"
                    },
                    {
                        "data": "em_split_bill"
                    },
                    {
                        "data": "em_use_machine"
                    },
                    {
                        "data": "em_other_cost1"
                    },
                    {
                        "data": "em_other_cost2"
                    },
                    {
                        "data": "em_other_cost3"
                    },
                    {
                        "data": "em_other_cost4"
                    },
                    {
                        "data": "em_other_cost5"
                    },
                    {
                        "data": "em_total_expense"
                    },
                    {
                        "data": "em_min_rate"
                    }
                ])
        });
    };
    //------------------------------------------------
    //刪除
    function del(t, x = 0) {
        var Row_id = t.parent().parent().find('td:eq(' + x + ')').text();
        var data = {
            Row_id: Row_id,
            login_user: "<?= $login_user ?>",
            OpType: 'del_data_human_resource_cost_controller',
        };
        // console.log(data);
        $.ajax({
            url: '../controller/human_resource_cost_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var em_M =  $("#sel_month").val();
            var em_Y =  $("#sel_year").val();
            sel_data_human_resource_cost_controller(em_Y,em_M); 
        }).fail(function(error) {
            console.log(error);
        });
    };

    //------------------------------------------------
    //修改 單筆查詢互動視窗
    async function edit(t, x = 0) {
        var Row_id = t.parent().parent().find('td:eq(' + x + ')').text();
        var data = {
            Row_id: Row_id,
            OpType: 'sel_single_human_resource_cost_controller',
        };
        // console.log(data);
        await $.ajax({
            url: '../controller/human_resource_cost_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            $('#edit_modal').modal('show');

            $("#form-calculation input").bind('keyup', function() {
                var total = 0;
                $("#form-calculation input").each(function() {
                    if (!isNaN(parseInt($(this).val()))) {
                        total += parseInt($(this).val());
                    }
                });
                if ($("#edit_em_work_hour").val() == '') {
                    $('#edit_em_total_expense').val(0);
                }
                $('#edit_em_total_expense').val(total);
                $('#edit_em_min_rate').val(total / parseInt($("#edit_em_work_hour").val()));
            });
            $('#edit_Row_id').val(obj[0].Row_id);
            $('#edit_em_year').val(obj[0].em_year);
            $('#edit_em_month').val(obj[0].em_month);
            $('#edit_em_id').val(obj[0].em_id);
            $('#edit_em_name').val(obj[0].em_name);
            $('#edit_em_sex').val(obj[0].em_sex);
            $('#edit_em_age').val(obj[0].em_age);
            $('#edit_em_job_name').val(obj[0].em_job_name);
            $('#edit_em_work_hour').val(obj[0].em_work_hour);
            $('#edit_em_salary').val(obj[0].em_salary);
            $('#edit_em_labor_insurance').val(obj[0].em_labor_insurance);
            $('#edit_em_labor_refund').val(obj[0].em_labor_refund);
            $('#edit_em_ey').val(obj[0].em_ey);
            $('#edit_em_perform_bonus').val(obj[0].em_perform_bonus);
            $('#edit_em_split_bill').val(obj[0].em_split_bill);
            $('#edit_em_use_machine').val(obj[0].em_use_machine);
            $('#edit_em_other_cost1').val(obj[0].em_other_cost1);
            $('#edit_em_other_cost2').val(obj[0].em_other_cost2);
            $('#edit_em_other_cost3').val(obj[0].em_other_cost3);
            $('#edit_em_other_cost4').val(obj[0].em_other_cost4);
            $('#edit_em_other_cost5').val(obj[0].em_other_cost5);
            $('#edit_em_total_expense').val(obj[0].em_total_expense);
            $('#edit_em_min_rate').val(obj[0].em_min_rate);
        }).fail(function(error) {
            console.log(error);
        });
    };
    // 確認 單筆修改
    $('#btn_edit_uphold').click(function() {
        var Row_id = $('#edit_Row_id').val();
        var em_year = $('#edit_em_year').val();
        var em_month = $('#edit_em_month').val();
        var em_id = $('#edit_em_id').val();
        var em_name = $('#edit_em_name').val();
        var em_sex = $('#edit_em_sex').val();
        var em_age = $('#edit_em_age').val();
        var em_job_name = $('#edit_em_job_name').val();
        var em_work_hour = $('#edit_em_work_hour').val();
        var em_salary = $('#edit_em_salary').val();
        var em_labor_insurance = $('#edit_em_labor_insurance').val();
        var em_labor_refund = $('#edit_em_labor_refund').val();
        var em_ey = $('#edit_em_ey').val();
        var em_perform_bonus = $('#edit_em_perform_bonus').val();
        var em_split_bill = $('#edit_em_split_bill').val();
        var em_use_machine = $('#edit_em_use_machine').val();
        var em_other_cost1 = $('#edit_em_other_cost1').val();
        var em_other_cost2 = $('#edit_em_other_cost2').val();
        var em_other_cost3 = $('#edit_em_other_cost3').val();
        var em_other_cost4 = $('#edit_em_other_cost4').val();
        var em_other_cost5 = $('#edit_em_other_cost5').val();
        var em_total_expense = $('#edit_em_total_expense').val();
        var em_min_rate = $('#edit_em_min_rate').val();

        var data = {
            Row_id: Row_id,
            em_year: em_year,
            em_month: em_month,
            em_id: em_id,
            em_name: em_name,
            em_sex: em_sex,
            em_age: em_age,
            em_job_name: em_job_name,
            em_work_hour: em_work_hour,
            em_salary: em_salary,
            em_labor_insurance: em_labor_insurance,
            em_labor_refund: em_labor_refund,
            em_ey: em_ey,
            em_perform_bonus: em_perform_bonus,
            em_split_bill: em_split_bill,
            em_use_machine: em_use_machine,
            em_other_cost1: em_other_cost1,
            em_other_cost2: em_other_cost2,
            em_other_cost3: em_other_cost3,
            em_other_cost4: em_other_cost4,
            em_other_cost5: em_other_cost5,
            em_total_expense: em_total_expense,
            em_min_rate: em_min_rate,
            login_user: "<?= $login_user ?>",
            OpType: 'edit_single_data_human_resource_cost_controller',
        };
        // console.log(data);
        if (em_year == '') {
            $('#err_modal').modal('show', $('#err_msg').html('年尚未填寫'));
        } else if (em_month == '') {
            $('#err_modal').modal('show', $('#err_msg').html('月尚未填寫'));
        } else if (em_id == '') {
            $('#err_modal').modal('show', $('#err_msg').html('員工編號尚未填寫'));
        } else if (em_name == '') {
            $('#err_modal').modal('show', $('#err_msg').html('姓名 尚未填寫'));
        } else if (em_sex == '') {
            $('#err_modal').modal('show', $('#err_msg').html('性別 尚未填寫'));
        } else if (em_work_hour == '') {
            $('#err_modal').modal('show', $('#err_msg').html('工時 尚未填寫'));
        } else if (em_salary == '') {
            $('#err_modal').modal('show', $('#err_msg').html('薪資 尚未填寫'));
        } else if (em_labor_insurance == '') {
            $('#err_modal').modal('show', $('#err_msg').html('勞健保 尚未填寫'));
        } else if (em_labor_refund == '') {
            $('#err_modal').modal('show', $('#err_msg').html('勞退金 尚未填寫'));
        } else if (em_ey == '') {
            $('#err_modal').modal('show', $('#err_msg').html('年終 尚未填寫'));
        } else if (em_perform_bonus == '') {
            $('#err_modal').modal('show', $('#err_msg').html('績效獎金 尚未填寫'));
        } else if (em_split_bill == '') {
            $('#err_modal').modal('show', $('#err_msg').html('應分攤費用 尚未填寫'));
        } else if (em_use_machine == '') {
            $('#err_modal').modal('show', $('#err_msg').html('操作的機械 尚未填寫'));
        } else if (em_other_cost1 == '') {
            $('#err_modal').modal('show', $('#err_msg').html('其他費用1尚未填寫'));
        } else if (em_other_cost2 == '') {
            $('#err_modal').modal('show', $('#err_msg').html('其他費用2尚未填寫'));
        } else if (em_other_cost3 == '') {
            $('#err_modal').modal('show', $('#err_msg').html('其他費用3尚未填寫'));
        } else if (em_other_cost4 == '') {
            $('#err_modal').modal('show', $('#err_msg').html('其他費用4尚未填寫'));
        } else if (em_other_cost5 == '') {
            $('#err_modal').modal('show', $('#err_msg').html('其他費用5尚未填寫'));
        } else {
            edit_single_data(data);
        };
    });

    async function edit_single_data(data) {
        await $.ajax({
            url: '../controller/human_resource_cost_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj)
            $('#success_modal').modal('show', $('#suc_msg').html(obj.message));
            var em_M =  $("#sel_month").val();
            var em_Y =  $("#sel_year").val();
            sel_data_human_resource_cost_controller(em_Y,em_M);
        }).fail(function(error) {
            console.log(error);
        });
    };

    //月下拉式選單
    async function sel_month() {
       var em_year = $('#sel_year').val();
       var data = {
           em_year : em_year,
           OpType: 'sel_month_controller'
       };
       await $.ajax({
           url: '../controller/human_resource_cost_controller.php',
           data: data,
           dataType: 'text',
           type: 'POST',
           // async: false,
       }).done(function(res) {
           var str = JSON.parse(res);
           var l = str.length;
           for (var i = 0; i < l; i++) {
               $("#sel_month").append("<option value=" + str[i].em_month + ">"+str[i].em_month+ "</option>");
           }
           var em_M =  $("#sel_month").val();
           var em_Y =  $("#sel_year").val();
           sel_data_human_resource_cost_controller(em_Y,em_M);    
       }).fail(function(error) {
           console.log(error);
       });
    };    

    //年下拉式選單
    async function sel_year() {
        var data = {
            OpType: 'sel_year_controller'
        };
        await $.ajax({
            url: '../controller/human_resource_cost_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
            // async: false,
        }).done(function(res) {
            var str = JSON.parse(res);
            var l = str.length;
            for (var i = 0; i < l; i++) {
                $("#sel_year").append("<option value=" + str[i].em_year + ">"+str[i].em_year+ "</option>");
            };
            sel_month();
        }).fail(function(error) {
            console.log(error);
        });
    };

    //清空年月選單
    function clear_ym(){
        var sel_year = document.getElementById("sel_year");
            sel_year.innerHTML = "";
        var sel_month = document.getElementById("sel_month");
            sel_month.innerHTML = "";

        for(var i=0;i<sel_year.childNodes.length;i++){
            sel_year.removeChild(sel_year.options[0]);
            sel_year.remove(0);
            sel_year.options[0] = null;
        };

        for(var i=0;i<sel_month.childNodes.length;i++){
            sel_month.removeChild(sel_month.options[0]);
            sel_month.remove(0);
            sel_month.options[0] = null;
        };
    };    
</script>

<style>
    .table_w_h {
        width: 300;
        height: 80;
    }

    .text_c {
        text-align: center;
    }
</style>
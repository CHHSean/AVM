<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../src/link_management.php'); ?>
    <?php include('../view/modal_share_view.php'); ?>
    <style>
        <?php include('../src/machine_cost_view.css'); ?>
    </style>
    <title>機器成本</title>
</head>

<body>
    <?php include('../view/button_share_view.php'); ?>
    <?php include('../view/left_bar_view.php'); ?>
    
    <div id="up_table">
        <h1 class="text_c">設定機器成本</h1>
        <hr class="text_line">
        <table id="config_table" class="table table-striped table-bordered table_w_h text_c">
            <thead>
                <tr>
                    <td scope="col">下載_範本</td>
                    <td scope="col" colspan="4">上傳_檔案</td>
                </tr>
            </thead>
            <tbody id="upload_row_btn">
                <!-- 材料成本 -->
                <tr>
                    <!-- 下載 -->
                    <th scope="row">
                        <!-- <a href="../file/report.xlsx" download="report.xlsx"> -->
                        <button type="button" class="btn btn-outline-secondary" id="dow_excel">
                            機器成本
                        </button>
                        <!-- </a> -->
                    </th>
                    <!-- 上傳 -->
                    <td>
                        <label class="btn btn-outline-primary btn-block" for="file_1" aria-describedby="上傳檔案按鈕">上傳檔案 機器成本 </label>
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
        <h2 id="text_add_cost" class="text_c">單筆新增 機器成本</h2>
        <hr class="text_add_cost_line">
        <form class="add-form">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="mc_start_year">年</label>
                    <input type="text" class="form-control" id="mc_start_year">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_start_month">月</label>
                    <input type="text" class="form-control" id="mc_start_month">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_id">機器編號</label>
                    <input type="text" class="form-control" id="mc_id">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_name">機器名稱</label>
                    <input type="text" class="form-control" id="mc_name">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_brand">機器廠牌</label>
                    <input type="text" class="form-control" id="mc_brand">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_buy_year">機器購買年份</label>
                    <input type="text" class="form-control" id="mc_buy_year">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_estimated_use_min">機器預計使用分鐘（每月）</label>
                    <input type="text" class="form-control" id="mc_estimated_use_min">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="mc_dep_expense">機器折舊費用（每月）</label>
                    <input type="text" class="form-control" id="mc_dep_expense">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_water_cost">機器水費（每月）</label>
                    <input type="text" class="form-control" id="mc_water_cost">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_electricity_cost">機器電費（每月）</label>
                    <input type="text" class="form-control" id="mc_electricity_cost">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_fuel_cost">機器燃油費（每月）</label>
                    <input type="text" class="form-control" id="mc_fuel_cost">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_maintenance_cost">機器保養費（每月）</label>
                    <input type="text" class="form-control" id="mc_maintenance_cost">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_upkeep_cost">機器維修費（每月）</label>
                    <input type="text" class="form-control" id="mc_upkeep_cost">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_rental_expense">機器場地費（每月）</label>
                    <input type="text" class="form-control" id="mc_rental_expense">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_parts_cost">機器零件費（每月）</label>
                    <input type="text" class="form-control" id="mc_parts_cost">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="mc_other_cost1">其他費用1</label>
                    <input type="text" class="form-control" id="mc_other_cost1">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_other_cost2">其他費用2</label>
                    <input type="text" class="form-control" id="mc_other_cost2">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_other_cost3">其他費用3</label>
                    <input type="text" class="form-control" id="mc_other_cost3">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_other_cost4">其他費用4</label>
                    <input type="text" class="form-control" id="mc_other_cost4">
                </div>
                <div class="form-group col-md-6">
                    <label for="mc_other_cost5">其他費用5</label>
                    <input type="text" class="form-control" id="mc_other_cost5">
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="single_btn">確認</button>
        </form>
    </div>
    <!-- 查詢資料 -->
    <div id="bgc_page">
        <div id="table_sheet">
            <h2 id="text_search" class="text_c">機器成本</h2>
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
                <!-- margin-top:40px;margin-left:-235px; -->
                <thead class="thead_search">
                    <tr class="th_search">
                        <th colspan="2"></th>
                        <th colspan="4" class="machine-top">機器</th>
                        <th colspan="9" class="line-top" >每月</th>
                        <th colspan="5" class="line-top">其它費用</th>
                        <th colspan="4"></th>
                    </tr>
                    <tr class="th_search_details">
                        <th>編號</th>
                        <th>年-月</th>
                        <!-- 機器--------------------------- -->
                        <th class="line-top">編號</th>
                        <th>名稱</th>
                        <th>廠牌</th>
                        <th>年份</th>
                        <!-- 每月--------------------------- -->
                        <th class="line-top">預計使用分鐘</th>
                        <th>折舊費用</th>
                        <th>水費</th>
                        <th>電費</th>
                        <th>燃油費</th>
                        <th>保養費</th>
                        <th>維修費</th>
                        <th>場地費</th>
                        <th>零件費</th>
                        <!-- 其它費用--------------------------- -->
                        <th class="line-top">費1</th>
                        <th>費2</th>
                        <th>費3</th>
                        <th>費4</th>
                        <th>費5</th>
                        <!-- --------------------------- -->
                        <th class="line-top">總費用</th>
                        <th>每分鐘費率</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="th_search_details"></tbody>
            </table>
        </div>
    </div>
</body>
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
                    <h2 id="modify_text" class="text_c">修改 機器成本</h2>
                    <hr id="modify_line">
                    <form class="modify-form justify-content-center align-items-center">
                        <input type="hidden" id="edit_mc_Row_id" readonly>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="mc_start_year">年</label>
                                <input type="text" class="form-control" id="edit_mc_start_year">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mc_start_month">月</label>
                                <input type="text" class="form-control" id="edit_mc_start_month">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="mc_id">機器編號</label>
                                <input type="text" class="form-control" id="edit_mc_id">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mc_name">機器名稱</label>
                                <input type="text" class="form-control" id="edit_mc_name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="mc_brand">機器廠牌</label>
                                <input type="text" class="form-control" id="edit_mc_brand">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mc_buy_year">機器購買年份</label>
                                <input type="text" class="form-control" id="edit_mc_buy_year">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="mc_estimated_use_min">機器預計使用分鐘（每月）</label>
                                <input type="text" class="form-control" id="edit_mc_estimated_use_min">
                            </div>
                            <div class="form-group col-md-6">
                                <!-- <label for=""></label> -->
                                <!-- <input type="text" class="form-control" id=""> -->
                            </div>
                        </div>
                        <div id="form-calculation">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="mc_dep_expense">機器折舊費用（每月）</label>
                                    <input type="text" class="form-control" id="edit_mc_dep_expense">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="mc_water_cost">機器水費（每月）</label>
                                    <input type="text" class="form-control" id="edit_mc_water_cost">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="mc_electricity_cost">機器電費（每月）</label>
                                    <input type="text" class="form-control" id="edit_mc_electricity_cost">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="mc_fuel_cost">機器燃油費（每月）</label>
                                    <input type="text" class="form-control" id="edit_mc_fuel_cost">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="mc_maintenance_cost">機器保養費（每月）</label>
                                    <input type="text" class="form-control" id="edit_mc_maintenance_cost">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="mc_upkeep_cost">機器維修費（每月）</label>
                                    <input type="text" class="form-control" id="edit_mc_upkeep_cost">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="mc_rental_expense">機器場地費（每月）</label>
                                    <input type="text" class="form-control" id="edit_mc_rental_expense">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="mc_parts_cost">機器零件費（每月）</label>
                                    <input type="text" class="form-control" id="edit_mc_parts_cost">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="mc_other_cost1">其他費用1</label>
                                    <input type="text" class="form-control" id="edit_mc_other_cost1">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="mc_other_cost2">其他費用2</label>
                                    <input type="text" class="form-control" id="edit_mc_other_cost2">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="mc_other_cost3">其他費用3</label>
                                    <input type="text" class="form-control" id="edit_mc_other_cost3">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="mc_other_cost4">其他費用4</label>
                                    <input type="text" class="form-control" id="edit_mc_other_cost4">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="mc_other_cost5">其他費用5</label>
                                    <input type="text" class="form-control" id="edit_mc_other_cost5">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="mc_total_expense">總費用</label>
                                <input type="text" class="form-control" id="edit_mc_total_expense" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="mc_min_rate">每分鐘機器費率</label>
                                <input type="text" class="form-control" id="edit_mc_min_rate" readonly>
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
    $('#dow_excel').click(function() {
        // data = {
        //     "Machines": [
        //         "{\"Machine_No\": \"#01\", \"Machine_Name\": \"303沖壓(40T)\"}",
        //         "{\"Machine_No\": \"#02\", \"Machine_Name\": \"301沖壓(40T)\"}",
        //         "{\"Machine_No\": \"#03\", \"Machine_Name\": \"302沖壓(40T)\"}",
        //         "{\"Machine_No\": \"#04\", \"Machine_Name\": \"102沖壓(80T)\"}",
        //         "{\"Machine_No\": \"#05\", \"Machine_Name\": \"101沖壓(80T)\"}",
        //         "{\"Machine_No\": \"#06\", \"Machine_Name\": \"103沖壓(80T)\"}",
        //         "{\"Machine_No\": \"#07\", \"Machine_Name\": \"106沖壓(80T)\"}",
        //         "{\"Machine_No\": \"#08\", \"Machine_Name\": \"105沖壓(80T)\"}",
        //         "{\"Machine_No\": \"#09\", \"Machine_Name\": \"104沖壓(80T)\"}",
        //         "{\"Machine_No\": \"#10\", \"Machine_Name\": \"508沖壓(100T)\"}",
        //         "{\"Machine_No\": \"#11\", \"Machine_Name\": \"507沖壓(100T)\"}",
        //         "{\"Machine_No\": \"#12\", \"Machine_Name\": \"506沖壓(100T)\"}",
        //         "{\"Machine_No\": \"#13\", \"Machine_Name\": \"504沖壓(100T)\"}",
        //         "{\"Machine_No\": \"#14\", \"Machine_Name\": \"503沖壓(100T)\"}",
        //         "{\"Machine_No\": \"#15\", \"Machine_Name\": \"501沖壓(100T)\"}",
        //         "{\"Machine_No\": \"#16\", \"Machine_Name\": \"201工牙機(單軸)\"}",
        //         "{\"Machine_No\": \"#17\", \"Machine_Name\": \"200工牙機(單軸)\"}",
        //         "{\"Machine_No\": \"#18\", \"Machine_Name\": \"203工牙機(雙軸)\"}",
        //         "{\"Machine_No\": \"#19\", \"Machine_Name\": \"202工牙機(雙軸)\"}",
        //         "{\"Machine_No\": \"#20\", \"Machine_Name\": \"502沖壓(100T)\"}",
        //         "{\"Machine_No\": \"123\", \"Machine_Name\": \"sss\"}"
        //     ]
        // };
        // var len = data.Machines.length;
        // for (var i = 0; i < len; i++) {
        //     data.Machines[i]=JSON.parse(data.Machines[i]);
        // };
        // fun_dow_excel(data);

        var api = "http://192.168.1.140:9988/api/DaudinApi/GetMCMInfo";
        $.ajax({
            type: 'POST',
            url: api,
            dataType: 'text'
        }).done(function(res) {
            // console.log(JSON.parse(res));
            var data = JSON.parse(res)
            var len = data.Machines.length;
            // console.log(len);
            for (var i = 0; i < len; i++) {
                data.Machines[i] = JSON.parse(data.Machines[i]);
            };
            // console.log(data.Machines)
            fun_dow_excel(data);
        }).fail(function(error) {
            console.log(error);
        });
    })

    function fun_dow_excel(data) {
        $.ajax({
            url: '../controller/machine_cost_controller.php',
            data: {
                'OpType': 'dow_excel',
                'Machines': data.Machines
            },
            dataType: 'text',
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            // var obj = JSON.parse(res);
            // console.log(obj);
            window.location.href = "../file/report.xlsx";
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
        'report.csv'
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
            url: '../controller/machine_cost_controller.php',
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
        $('#mc_start_year').val('');
        $('#mc_start_month').val('');
        $('#mc_id').val('');
        $('#mc_name').val('');
        $('#mc_brand').val('');
        $('#mc_buy_year').val('');
        $('#mc_estimated_use_min').val('');
        $('#mc_dep_expense').val('');
        $('#mc_water_cost').val('');
        $('#mc_electricity_cost').val('');
        $('#mc_fuel_cost').val('');
        $('#mc_maintenance_cost').val('');
        $('#mc_upkeep_cost').val('');
        $('#mc_rental_expense').val('');
        $('#mc_parts_cost').val('');
        $('#mc_other_cost1').val('');
        $('#mc_other_cost2').val('');
        $('#mc_other_cost3').val('');
        $('#mc_other_cost4').val('');
        $('#mc_other_cost5').val('');
    }

    //------------------------------------------------
    function add_table_data() {
        var data = {
            mc_start_year: $('#mc_start_year').val(),
            mc_start_month: $('#mc_start_month').val(),
            mc_id: $('#mc_id').val(),
            mc_name: $('#mc_name').val(),
            mc_brand: $('#mc_brand').val(),
            mc_buy_year: $('#mc_buy_year').val(),
            mc_estimated_use_min: $('#mc_estimated_use_min').val(),
            mc_dep_expense: $('#mc_dep_expense').val(),
            mc_water_cost: $('#mc_water_cost').val(),
            mc_electricity_cost: $('#mc_electricity_cost').val(),
            mc_fuel_cost: $('#mc_fuel_cost').val(),
            mc_maintenance_cost: $('#mc_maintenance_cost').val(),
            mc_upkeep_cost: $('#mc_upkeep_cost').val(),
            mc_rental_expense: $('#mc_rental_expense').val(),
            mc_parts_cost: $('#mc_parts_cost').val(),
            mc_other_cost1: $('#mc_other_cost1').val(),
            mc_other_cost2: $('#mc_other_cost2').val(),
            mc_other_cost3: $('#mc_other_cost3').val(),
            mc_other_cost4: $('#mc_other_cost4').val(),
            mc_other_cost5: $('#mc_other_cost5').val(),
            login_user: "<?= $login_user ?>",
            OpType: ''
        };
        return data;
    }
    //單筆新增
    async function add_single_data(data) {
        var data = add_table_data();
        data['OpType'] = 'add_single_data_controller';
        await $.ajax({
            url: '../controller/machine_cost_controller.php',
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
    //檢查是否當月已新增過機器編號
    async function chk_Machine_num() {
        var data = add_table_data();
        data['OpType'] = 'chk_Machine_num_controller';
        await $.ajax({
            url: '../controller/machine_cost_controller.php',
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
    }
    // 新增、檢查
    $('#single_btn').click(function() {
        chk_Machine_num();
    });

    //------------------------------------------------
    //查詢資料
    $('#search_btn').click(function() {
        var d = new Date();
        var month = d.getMonth()+1;
        var year = d.getFullYear() - 1911;
        clear_ym();
        sel_year();
        sel_data_machine_cost_controller(year,month);
    });

    function get_selected(){
        var y = $('#sel_year').val();
        var m = $('#sel_month').val();
        sel_data_machine_cost_controller(y,m);
    }

    function sel_data_machine_cost_controller(mc_Y,mc_M) {
        var data = {
            mc_start_year: mc_Y,
            mc_start_month: mc_M,
            OpType: 'sel_data_machine_cost_controller',
        };
        $.ajax({
            url: '../controller/machine_cost_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            console.log(res);
            var obj = JSON.parse(res);
            console.log(obj);
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
            }, [{
                'targets': 1,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'data': 'YM',
                'render': function(data, type, full, meta) {
                    return data;
                }
            }, {
                'targets': 22,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    return "<input type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='.bd-mod-table-modal-xl' value = '修改' onclick='edit($(this))'> ";
                }
            }, {
                'targets': 23,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    return "<input type='button' class='btn btn-outline-danger' value = '刪除' onclick='del($(this))'> ";
                }
            }], [{
                    "data": "mc_Row_id"
                },
                null, //'data': 'YM'
                {
                    "data": "mc_id"
                },
                {
                    "data": "mc_name"
                },
                {
                    "data": "mc_brand"
                },
                {
                    "data": "mc_buy_year"
                },
                {
                    "data": "mc_estimated_use_min"
                },
                {
                    "data": "mc_dep_expense"
                },
                {
                    "data": "mc_water_cost"
                },
                {
                    "data": "mc_electricity_cost"
                },
                {
                    "data": "mc_fuel_cost"
                },
                {
                    "data": "mc_maintenance_cost"
                },
                {
                    "data": "mc_upkeep_cost"
                },
                {
                    "data": "mc_rental_expense"
                },
                {
                    "data": "mc_parts_cost"
                },
                {
                    "data": "mc_other_cost1"
                },
                {
                    "data": "mc_other_cost2"
                },
                {
                    "data": "mc_other_cost3"
                },
                {
                    "data": "mc_other_cost4"
                },
                {
                    "data": "mc_other_cost5"
                },
                {
                    "data": "mc_total_expense"
                },
                {
                    "data": "mc_min_rate"
                },
            ]);
        }).fail(function(error) {
            console.log(error);
        });
    };

    //------------------------------------------------
    //刪除
    function del(t, x = 0) {
        var Row_id = t.parent().parent().find('td:eq(' + x + ')').text();
        var data = {
            Row_id: Row_id,
            login_user: "<?= $login_user ?>",
            OpType: 'del_data_machine_cost_controller',
        };
        // console.log(data);
        $.ajax({
            url: '../controller/machine_cost_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var mc_M =  $("#sel_month").val();
            var mc_Y =  $("#sel_year").val();
            sel_data_machine_cost_controller(mc_Y,mc_M);  //不要重新導向
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
            OpType: 'sel_single_machine_cost_controller',
        };
        // console.log(data);
        await $.ajax({
            url: '../controller/machine_cost_controller.php',
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
                if ($("#edit_mc_estimated_use_min").val() == '') {
                    $('#edit_mc_total_expense').val(0);
                }
                $('#edit_mc_total_expense').val(total);
                $('#edit_mc_min_rate').val(total / parseInt($("#edit_mc_estimated_use_min").val()));
            });
            $('#edit_mc_Row_id').val(obj[0].mc_Row_id);
            // $('#edit_mc_serial_id').val(obj[0].mc_serial_id);
            $('#edit_mc_start_year').val(obj[0].mc_start_year);
            $('#edit_mc_start_month').val(obj[0].mc_start_month);
            // $('#edit_mc_start_day').val(obj[0].mc_start_day);
            // $('#edit_mc_start_time').val(obj[0].mc_start_time);
            // $('#edit_mc_end_year').val(obj[0].mc_end_year);
            // $('#edit_mc_end_month').val(obj[0].mc_end_month);
            // $('#edit_mc_end_day').val(obj[0].mc_end_day);
            // $('#edit_mc_end_time').val(obj[0].mc_end_time);
            $('#edit_mc_id').val(obj[0].mc_id);
            $('#edit_mc_name').val(obj[0].mc_name);
            $('#edit_mc_brand').val(obj[0].mc_brand);
            $('#edit_mc_buy_year').val(obj[0].mc_buy_year);
            // $('#edit_mc_job_name').val(obj[0].mc_job_name);
            $('#edit_mc_estimated_use_min').val(obj[0].mc_estimated_use_min);
            $('#edit_mc_dep_expense').val(obj[0].mc_dep_expense);
            $('#edit_mc_water_cost').val(obj[0].mc_water_cost);
            $('#edit_mc_electricity_cost').val(obj[0].mc_electricity_cost);
            $('#edit_mc_fuel_cost').val(obj[0].mc_fuel_cost);
            $('#edit_mc_maintenance_cost').val(obj[0].mc_maintenance_cost);
            $('#edit_mc_upkeep_cost').val(obj[0].mc_upkeep_cost);
            $('#edit_mc_rental_expense').val(obj[0].mc_rental_expense);
            $('#edit_mc_parts_cost').val(obj[0].mc_parts_cost);
            $('#edit_mc_other_cost1').val(obj[0].mc_other_cost1);
            $('#edit_mc_other_cost2').val(obj[0].mc_other_cost2);
            $('#edit_mc_other_cost3').val(obj[0].mc_other_cost3);
            $('#edit_mc_other_cost4').val(obj[0].mc_other_cost4);
            $('#edit_mc_other_cost5').val(obj[0].mc_other_cost5);
            $('#edit_mc_total_expense').val(obj[0].mc_total_expense);
            $('#edit_mc_min_rate').val(obj[0].mc_min_rate);
            // $('#edit_mc_note').val(obj[0].mc_note);
        }).fail(function(error) {
            console.log(error);
        });
    };
    // 確認 單筆修改
    $('#btn_edit_uphold').click(function() {
        var Row_id = $('#edit_mc_Row_id').val();
        var mc_start_year = $('#edit_mc_start_year').val();
        var mc_start_month = $('#edit_mc_start_month').val();
        // var mc_start_day = $('#edit_mc_start_day').val();
        // var mc_start_time = $('#edit_mc_start_time').val();
        // var mc_end_year = $('#edit_mc_end_year').val();
        // var mc_end_month = $('#edit_mc_end_month').val();
        // var mc_end_day = $('#edit_mc_end_day').val();
        // var mc_end_time = $('#edit_mc_end_time').val();
        var mc_id = $('#edit_mc_id').val();
        var mc_name = $('#edit_mc_name').val();
        var mc_brand = $('#edit_mc_brand').val();
        var mc_buy_year = $('#edit_mc_buy_year').val();
        // var mc_job_name = $('#edit_mc_job_name').val();
        var mc_estimated_use_min = $('#edit_mc_estimated_use_min').val();
        var mc_dep_expense = $('#edit_mc_dep_expense').val();
        var mc_water_cost = $('#edit_mc_water_cost').val();
        var mc_electricity_cost = $('#edit_mc_electricity_cost').val();
        var mc_fuel_cost = $('#edit_mc_fuel_cost').val();
        var mc_maintenance_cost = $('#edit_mc_maintenance_cost').val();
        var mc_upkeep_cost = $('#edit_mc_upkeep_cost').val();
        var mc_rental_expense = $('#edit_mc_rental_expense').val();
        var mc_parts_cost = $('#edit_mc_parts_cost').val();
        var mc_other_cost1 = $('#edit_mc_other_cost1').val();
        var mc_other_cost2 = $('#edit_mc_other_cost2').val();
        var mc_other_cost3 = $('#edit_mc_other_cost3').val();
        var mc_other_cost4 = $('#edit_mc_other_cost4').val();
        var mc_other_cost5 = $('#edit_mc_other_cost5').val();
        var mc_total_expense = $('#edit_mc_total_expense').val();
        var mc_min_rate = $('#edit_mc_min_rate').val();
        // var mc_note = $('#edit_mc_note').val();

        var data = {
            Row_id: Row_id,
            // mc_serial_id: mc_serial_id,
            mc_start_year: mc_start_year,
            mc_start_month: mc_start_month,
            // mc_start_day: mc_start_day,
            // mc_start_time: mc_start_time,
            // mc_end_year: mc_end_year,
            // mc_end_month: mc_end_month,
            // mc_end_day: mc_end_day,
            // mc_end_time: mc_end_time,
            mc_id: mc_id,
            mc_name: mc_name,
            mc_brand: mc_brand,
            mc_buy_year: mc_buy_year,
            // mc_job_name: mc_job_name,
            mc_estimated_use_min: mc_estimated_use_min,
            mc_dep_expense: mc_dep_expense,
            mc_water_cost: mc_water_cost,
            mc_electricity_cost: mc_electricity_cost,
            mc_fuel_cost: mc_fuel_cost,
            mc_maintenance_cost: mc_maintenance_cost,
            mc_upkeep_cost: mc_upkeep_cost,
            mc_rental_expense: mc_rental_expense,
            mc_parts_cost: mc_parts_cost,
            mc_other_cost1: mc_other_cost1,
            mc_other_cost2: mc_other_cost2,
            mc_other_cost3: mc_other_cost3,
            mc_other_cost4: mc_other_cost4,
            mc_other_cost5: mc_other_cost5,
            mc_total_expense: mc_total_expense,
            mc_min_rate: mc_min_rate,
            // mc_note: mc_note,
            login_user: "<?= $login_user ?>",
            OpType: 'edit_single_data_machine_cost_controller',
        };
        // console.log(data);
        if (mc_start_year == '') {
            $('#err_modal').modal('show', $('#err_msg').html('工單起始_年尚未填寫'));
        } else if (mc_start_month == '') {
            $('#err_modal').modal('show', $('#err_msg').html('工單起始_月尚未填寫'));
        } else if (mc_id == '') {
            $('#err_modal').modal('show', $('#err_msg').html('機器編號尚未填寫'));
        }
        // else if (mc_name == '') {
        //     $('#err_modal').modal('show', $('#err_msg').html('機器名稱尚未填寫'));
        // } 
        else if (mc_brand == '') {
            $('#err_modal').modal('show', $('#err_msg').html('機器廠牌尚未填寫'));
        } else if (mc_buy_year == '') {
            $('#err_modal').modal('show', $('#err_msg').html('購買年份尚未填寫'));
        } else if (mc_estimated_use_min == '') {
            $('#err_modal').modal('show', $('#err_msg').html('預計使用分鐘/每月 尚未填寫'));
        } else if (mc_dep_expense == '') {
            $('#err_modal').modal('show', $('#err_msg').html('折舊費/每月用尚未填寫'));
        } else if (mc_water_cost == '') {
            $('#err_modal').modal('show', $('#err_msg').html('水費/每月尚未填寫'));
        } else if (mc_electricity_cost == '') {
            $('#err_modal').modal('show', $('#err_msg').html('電費/每月尚未填寫'));
        } else if (mc_fuel_cost == '') {
            $('#err_modal').modal('show', $('#err_msg').html('燃油/每月費尚未填寫'));
        } else if (mc_maintenance_cost == '') {
            $('#err_modal').modal('show', $('#err_msg').html('保養費/每月保養費尚未填寫'));
        } else if (mc_upkeep_cost == '') {
            $('#err_modal').modal('show', $('#err_msg').html('維修費/每月尚未填寫'));
        } else if (mc_rental_expense == '') {
            $('#err_modal').modal('show', $('#err_msg').html('場地費/每月尚未填寫'));
        } else if (mc_parts_cost == '') {
            $('#err_modal').modal('show', $('#err_msg').html('零件費/每月尚未填寫'));
        } else if (mc_other_cost1 == '') {
            $('#err_modal').modal('show', $('#err_msg').html('其他費用1尚未填寫'));
        } else if (mc_other_cost2 == '') {
            $('#err_modal').modal('show', $('#err_msg').html('其他費用2尚未填寫'));
        } else if (mc_other_cost3 == '') {
            $('#err_modal').modal('show', $('#err_msg').html('其他費用3尚未填寫'));
        } else if (mc_other_cost4 == '') {
            $('#err_modal').modal('show', $('#err_msg').html('其他費用4尚未填寫'));
        } else if (mc_other_cost5 == '') {
            $('#err_modal').modal('show', $('#err_msg').html('其他費用5尚未填寫'));
        } else {
            edit_single_data(data);
        };
    });

    async function edit_single_data(data) {
        await $.ajax({
            url: '../controller/machine_cost_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj)
            $('#success_modal').modal('show', $('#suc_msg').html(obj.message));
            var mc_M =  $("#sel_month").val();
            var mc_Y =  $("#sel_year").val();
            sel_data_machine_cost_controller(mc_Y,mc_M);
        }).fail(function(error) {
            console.log(error);
        });
    };

    //月下拉式選單
    async function sel_month() {
       var mc_start_year = $('#sel_year').val();
       var data = {
           mc_start_year : mc_start_year,
           OpType: 'sel_month_controller'
       };
       await $.ajax({
           url: '../controller/machine_cost_controller.php',
           data: data,
           dataType: 'text',
           type: 'POST',
           // async: false,
       }).done(function(res) {
           var str = JSON.parse(res);
           var l = str.length;
           for (var i = 0; i < l; i++) {
               $("#sel_month").append("<option value=" + str[i].mc_start_month + ">"+str[i].mc_start_month+ "</option>");
           }
           var mc_M =  $("#sel_month").val();
           var mc_Y =  $("#sel_year").val();
           sel_data_machine_cost_controller(mc_Y,mc_M);    
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
            url: '../controller/machine_cost_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
            // async: false,
        }).done(function(res) {
            var str = JSON.parse(res);
            var l = str.length;
            for (var i = 0; i < l; i++) {
                $("#sel_year").append("<option value=" + str[i].mc_start_year + ">"+str[i].mc_start_year+ "</option>");
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
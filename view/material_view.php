<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../src/link_management.php'); ?>
    <?php include('../view/modal_share_view.php'); ?>
    <style>
        <?php include('../src/material_view.css'); ?>
    </style>
    <title>材料管理</title>
</head>

<body>
    <?php include('../view/button_share_view.php'); ?>
    <?php include('../view/left_bar_view.php'); ?>
    <div id="up_table">
        <h1 class="text_c">設定材料管理</h1>
        <hr class="text_line">
        <table id="config_table" class="table table-striped table-bordered table_w_h text_c">
            <thead>
                <tr>
                    <td scope="col">下載_範本</td>
                    <td scope="col" colspan="4">上傳_檔案</td>
                </tr>
            </thead>
            <tbody id="upload_row_btn_1">
                <!-- 材料管理 -->
                <tr>
                    <!-- 下載 -->
                    <th scope="row">
                        <!-- <a href="../file/report.xlsx" download="report.xlsx"> -->
                        <button type="button" class="btn btn-outline-secondary" id="dow_pd_excel">
                            材料主檔
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="dow_mt_excel">
                            材料副檔
                        </button>
                        <!-- </a> -->
                    </th>
                    <!-- 上傳 -->
                    <td>
                        <label class="btn btn-outline-primary btn-block" for="file_1" aria-describedby="上傳檔案按鈕">上傳檔案 材料</label>
                        <input type="file" name="file_1" class="d-none" id="file_1">
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
        <!-- <table id="config_table" class="table table-striped table-bordered table_w_h text_c">
            <thead>
                <tr>
                    <td scope="col">下載_範本</td>
                    <td scope="col" colspan="4">上傳_檔案</td>
                </tr>
            </thead>
            <tbody id="upload_row_btn_2">
                材料管理 -->
        <!-- <tr> -->
        <!-- 下載 -->
        <!-- <th scope="row">
                        <button type="button" class="btn btn-outline-secondary" id="dow_mt_excel">
                            材料副檔
                        </button> -->
        <!-- </a> -->
        <!-- </th> -->
        <!-- 上傳 -->
        <!-- <td>
                        <label class="btn btn-outline-primary btn-block" for="file_1" aria-describedby="上傳檔案按鈕">上傳檔案 材料副檔</label>
                        <input type="file" name="file_1" class="d-none" id="file_1" onclick="choose_up_file(index=2)">
                        <span class="upload_csv">請上傳CSV檔</span>
                    </td>
                    <td>
                        <input type="input" id="ChooseFileName_2" class="form-control" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-info btn-block" onclick="btn_confirm(index=2)">確認</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-dark btn-block" onclick="btn_clear_file(index=2)">清除</button>
                    </td>
                </tr>
            </tbody>
        </table> -->
    </div>
    <!-- 單筆新增資料 -->
    <div id="add_table">
        <div class="text-center">
            <button type="button" class="btn btn-outline-info" id="change_btn">新增材料成本</button>
        </div>
        <h2 id="text_add_cost" class="text_c">單筆新增 成品成本</h2>
        <hr class="text_add_cost_line">
        <form class="add-form">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="pd_create_year">年</label>
                    <input type="text" class="form-control" id="pd_create_year" readonly="readonly">
                </div>
                <div class="form-group col-md-6">
                    <label for="pd_create_month">月</label>
                    <select name="pd_create_month" class="custom-select">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="product_num">成品料號</label>
                    <input type="text" class="form-control" id="product_num">
                </div>
                <div class="form-group col-md-6">
                    <label for="product_name">成品名稱</label>
                    <input type="text" class="form-control" id="product_name">
                </div>
                <div class="form-group col-md-6">
                    <label for="product_bom">BOM區分碼</label>
                    <input type="text" class="form-control" id="product_bom">
                </div>
                <div class="form-group col-md-6">
                    <label for="material_num">材料料號</label>
                    <input type="text" class="form-control" id="material_num">
                </div>
                <div class="form-group col-md-6">
                    <label for="material_usage">材料用量</label>
                    <input type="text" class="form-control" id="material_useage">
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="single_pd_btn">確認</button>
        </form>
    </div>
    <div id="add_table_2">
        <div class="text-center">
            <button type="button" class="btn btn-outline-info" id="change_btn_2">新增成品成本</button>
        </div>
        <h2 id="text_add_cost" class="text_c">單筆新增 材料成本</h2>
        <hr class="text_add_cost_line">
        <form class="add-form">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="mt_create_year">年</label>
                    <input type="text" class="form-control" id="mt_create_year" readonly="readonly">
                </div>
                <div class="form-group col-md-6">
                    <label for="mt_create_month">月</label>
                    <select name="mt_create_month" class="custom-select">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="mt_num">材料料號</label>
                    <input type="text" class="form-control" id="mt_num">
                </div>
                <div class="form-group col-md-6">
                    <label for="mt_cost">材料單價</label>
                    <input type="text" class="form-control" id="mt_cost">
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="single_mt_btn">確認</button>
        </form>
    </div>

     <!-- 查詢資料 -->
     <div id="bgc_page">
        <div id="table_sheet">
            <div class="text-center">
                <button type="button" class="btn btn-outline-info" id="change_btn_search">查詢材料單價</button>
            </div>
            <h2 id="text_search" class="text_c">查詢 成品成本細項</h2>
            <div class="middle_sheet">
                <div id="top-selector">
                    <div id="middle_selector">
                        <label id="text_year">年&nbsp;</label>
                        <select class="selectpicker" name="sel_year" id="sel_pd_year" aria-label="Default select example"> </select>
                        &nbsp;&nbsp;
                        <label id="text_month">月份&nbsp;</label>
                        <select class="selectpicker" name="sel_month" id="sel_pd_month" aria-label="Default select example"> </select>
                        <!-- <button class="btn btn-primary" id="search" onclick="get_pd_selected()">搜尋</button> -->
                    </div>
                </div>
                <table id="mat_table" class="hover cell-border">
                    <thead class="thead_search">
                        <tr class="th_search">
                            <th></th>
                            <th></th>
                            <th>編號</th>
                            <th>年</th>
                            <th>月</th>
                            <th>成品料號</th>
                            <th>成品名稱</th>
                            <th>成品成本</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="th_search_details"></tbody>
                </table>
            </div>
        </div>
        <!-- <div id="table_sheet3">
            <h2 id="text_search" class="text_c">查詢 成品成本總覽</h2>
            <hr class="text_search_line">
            <table id="mat_table_2" class="hover cell-border">
                <thead class="thead_search">
                    <tr class="th_search">
                        <th>年</th>
                        <th>月</th>
                        <th>成品料號</th>
                        <th>成品名稱</th>
                        <th>BOM區分碼</th>
                        <th>單價成本</th>
                    </tr>
                </thead>
                <tbody class="th_search_details"></tbody>
            </table>
        </div>
    </div> -->
        <div id="bgc_page">
            <div id="table_sheet2">
                <div class="text-center">
                    <button type="button" class="btn btn-outline-info" id="change_btn_search_2">查詢成品成本</button>
                </div>
                <h2 id="text_search" class="text_c">查詢 材料單價</h2>
                <div class="middle_sheet">
                    <div id="top-selector">
                        <button id="match_last_month" class="btn btn-primary" style="margin-top:10px;float:right;">續上月資料</button>
                        <div id="middle_selector">
                            <label id="text_year">年&nbsp;</label>
                            <select class="selectpicker" name="sel_year" id="sel_mt_year" aria-label="Default select example"></select>
                            &nbsp;&nbsp;
                            <label id="text_month">月份&nbsp;</label>
                            <select class="selectpicker" name="sel_month" id="sel_mt_month" aria-label="Default select example"></select>
                            <button class="btn btn-primary" id="search" onclick="get_mt_selected()">搜尋</button>
                        </div>
                    </div>
                    <table id="mat_table_2" class="hover cell-border">
                        <thead class="thead_search">
                            <tr class="th_search">
                                <th>編號</th>
                                <th>年</th>
                                <th>月</th>
                                <th>材料料號</th>
                                <th>材料單價</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="th_search_details"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- 修改BOM互動視窗 -->
        <div class="modal fade bd-mod-table-modal-xl" tabindex="-1" role="dialog" id="edit_modal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">修改/刪除</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <h2 id="modify_text" class="text_c">修改/刪除 BOM 材料成本</h2>
                            <hr id="modify_line">
                            <br>
                            <h4>成品資料</h4>
                            <br>
                            <table class="hover cell-border" id="bom_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>編號</th>
                                        <th>年</th>
                                        <th>月</th>
                                        <th>成品料號</th>
                                        <th>成品名稱</th>
                                        <th>成品成本</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="display_Row_id"></td>
                                        <td id="display_pd_create_year"></td>
                                        <td id="display_pd_create_month"></td>
                                        <td id="display_product_num"></td>
                                        <td id="display_product_name"></td>
                                        <td id="display_total_cost"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <br>
                            <h4>BOM 詳細表格</h4>
                            <br>
                            <table id="example" class="hover row-border nowrap" width="50%" style="float:left;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="dt-center">BOM區分碼</th>
                                        <th class="dt-center">BOM成本</th>
                                        <th class="dt-center">材料料號</th>
                                        <th class="dt-center">材料成本</th>
                                        <th class="dt-center"></th>
                                        <th class="dt-center"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" id='btn_edit_cancel'>確認</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 材料互動視窗 -->
        <div class="modal fade bd-mod-table-modal-mt" tabindex="-1" role="dialog" id="edit_mt_modal" data-backdrop="static" data-keyboard="false">
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
                            <h2 id="modify_text" class="text_c">修改 材料成本</h2>
                            <hr id="modify_line">
                            <form class="modify-form justify-content-center align-items-center">
                                <input type="hidden" id="edit_mt_Row_id" readonly>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="edit_mt_num">料號</label>
                                        <input type="text" class="form-control" id="edit_mt_num" readonly="readonly">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="edit_mt_cost">單價</label>
                                        <input type="text" class="form-control" id="edit_mt_cost">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id='btn_edit_mt_uphold'>確認</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- BOM表材料互動視窗 -->
        <div class="modal fade bd-mod-table-modal-bom_mt" tabindex="-1" role="dialog" id="edit_bom_mt_modal" data-backdrop="static" data-keyboard="false">
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
                            <h2 id="modify_text" class="text_c">修改 BOM材料</h2>
                            <hr id="modify_line">
                            <form class="modify-form justify-content-center align-items-center">
                                <div class="form-row">
                                    <input type="hidden" id="edit_bom_product_bom" readonly>   
                                    <div class="form-group col-md-6">
                                        <label for="edit_bom_material_num">料號</label>
                                        <input type="text" class="form-control" id="edit_bom_material_num" readonly="readonly">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="edit_mt_useage">用量</label>
                                        <input type="text" class="form-control" id="edit_mt_useage">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id='btn_edit_bom_mt_uphold'>確認</button>
                    </div>
                </div>
            </div>
        </div>
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
    $('#add_table_2').hide();
    $('#table_sheet').hide();
    $('#table_sheet2').hide();
    // $('#table_sheet3').hide();
    // show_year(1);
    $('#upload_btn').click(function() {
        $('#up_table').show();
        $('#add_table').hide();
        $('#table_sheet').hide();
        $('#table_sheet2').hide();
        // $('#table_sheet3').hide();
        $('#add_table_2').hide();
    });
    $('#add_btn').click(function() {
        $('#add_table').show();
        $('#up_table').hide();
        $('#table_sheet').hide();
        $('#table_sheet2').hide();
        // $('#table_sheet3').hide();
        $('#add_table_2').hide();
    });
    $('#search_btn').click(function() {
        $('#add_table').hide();
        $('#up_table').hide();
        $('#table_sheet').show();
        $('#table_sheet2').hide();
        // $('#table_sheet3').show();
        $('#add_table_2').hide();
        // sel_pd_ym_controller();    
    });
    // $('#mod_btn').click(function() {
    //     $('#add_table').hide();
    //     $('#up_table').hide();
    //     $('#table_sheet').hide();
    //     $('#table_sheet2').show();
    // });
    $('#change_btn').click(function() {
        $('#up_table').hide();
        $('#add_table').hide();
        $('#table_sheet').hide();
        $('#table_sheet2').hide();
        // $('#table_sheet3').hide();
        $('#add_table_2').show();
    });
    $('#change_btn_2').click(function() {
        $('#up_table').hide();
        $('#add_table').show();
        $('#table_sheet').hide();
        $('#table_sheet2').hide();
        // $('#table_sheet3').hide();
        $('#add_table_2').hide();

    });

    $('#change_btn_search').click(function() {
        $('#up_table').hide();
        $('#add_table').hide();
        $('#table_sheet').hide();
        $('#table_sheet2').show();
        // $('#table_sheet3').hide();
        $('#add_table_2').hide();

    });
    $('#change_btn_search_2').click(function() {
        $('#up_table').hide();
        $('#add_table').hide();
        $('#table_sheet').show();
        $('#table_sheet2').hide();
        // $('#table_sheet3').show();
        $('#add_table_2').hide();
    });
    // ------------------------------------------------------
    $('#dow_pd_excel').click(function() {
        fun_dow_pd_excel();
    });




    // function show_year(pd_or_mt) {
    //     let date = new Date();
    //     let year = date.getFullYear();
    //     let month = parseInt(date.getMonth()) + 1;
    //     let normalized_year = (year - 1911);
    //     $('select#sel_'+pd_or_mt+'_year option[value="' + normalized_year + '"]').attr("selected", true);
    //     $('select#sel_'+pd_or_mt+'_month option[value="' + month + '"]').attr("selected", true);
    //     if(pd_or_mt==='mt'){
    //         $('#mat_table').DataTable().clear().draw();
    //         sel_data_material_controller(normalized_year,month);  
    //     }else{
    //         $('#mat_table2').DataTable().clear().draw();
    //         sel_data_product_controller(normalized_year,month);  
    //     }
    // }

    function fun_dow_pd_excel() {
        $.ajax({
            url: '../controller/material_controller.php',
            data: {
                'OpType': 'dow_pd_excel'
            },
            dataType: 'text',
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            // var obj = JSON.parse(res);
            // console.log(obj);
            window.location.href = "../file/product.xlsx";
        }).fail(function(error) {
            console.log(error);
        });
    };

    $('#dow_mt_excel').click(function() {
        fun_dow_mt_excel();
        // console.log("material is clicked");
    });

    function fun_dow_mt_excel() {
        $.ajax({
            url: '../controller/material_controller.php',
            data: {
                'OpType': 'dow_mt_excel'
            },
            dataType: 'text',
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            // var obj = JSON.parse(res);
            // console.log(obj);
            window.location.href = "../file/material.xlsx";
        }).fail(function(error) {
            console.log(error);
        });
    };

    // ------------------------------------------------------


    function check_filename(file) {

        var file_name = [
            'product.csv', 'material.csv'
        ];
        var len = file_name.length;
        var i;
        var chgindex;

        for (i = 0; i < len; i++) {
            if (file.name === file_name[i]) {
                chgindex = i + 1;
                $('#ChooseFileName_1').val(file.name);
                return true;
            }
        }

        btn_clear_file(chgindex);
        alert('檔名或副檔名錯誤，請下載範本作使用。');

        return false;

    }
    //清除檔案、清除名字
    function btn_clear_file() {
        $('input[name="file_1"]').val('');
        $('#ChooseFileName_1').val('');
    };

    var formdata_1 = new FormData();

    $('#upload_row_btn_1').on('change', 'input[type="file"]', function() {
        file = $(this).prop('files')[0];
        formdata_1.append('excel', file);
        let chgindex = check_filename(file);
        // console.log(file.name);
        // console.log(chgindex);

        // $('#ChooseFileName_' + chgindex).val(file.name);
        // //判斷檔名及副檔名，是否正確
        // if (file_name[chgindex - 1] != file.name) {
        //     // console.log(file_name[chgindex - 1]);
        //     alert('檔名或副檔名錯誤，請下載範本作使用。');
        //     btn_clear_file(chgindex);
        // };
    });

    //按鈕確認傳到control，存資料庫    
    // create two formdata
    function btn_confirm() {
        let index;
        let file_name = $('#ChooseFileName_1').val();
        if (file_name === 'product.csv') {
            index = 1;
        } else if (file_name === 'material.csv') {
            index = 2;
        }
        switch (index) {
            case 1:
                formdata_1.append('OpType', 'up_file_dow_pd_control');
                formdata_1.append('login_user', "<?= $login_user ?>");
                formdata_ajax(formdata_1);
                break;
            case 2:
                formdata_1.append('OpType', 'up_file_dow_mt_control');
                formdata_1.append('login_user', "<?= $login_user ?>");
                formdata_ajax(formdata_1);
                break;
            default:
                alert("請上傳有效檔案");
                break;
        };
    };

    async function formdata_ajax(formdata) {
        // console.log(formdata);
        await $.ajax({
            url: '../controller/material_controller.php',
            data: formdata,
            // dataType: 'text',
            type: 'POST',
            processData: false,
            contentType: false,
        }).done(function(res) {
            // console.log(res);
            // for (var key of formdata.keys()) {
            //     console.log(formdata.get(key));
            // }
            var obj = JSON.parse(res);
            console.log(obj);
            if (obj.status == '200') {
                $('#success_modal').modal('show', $('#suc_msg').html(obj.message));
            } else if (obj.status == '404') {
                $('#err_modal').modal('show', $('#err_msg').html('重複材料檔' + obj.data));
            };
            // console.log(index);
            btn_clear_file();
        }).fail(function(error) {
            console.log(error);
        });
    };
    
    //清除單筆新增
    function clear_pd_single_data() {
        $('#select[name=pd_create_month]').val('');
        $('#product_num').val();
        $('#product_name').val();
        $('#product_bom').val();
        $('#material_num').val();
        $('#material_useage').val();
    }

    function clear_mt_single_data() {
        $('#select[name=mt_create_month]').val('');
        $('#mt_num').val();
        $('#mt_cost').val();
    }

    //單筆新增
    async function add_pd_single_data(data) {
        var data = add_pd_table_data();
        data['OpType'] = 'add_pd_single_data_controller';
        // console.log(data);
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            console.log(obj);
            if (obj.status == '200') {
                $('#success_modal').modal('show', $('#suc_msg').html(obj.message));
                clear_pd_single_data();
            };
        }).fail(function(error) {
            console.log(error);
        });
    };

    async function add_mt_single_data(data) {
        var data = add_mt_table_data();
        data['OpType'] = 'add_mt_single_data_controller';
        // console.log(data);
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
        }).done(function(res) {
            console.log(res);
            var obj = JSON.parse(res);
            console.log(obj);
            if (obj.status == '200') {
                $('#success_modal').modal('show', $('#suc_msg').html(obj.message));
                clear_single_data();
            };
        }).fail(function(error) {
            console.log(error);
        });
    };

    function add_pd_table_data() {
        var pd_data = {
            pd_create_year: $('#pd_create_year').val(),
            pd_create_month: $('select[name=pd_create_month]').val(),
            product_num: $('#product_num').val(),
            product_name: $('#product_name').val(),
            product_bom: $('#product_bom').val(),
            material_num: $('#material_num').val(),
            material_useage: $('#material_useage').val(),
            login_user: "<?= $login_user ?>",
            OpType: ""
        };
        return pd_data;
    }

    function add_mt_table_data() {
        var mt_data = {
            mt_create_year: $('#mt_create_year').val(),
            mt_create_month: $('select[name=mt_create_month]').val(),
            mt_num: $('#mt_num').val(),
            mt_cost: $('#mt_cost').val(),
            login_user: "<?= $login_user ?>",
            OpType: ""
        };
        console.log(mt_data);
        return mt_data;
    }

    // 檢查是否當月已新增過此成品
    async function chk_pd_num() {
        var data = add_pd_table_data();
        data['OpType'] = 'chk_pd_num_controller';
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            if (obj.status == '200') {
                add_pd_single_data(data);
            } else if (obj.status == '404') {
                $('#err_modal').modal('show', $('#err_msg').html(obj.message));
            };
        }).fail(function(error) {
            console.log(error);
        });
    }
    
    //檢查是否當月已新增過此材料
    async function chk_mt_num() {
        var data = add_mt_table_data();
        data['OpType'] = 'chk_mt_num_controller';
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            if (obj.status == '200') {
                add_mt_single_data(data);
            } else if (obj.status == '404') {
                $('#err_modal').modal('show', $('#err_msg').html(obj.message));
            };
        }).fail(function(error) {
            console.log(error);
        });
    }



    // 新增、檢查
    $('#single_pd_btn').click(function() {
        chk_pd_num();
    });

    $('#single_mt_btn').click(function() {
        chk_mt_num();
    });


    //查詢資料
    $('#search_btn').click(function() {
        var d = new Date();
        var month = d.getMonth()+1;
        var year = d.getFullYear() - 1911;
        clear_pd_ym();
        pd_year();
        sel_data_product_controller(year,month);
    });

    function get_pd_selected(){
        var y = $('#sel_pd_year').val();
        var m = $('#sel_pd_month').val();
        sel_data_product_controller(y,m);
    }

    function get_mt_selected(){
        var y = $('#sel_mt_year').val();
        var m = $('#sel_mt_month').val();
        sel_data_material_controller(y,m);
    }


    $('#change_btn_search_2').click(function() {
        var d = new Date();
        var month = d.getMonth()+1;
        var year = d.getFullYear() - 1911;
        clear_pd_ym();  
        pd_year();
        sel_data_product_controller(year,month);
    });

    $('#change_btn_search').click(function() {
        var d = new Date();
        var month = d.getMonth()+1;
        var year = d.getFullYear() - 1911;
        clear_mt_ym();
        mt_year();
        sel_data_material_controller(year,month);
        
        
    });



    // //查詢成品年月
    // function  sel_pd_ym_controller(){
    //     data = {
    //         sql_year: pd_create_year,
    //         sql_month: pd_create_month,
    //         sql_status: pd_status,
    //         sql_table: 'product',        
    //         OpType: 'sel_year_controller',
    //     };
    //     $.ajax({
    //         url: '../controller/material_controller.php',
    //         data: data,
    //         dataType: "text",
    //         type: 'POST'
    //     }).done(function(res) {
    //         console.log(res);
    //         var obj = JSON.parse(res);
    //         console.log(obj);
    //         })
    // }

    // //查詢材料年月
    // function  sel_mt_ym_controller(){
    //     data = {
    //         sql_year: mt_create_year,
    //         sql_month: mt_create_month,
    //         sql_status: mt_status,
    //         sql_table: 'material',
    //         OpType: 'sel_ym_controller',
    //     };
    //     $.ajax({
    //         url: '../controller/material_controller.php',
    //         data: data,
    //         dataType: "text",
    //         type: 'POST'
    //     }).done(function(res) {
    //         console.log(res);
    //         var obj = JSON.parse(res);
    //         console.log(obj);
    //         })
    // }

    function sel_data_product_controller(pd_Y,pd_M) {
        data = {
            pd_create_year: pd_Y,
            pd_create_month: pd_M,
            OpType: 'sel_data_product_controller',
        };
        $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            console.log("成品",res);
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
                },
                [   {
                        'targets': 0,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-body-center',
                        "visible": false,
                        'data':"Row_id",
                        'render': function(data, type, full, meta) {
                            return "<input type='hidden' value="+data+"> ";
                        }
                    },
                    {
                        'targets': 1,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-body-center',
                        'render': function(data, type, full, meta) {
                            return "<input type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='.bd-mod-table-modal-xl' value = 'BOM查詢' onclick='edit_b($(this))'> ";
                        }
                    }
                    //     ,{
                    //     'targets': 6,
                    //     'searchable': false,
                    //     'orderable': false,
                    //     'className': 'dt-body-center',
                    //     'render': function(data, type, full, meta) {
                    //         return "<input type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='.bd-mod-table-modal-xl' value = '修改' onclick='edit($(this))'> ";
                    //     }
                    // }
                    ,
                    {
                        'targets': 8,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-body-center',
                        'render': function(data, type, full, meta) {
                            return "<input type='button' class='btn btn-outline-danger' value = '刪除' onclick='del_p($(this))'> ";
                        }
                    }
                ],
                [   
                    null,
                    null,
                    {
                        "data": "id"
                    },
                    {
                        "data": "pd_create_year"
                    },
                    {
                        "data": "pd_create_month"
                    },
                    {
                        "data": "product_num"
                    },
                    {
                        "data": "product_name"
                    },
                    {
                        "data": "total_cost"
                    },
                    // {
                    //     "data": "product_bom"
                    // },
                    // {
                    //     "data": "material_num"
                    // },
                    // {
                    //     "data": "material_useage"
                    // },
                ])
        });
    };

    //材料
    function sel_data_material_controller(mt_Y,mt_M) {
        var data = {
            mt_create_year: mt_Y,
            mt_create_month: mt_M,
            OpType: 'sel_data_material_controller',
        };
        $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            data_mat_table("#mat_table_2", obj, {
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
                    'targets': 5,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) {
                        return "<input type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='.bd-mod-table-modal-mt' value = '修改' onclick='edit($(this))'> ";
                    }
                }, {
                    'targets': 6,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) {
                        return "<input type='button' class='btn btn-outline-danger' value = '刪除' onclick='del_m($(this))'> ";
                    }
                }],
                [{
                        "data": "Row_id"
                    },
                    {
                        "data": "mt_create_year"
                    },
                    {
                        "data": "mt_create_month"
                    },
                    {
                        "data": "mt_num"
                    },
                    {
                        "data": "mt_cost"
                    },
                ])
        });
    };
    //update certain row (parent row)
    async function update_table(data) {
        
        var display_product_num;
        var pd_create_year;
        var pd_create_month;
        // console.log($("#bom_table").children("tbody").children("tr").find('td:eq(1)'));
        $('#example').show();
        display_product_num = data.display_product_num;
        pd_create_year = data.pd_create_year;
        pd_create_month = data.pd_create_month;            

        data = {
            display_product_num: display_product_num,
            pd_create_year: pd_create_year,
            pd_create_month: pd_create_month,
            OpType: 'sel_data_pdbom_controller',

        };
        console.log(data)
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            var obj = JSON.parse(res);
            var data_1 = [];

            data_1.push([
                Object.values(obj['data_1'][0])[0],
                Object.values(obj['data_1'][0])[1],
                Object.values(obj['data_1'][0])[2],
                Object.values(obj['data_1'][0])[3],
                Object.values(obj['data_1'][0])[4],
                Object.values(obj['data_1'][0])[5]
            ])
            var bomTable=$('#bom_table').DataTable();
            bomTable.cell({ row: 0, column: 5 }).data(data_1[0][5]).draw();
            var data_2 = [];
            var len = obj['data_2'].length;
            console.log(len);
            for (let i = 0; i < len; i++) {
                data_2.push([
                    // Object.values(obj['data_2'][i])[0],
                    Object.values(obj['data_2'][i])[0],
                    Object.values(obj['data_2'][i])[1]
                ])
            }
            console.log(data_2);

            var bom_details_table=$('#example').DataTable();

            for (let i = 0; i < data_2.length; i++) {
                bom_details_table.cell({row: i, column: 2}).data(data_2[i][1]);
            }
            // data_nest_table("#example", data_2);

        });
    };

    //查詢BOM
    async function edit_b(t, x = 4) {
        
        var display_product_num;
        var pd_create_year;
        var pd_create_month;
        // console.log($("#bom_table").children("tbody").children("tr").find('td:eq(1)'));
        $('#example').show();
        if(t!==null){
            display_product_num = t.parent().parent().find('td:eq(' + x + ')').text();
            pd_create_year = $('#sel_pd_year').val();
            pd_create_month = $('#sel_pd_month').val();            
        }else{
            // $('#example').DataTable().clear();
            // display_product_num = $("#bom_table");
            // pd_create_year = $('#sel_pd_year').val();
            // pd_create_month = $('#sel_pd_month').val();             
        }


        data = {
            display_product_num: display_product_num,
            pd_create_year: pd_create_year,
            pd_create_month: pd_create_month,
            OpType: 'sel_data_pdbom_controller',

        };
        console.log(data)
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            console.log(obj['data_1']);
            // console.log(obj['data_1'][0]);
            var data_1 = [];
            data_1.push([
                Object.values(obj['data_1'][0])[0],
                Object.values(obj['data_1'][0])[1],
                Object.values(obj['data_1'][0])[2],
                Object.values(obj['data_1'][0])[3],
                Object.values(obj['data_1'][0])[4],
                Object.values(obj['data_1'][0])[5]
            ])
            console.log(data_1);
            $('#bom_table').DataTable({
                data: data_1,
                deferRender: true,
                scrollCollapse: true,
                scroller: false,
                info: false,
                ordering: false,
                etrieve: true,
                paging: false,
                destroy: true,
                bLengthChange: false,
                searching: false,
                language: {
                    "processing": "處理中...",
                    "loadingRecords": "載入中...",
                    "lengthMenu": "顯示 _MENU_ 項",
                    "zeroRecords": "沒有符合",
                    "info": "顯示第 _START_ 至 _END_ 項，共 _TOTAL_ 項",
                    "infoEmpty": "顯示第 0 至 0 項，共 0 項",
                    "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                    "infoPostFix": "",
                    "search": "搜尋:",
                    "paginate": {
                        "first": "第一頁",
                        "previous": "上一頁",
                        "next": "下一頁",
                        "last": "最後一頁"
                    },
                    "aria": {
                        "sortAscending": ": 升冪排列",
                        "sortDescending": ": 降冪排列"
                    }
                },
            });
            var data_2 = [];
            var len = obj['data_2'].length;
            console.log(len);
            for (var i = 0; i < len; i++) {
                data_2.push([
                    // Object.values(obj['data_2'][i])[0],
                    Object.values(obj['data_2'][i])[0],
                    Object.values(obj['data_2'][i])[1]
                ])
            }
            console.log(data_2);
            data_nest_table("#example", data_2);

        });
    };

    //成品月下拉式選單
    async function pd_month() {
        var pd_create_year = $('#sel_pd_year').val();
        // console.log(pd_create_year);
        var data = {
            pd_create_year : pd_create_year,
            OpType: 'sel_pd_month_controller'
        };
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
            // async: false,
        }).done(function(res) {
            var str = JSON.parse(res);
            var l = str.length;
            console.log('year',res);
            for (var i = 0; i < l; i++) {
                $("#sel_pd_month").append("<option value=" + str[i].pd_create_month + ">"+str[i].pd_create_month+ "</option>");
            }
            var pd_M =  $("#sel_pd_month").val();
            var pd_Y =  $("#sel_pd_year").val();
            // // console.log(pd_M);
            // show_year("pd");
            sel_data_product_controller(pd_Y,pd_M);    
        }).fail(function(error) {
            console.log(error);
        });
    };

    //清空成品年月
    function clear_pd_y(){
        var sel_pd_year = document.getElementById("sel_pd_year");
            sel_pd_year.innerHTML = "";
        for(var i=0;i<sel_pd_year.childNodes.length;i++){
            sel_pd_year.removeChild(sel_pd_year.options[0]);
            sel_pd_year.remove(0);
            sel_pd_year.options[0] = null;
        };    
    }

    function clear_pd_m(){
        var sel_pd_month = document.getElementById("sel_pd_month");
            sel_pd_month.innerHTML = "";
        for(var i=0;i<sel_pd_month.childNodes.length;i++){
            sel_pd_month.removeChild(sel_pd_month.options[0]);
            sel_pd_month.remove(0);
            sel_pd_month.options[0] = null;
        };
    }

    function clear_pd_ym(){
        clear_pd_y();
        clear_pd_m();
    };

    //清空材料年月
    function clear_mt_y(){
        var sel_mt_year = document.getElementById("sel_mt_year");
            sel_mt_year.innerHTML = "";
    
        for(var i=0;i<sel_mt_year.childNodes.length;i++){
            sel_mt_year.removeChild(sel_mt_year.options[0]);
            sel_mt_year.remove(0);
            sel_mt_year.options[0] = null;
        };
    }

    function clear_mt_m(){
        var sel_mt_month = document.getElementById("sel_mt_month");
            sel_mt_month.innerHTML = "";

        for(var i=0;i<sel_mt_month.childNodes.length;i++){
            sel_mt_month.removeChild(sel_mt_month.options[0]);
            sel_mt_month.remove(0);
            sel_mt_month.options[0] = null;
        };
    }

    function clear_mt_ym(){
        clear_mt_y();
        clear_mt_m();
    };

     //成品年下拉式選單
     async function pd_year() {
        var data = {
            OpType: 'sel_pd_year_controller'
        };
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
            // async: false,
        }).done(function(res) {
            var str = JSON.parse(res);
            var l = str.length;
            for (var i = 0; i < l; i++) {
                $("#sel_pd_year").append("<option value=" + str[i].pd_create_year + ">"+str[i].pd_create_year+ "</option>");
            };
            // console.log(pd_Y);
            pd_month();
        }).fail(function(error) {
            console.log(error);
        });
    };
    
    //材料月下拉式選單
    async function mt_month() {
        var mt_create_year = $('#sel_mt_year').val();
        var data = {
            mt_create_year : mt_create_year,
            OpType: 'sel_mt_month_controller'
        };
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
            // async: false,
        }).done(function(res) {
            var str = JSON.parse(res);
            var l = str.length;
            for (var i = 0; i < l; i++) {
                $("#sel_mt_month").append("<option value=" + str[i].mt_create_month + ">"+str[i].mt_create_month+ "</option>");
            }
            var mt_M = $("#sel_mt_month").val();
            var mt_Y = $("#sel_mt_year").val();
            // show_year("mt");
            sel_data_material_controller(mt_Y,mt_M);    
        }).fail(function(error) {
            console.log(error);
        });
    };


     //材料年下拉式選單
     async function mt_year() {
        var data = {
            OpType: 'sel_mt_year_controller'
        };
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
            // async: false,
        }).done(function(res) {
            var str = JSON.parse(res);
            var l = str.length;
            for (var i = 0; i < l; i++) {
                $("#sel_mt_year").append("<option value=" + str[i].mt_create_year + ">"+str[i].mt_create_year+ "</option>");
            };
            mt_month()
        }).fail(function(error) {
            console.log(error);
        });
    };

    console.log(document.querySelector('#sel_pd_year'));
    console.log(document.querySelector('option'));
    //監聽成品年月
    [document.querySelector('#sel_pd_year'), document.querySelector('#sel_pd_month')].forEach(item => {
        item.addEventListener('change', event => {
            if(event.target.value<13){
                // alert(document.querySelector('#sel_pd_year').value+" "+event.target.value);
                sel_data_product_controller(document.querySelector('#sel_pd_year').value,event.target.value);
            }else{
                // alert(event.target.value+" "+document.querySelector('#sel_pd_month').value);
                sel_data_product_controller(event.target.value,document.querySelector('#sel_pd_month').value);
                clear_pd_m();
                pd_month();
            }
            
        })
    });

    //監聽材料年月
    [document.querySelector('#sel_mt_year'), document.querySelector('#sel_mt_month')].forEach(item => {
        item.addEventListener('change', event => {
            if(event.target.value<13){
                // alert(document.querySelector('#sel_mt_year').value+" "+event.target.value);
                sel_data_material_controller(document.querySelector('#sel_mt_year').value,event.target.value);
            }else{
                // alert(event.target.value+" "+document.querySelector('#sel_mt_month').value);
                sel_data_material_controller(event.target.value,document.querySelector('#sel_mt_month').value);
                clear_mt_m();
                mt_month();
            }
            
        })
    });
    
    //查詢BOM
    // function sel_data_pdbom_controller(){
    //     var Row_id = t.parent().parent().find('td:eq(' + x + ')').text();
    //     data = {
    //         OpType: 'sel_data_bom_controller',
    //     };
    //     $.ajax({
    //         url: '../controller/material_controller.php',
    //         data: data,
    //         dataType: "text",
    //         type: 'POST'
    //     }).done(function(res) {
    //         console.log(res);
    //         var obj = JSON.parse(res);
    //         console.log(obj);
    //         data_mat_table("#bom_table", obj, {
    //                 deferRender: true,
    //                 scrollCollapse: true,
    //                 scroller: false,
    //                 info: false,
    //                 ordering: false,
    //                 etrieve: true,
    //                 paging: false,
    //                 destroy: true,
    //                 bLengthChange: false,
    //                 searching: true
    //             },
    //             [{},{
    //                     "data": "display_Row_id"
    //                 },
    //                 {
    //                     "data": "display_pd_create_year"
    //                 },
    //                 {
    //                     "data": "display_pd_create_month"
    //                 },
    //                 {
    //                     "data": "display_product_num"
    //                 },
    //                 {
    //                     "data": "display_product_name"
    //                 },
    //                 {
    //                     "data": "display_total_cost"
    //                 },
    //             ])
    //     });
    // };

    //
    function modify_bom(number,bom,t,command){
      
        var bomTable = $("#bom_table").DataTable();
        var originval = parseInt(bomTable.cell({ row: 0, column: 5 }).data());
        if((command==="delete")||(command==="deleteBOM")){
            bomTable.cell({ row: 0, column: 5 }).data(originval-parseInt(number)).draw();
        }
        if(command==="delete"){
            var bom_detail_Table = $("#example").DataTable();
            var indexes = bom_detail_Table
            .rows()
            .indexes()
            .filter( function ( value, index ) {
                return bom ===  bom_detail_Table.row(value).data()[1];
            } );
            var index = parseInt(indexes[0]);
            var bom_origin_val = parseInt(bom_detail_Table.cell({row: index, column: 2 }).data());
            bom_detail_Table.cell({ row: index, column: 2 }).data(bom_origin_val-parseInt(number));
            t.parent().parent().remove();  
            if((bom_origin_val-parseInt(number))===0){
                alert('您即將刪除整個BOM碼資料');
                bom_detail_Table.row(index).remove().draw();
            }
        }

        
        console.log(number+","+originval,index);
    }

    //成品刪除
    function del_p(t, x =4) {
        var product_num = t.parent().parent().find('td:eq(' + x + ')').text();
        var pd_create_year = $('#sel_pd_year').val();
        var pd_create_month = $('#sel_pd_month').val();
        var data = {
            product_num: product_num,
            pd_create_year: pd_create_year,
            pd_create_month: pd_create_month,
            login_user: "<?= $login_user ?>",
            OpType: 'del_data_product_controller',
        };
        var confirm_delete = confirm('您確定要刪除嗎?');
        if(confirm_delete){
        $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            sel_data_product_controller(pd_create_year,pd_create_month); //不要重新導向
        }).fail(function(error) {
            console.log(error);
        });}
    };

    //BOM material 刪除
    function del_bm(t, x =3) {

        var product_bom = t.parent().parent().find('td:eq(' + 1 + ')').text();
        var material_num = t.parent().parent().find('td:eq(' + x + ')').text();
        var bom_cost =  t.parent().parent().find('td:eq(' + 4 + ')').text();
        var pd_create_year = $('#sel_pd_year').val();
        var pd_create_month = $('#sel_pd_month').val();
        var confirm_delete = confirm('您確定要刪除嗎?');
        
        if (confirm_delete) {
            var data = {
                product_bom: product_bom,
                material_num: material_num,
                pd_create_year: pd_create_year,
                pd_create_month: pd_create_month,
                login_user: "<?= $login_user ?>",
                OpType: 'del_data_bom_material_controller',
            };

            $.ajax({
                url: '../controller/material_controller.php',
                data: data,
                dataType: "text",
                type: 'POST'
            }).done(function(res) {
                // console.log("delete",res);
                // console.log(t.parent().parent());
                modify_bom(bom_cost,product_bom,t,"delete");
                // format(); //不要重新導向
            }).fail(function(error) {
                console.log(error);
            });
        } 
        
    };

    //BOM 刪除
    function del_bm_code(t){
        var product_bom = t.parent().parent().find('td:eq(' + 1 + ')').text();
        var confirm_delete = confirm('您確定要刪除嗎?');
        var bom_all_cost =  t.parent().parent().find('td:eq(' + 2 + ')').text();
        if (confirm_delete) {
            var data = {
                product_bom: product_bom,
                login_user: "<?= $login_user ?>",
                OpType: 'del_data_bom_controller',
            };

            $.ajax({
                url: '../controller/material_controller.php',
                data: data,
                dataType: "text",
                type: 'POST'
            }).done(function(res) {
                //console.log("delete",res);
                //use datatable remove
                modify_bom(bom_all_cost,product_bom,null,"deleteBOM");
                var table = $('#example').DataTable();

                    table
                        .row( t.parent().parent() )
                        .remove()
                        .draw();

                // format(); //不要重新導向
            }).fail(function(error) {
                console.log(error);
            })        
        }
    
    }

    //材料刪除
    function del_m(t, x = 0) {
        var Row_id = t.parent().parent().find('td:eq(' + x + ')').text();
        var mt_create_year = $('#sel_mt_year').val();
        var mt_create_month = $('#sel_mt_month').val();
        var confirm_delete = confirm('您確定要刪除嗎?');
        var data = {
            Row_id: Row_id,
            login_user: "<?= $login_user ?>",
            OpType: 'del_data_material_controller',
        };
        if(confirm_delete){
            $.ajax({
                url: '../controller/material_controller.php',
                data: data,
                dataType: "text",
                type: 'POST'
            }).done(function(res) {
                // console.log(res);
                sel_data_material_controller(mt_create_year,mt_create_month); //不要重新導向
            }).fail(function(error) {
                console.log(error);
            });
        }
    };

    //修改 單筆BOM材料查詢互動視窗
    async function edit_bm(t, x = 3) {
        var product_bom = t.parent().parent().find('td:eq(' + 1 + ')').text();
        var material_num = t.parent().parent().find('td:eq(' + x + ')').text();
        var pd_create_year = $('#sel_pd_year').val();
        var pd_create_month = $('#sel_pd_month').val();
        var data = {
            product_bom: product_bom,
            material_num: material_num,
            pd_create_year: pd_create_year,
            pd_create_month: pd_create_month,
            OpType: 'sel_single_bom_material_controller',
        };

        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            console.log(obj);
            $('#edit_bom_mt_modal').modal('show');
            $('#edit_bom_product_bom').val(obj[0].product_bom);
            $('#edit_bom_material_num').val(obj[0].material_num);
            $('#edit_mt_useage').val(obj[0].material_useage);
        }).fail(function(error) {
            console.log(error);
        });
    };
    var origin_usage=$('#edit_mt_useage').val();
    // 確認 單筆BOM材料修改
    $('#btn_edit_bom_mt_uphold').click(function() {
        var product_bom = $('#edit_bom_product_bom').val();
        var material_num = $('#edit_bom_material_num').val();
        var material_useage = $('#edit_mt_useage').val();
        var pd_create_year = $('#sel_pd_year').val();
        var pd_create_month = $('#sel_pd_month').val();
        console.log(material_useage);

        var data = {
            product_bom: product_bom,
            material_num: material_num,
            material_useage: material_useage,
            pd_create_year: pd_create_year,
            pd_create_month: pd_create_month,
            login_user: "<?= $login_user ?>",
            OpType: 'edit_single_data_bom_material_controller',
        };
        if (material_useage == '') {
            $('#err_modal').modal('show', $('#err_msg').html('材料用量尚未填寫'));
        } else {
            edit_single_bom_mt_data(data);
        };
    });

    async function edit_single_bom_mt_data(data) {
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            console.log("edit",res);
            var obj = JSON.parse(res);
            // console.log(obj)
            alert(obj.message+"修改");
            
                //success to show all tag with class(.shown)

                //refresh all parents row
                var bomTable = $("#bom_table").DataTable();
                    var product_num = bomTable.cell({ row: 0, column: 3 }).data();
                    let bom_data={
                        display_product_num:product_num,
                        pd_create_year:data.pd_create_year,
                        pd_create_month:data.pd_create_month
                    }
                    update_table(bom_data);
                // $("#example").DataTable().rows().every(function(index, element) {
                //     var row = $(this.node());
                //     var costElement = parseInt(row.find('td').eq(2).text()); 
                    
                //     console.log(costElement);
                //     // focus on parent node and add all child node

                
                //     //replace material diff with 150
                //     // bomTable.cell({ row: 0, column: 5 }).data(originval-parseInt(150-costElement)).draw();
                    
                //     console.log(data)
                // });
                
                var tr_elements = document.querySelectorAll('tr.shown > .details-control');
                for(var i = 0; i < tr_elements.length; i++){
                    var str = tr_elements[i];
                    str.click();
                    str.click();
                    console.log(str);
                }

            
            // edit_b(t, x = 4);
        }).fail(function(error) {
            console.log(error);
        });
    };

    //修改 單筆材料查詢互動視窗
    async function edit(t, x = 0) {
        var Row_id = t.parent().parent().find('td:eq(' + x + ')').text();
        var data = {
            Row_id: Row_id,
            OpType: 'sel_single_material_controller',
        };

        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            console.log(obj);
            $('#edit_mt_modal').modal('show');
            $('#edit_mt_Row_id').val(obj[0].Row_id);
            $('#edit_mt_num').val(obj[0].mt_num);
            $('#edit_mt_cost').val(obj[0].mt_cost);
        }).fail(function(error) {
            console.log(error);
        });
    };

    $("#match_last_month").click(function(){
        var data = {
            login_user: "<?= $login_user ?>",
            OpType: 're_add_material_controller',
        };
        re_add_material_controller(data);
    });

    async function re_add_material_controller(data) {
        var mt_create_year = $('#sel_mt_year').val();
        var mt_create_month = $('#sel_mt_month').val();
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj)
            $('#success_modal').modal('show', $('#suc_msg').html(obj.message));
            sel_data_material_controller(mt_create_year,mt_create_month);
        }).fail(function(error) {
            console.log(error);
        });
    };


    // 確認 單筆材料修改
    $('#btn_edit_mt_uphold').click(function() {
        var Row_id = $('#edit_mt_Row_id').val();
        var mt_num = $('#edit_mt_num').val();
        var mt_cost = $('#edit_mt_cost').val();

        var data = {
            Row_id: Row_id,
            mt_num: mt_num,
            mt_cost: mt_cost,
            login_user: "<?= $login_user ?>",
            OpType: 'edit_single_data_material_controller',
        };
        if (mt_cost == '') {
            $('#err_modal').modal('show', $('#err_msg').html('材料單價尚未填寫'));
        } else {
            edit_single_mt_data(data);
        };
    });

    async function edit_single_mt_data(data) {
        var mt_create_year = $('#sel_mt_year').val();
        var mt_create_month = $('#sel_mt_month').val();
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj)
            $('#success_modal').modal('show', $('#suc_msg').html(obj.message));
            sel_data_material_controller(mt_create_year,mt_create_month);
        }).fail(function(error) {
            console.log(error);
        });
    };

    


    // a function which deals with the pop up page of 修改/刪除
    function data_nest_table(name, top_data) {
        // var top_data = [
        //     ["BOM區分碼1", "BOM成本1"],
        //     ["BOM區分碼2", "BOM成本2"]
        // ];
        // var bottom_data = [
        //     ["材料料號1-1", "材料用量1-1"],
        //     ["材料料號1-2", "材料用量1-2"]
        // ]
        var object2 = {
            language: {
                "processing": "處理中...",
                "loadingRecords": "載入中...",
                "lengthMenu": "顯示 _MENU_ 項",
                "zeroRecords": "沒有符合",
                "info": "顯示第 _START_ 至 _END_ 項，共 _TOTAL_ 項",
                "infoEmpty": "顯示第 0 至 0 項，共 0 項",
                "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                "infoPostFix": "",
                "search": "搜尋:",
                "paginate": {
                    "first": "第一頁",
                    "previous": "上一頁",
                    "next": "下一頁",
                    "last": "最後一頁"
                },
                "aria": {
                    "sortAscending": ": 升冪排列",
                    "sortDescending": ": 降冪排列"
                }
            }
        }

        var table = $(name).DataTable({
            'dom': 't',
            'columns': [{
                    'className': 'details-control',
                    'orderable': false,
                    'data': null,
                    'defaultContent': ''
                },
                null,
                null,
                null,
            ],
            'columnDefs': [{
                    'targets': [0],
                    'width': '10px',
                },
                {
                    'targets': [1, 2],
                    'className': 'dt-center',
                },
                {
                    'targets': [3, 4, 5],
                    'className': 'dt-center',
                },
                {
                    'targets': [6],
                    'render': function(data, type, row, meta) {
                        return '<button class="btn btn-danger" id=n-"' + meta.row + '" onclick=" del_bm_code($(this))">刪除</button>';
                    }
                }
            ],
            ...object2
        });

        // put the data ( ["BOM區分碼","BOM成本"] )  in the row add(!)
        for (let i = 0; i < top_data.length; i++) {
            table
                .row.add(['', top_data[i][0], top_data[i][1], '', '', '', ''])
                .draw()
        }

        // Add event listener for opening and closing details
        $(name + ' tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            // console.log( $(this).parent().children('td').eq(1).text());
            // console.log('heaer',row.data());

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                // which
                format($(this).parent().children('td').eq(1).text())
                    .then(getdata => {
                        // const getdata = await format(row.data()); 
                        // console.log("getdata",getdata);
                        row.child(getdata).show();
                        tr.addClass('shown');
                    });

            }

        });

        // replace below function with "#emaple parent"
        // destroy the table to reslease
        var close_btn = $('#example').parent().parent().parent().parent().find($( "div.modal-header button" ));        
        console.log(close_btn);

        var bom_detail_table = $('#example').DataTable();
        close_btn.unbind('click');
        $("#btn_edit_cancel").unbind('click');
        close_btn.on('click', function() {
            var bom_year = $('#sel_pd_year').val();
            var bom_month = $('#sel_pd_month').val();
            bom_detail_table.clear();
            bom_detail_table.destroy();
            $('#example').hide();
            sel_data_product_controller(bom_year,bom_month);
        })

        $("#btn_edit_cancel").on('click', function() {
            var bom_year = $('#sel_pd_year').val();
            var bom_month = $('#sel_pd_month').val();
            bom_detail_table.clear();
            bom_detail_table.destroy();
            $('#example').hide();
            sel_data_product_controller(bom_year,bom_month);
        })

    }

    async function format(rowData) {
        var pd_create_year = $('#sel_pd_year').val();
        var pd_create_month = $('#sel_pd_month').val();
        var data = {
            product_bom: rowData,
            pd_create_year: pd_create_year,
            pd_create_month: pd_create_month,
            OpType: 'sel_data_bommt_controller',
        };
        var childTable = '<tr>';
        await $.ajax({
            url: '../controller/material_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            for (i = 0; i < obj.length; i++) {
                childTable += '<tr>' +
                    '<td></td>' +
                    '<td class="dt-center">' +  obj[i].product_bom + '</td>' +
                    '<td class="dt-center"></td>' +
                    '<td class="dt-center">' + obj[i].material_num + '</td>' +
                    '<td class="dt-center">' + obj[i].material_cost + '</td>' +
                    '<td class="dt-center"><input type="button" class="btn btn-outline-primary" data-toggle="modal" data-target=".bd-mod-table-modal-bom_mt" value = "修改" onclick="edit_bm($(this))"></td>' +
                    '<td class="dt-center"><input type="button" class="btn btn-outline-danger" value = "刪除" onclick="del_bm($(this))"></td>' +
                    '</tr>';
            }

            childTable += '</tr>';
            // console.log($(childTable).toArray());
            return $(childTable).toArray();

        }).fail(function(error) {
            console.log(error);
        });

        return $(childTable).toArray();
    }


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
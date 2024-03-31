<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../src/link_management.php'); ?>
    <?php include('../view/modal_share_view.php'); ?>
    <style>
        <?php include('../src/work_attribute_view.css'); ?>
    </style>
    <title>作業屬性</title>
</head>

<body>
    <?php include('../view/button_share_view.php'); ?>
    <?php include('../view/left_bar_view.php'); ?>
    <div id="up_table">
        <h1 class="text_c">設定作業屬性</h1>
        <hr class="text_line">
        <table id="config_table" class="table table-striped table-bordered table_w_h text_c">
            <thead>
                <tr>
                    <td scope="col">下載_範本</td>
                    <td scope="col" colspan="4">上傳_檔案</td>
                </tr>
            </thead>
            <tbody id="upload_row_btn">
                <!-- 作業屬性 -->
                <tr>
                    <!-- 下載 -->
                    <th scope="row">
                        <!-- <a href="../file/report.xlsx" download="report.xlsx"> -->
                        <button type="button" class="btn btn-outline-secondary" id="dow_excel">
                            作業屬性
                        </button>
                        <!-- </a> -->
                    </th>
                    <!-- 上傳 -->
                    <td>
                        <label class="btn btn-outline-primary btn-block" for="file_1" aria-describedby="上傳檔案按鈕">上傳檔案 作業屬性</label>
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
        <h2 id="text_add_cost" class="text_c">單筆新增 作業屬性</h2>
        <hr class="text_add_cost_line">
        <form class="add-form">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="work_num">作業代碼</label>
                    <input type="text" class="form-control" id="work_num">
                </div>
                <div class="form-group col-md-6">
                    <label for="work_name">作業名稱</label>
                    <input type="text" class="form-control" id="work_name">
                </div>
                <div class="form-group col-md-6">
                    <label for="property">品質屬性</label>
                    <select name="property" class="custom-select">
                        <option value="1">預防作業</option>
                        <option value="2">鑑定作業</option>
                        <option value="3">外部失敗作業</option>
                        <option value="4">內部失敗作業</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="capacity">產能屬性</label>
                    <select name="capacity" class="custom-select">
                        <option value="5">有生產力作業</option>
                        <option value="6">無生產力作業</option>
                        <option value="7">間接生產力作業</option>
                        <option value="8">閒置產能作業</option>
                    </select>
                </div>
                </div>
                <br>
            <button type="button" class="btn btn-primary" id="single_btn">確認</button>
        </form>
    </div>
    
    <!-- 查詢資料 -->
    <div id="bgc_page">
        <div id="table_sheet">
            <h2 id="text_search" class="text_c">作業屬性</h2>
            <hr class="text_search_line">
            <table id="mat_table" class="hover cell-border">
                <thead class="thead_search">
                    <tr class="th_search_details">
                        <th>編號</th>
                        <th>代碼</th>
                        <th>名稱</th>
                        <th>品質屬性</th>
                        <th>產能屬性</th>
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
                    <h2 id="modify_text" class="text_c">修改 作業屬性</h2>
                    <hr id="modify_line">
                    <form class="modify-form justify-content-center align-items-center">
                        <input type="hidden" id="edit_Row_id" readonly>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_work_num">代碼</label>
                                <input type="text" class="form-control" id="edit_work_num">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_work_name">名稱</label>
                                <input type="text" class="form-control" id="edit_work_name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_property">品質屬性</label>
                                <select id="edit_property" class="custom-select">
                                    <option value="1">預防作業</option>
                                    <option value="2">鑑定作業</option>
                                    <option value="3">外部失敗作業</option>
                                    <option value="4">內部失敗作業</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_capacity">產能屬性</label>
                                <select id="edit_capacity" class="custom-select">
                                    <option value="5">有生產力作業</option>
                                    <option value="6">無生產力作業</option>
                                    <option value="7">間接生產力作業</option>
                                    <option value="8">閒置產能作業</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" id='btn_edit_cancel'>取消</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id='btn_edit_uphold'>確認</button>
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
        fun_dow_excel();
    });

    function fun_dow_excel() {
        $.ajax({
            url: '../controller/work_attribute_controller.php',
            data: {
                'OpType': 'dow_excel'
            },
            dataType: 'text',
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            // var obj = JSON.parse(res);
            // console.log(obj);
            window.location.href = "../file/work_attribute.xlsx";
        }).fail(function(error) {
            console.log(error);
        });
    };
    // ------------------------------------------------------
    var file_1;
    var formdata_1 = new FormData();
    var chgindex;

    function choose_up_file(index) {
        chgindex = index;
    };
    var file_name = [
        'work_attribute.csv'
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
            url: '../controller/work_attribute_controller.php',
            data: formdata,
            // dataType: 'text',
            type: 'POST',
            processData: false,
            contentType: false,
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            console.log(obj);
            if (obj.status == '200') {
                $('#success_modal').modal('show', $('#suc_msg').html(obj.message));
            } else if (obj.status == '404') {
                $('#err_modal').modal('show', $('#err_msg').html('重複作業代碼'+obj.data));
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

    function add_table_data() {
        var data = {
            work_num: $('#work_num').val(),
            work_name: $('#work_name').val(),
            property:  $('select[name=property]').val(),
            capacity: $('select[name=capacity]').val(),
            login_user: "<?= $login_user ?>",
            OpType: ""
        };
        return data;
    }

    //清除單筆新增
    function clear_single_data() {
        $('#work_num').val('');
        $('#work_name').val('');
        $('select[name=property]').val();
        $('select[name=capacity]').val();
    }

    //單筆新增
    async function add_single_data(data) {
        var data = add_table_data();
        data['OpType'] = 'add_single_data_controller';
        // console.log(data);
        await $.ajax({
            url: '../controller/work_attribute_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
        }).done(function(res) {
            // console.log(res);
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
    
    //檢查是否已新增過的工單編號
    async function chk_work_num() {
        var data = add_table_data();
        data['OpType'] = 'chk_work_num_controller';
        await $.ajax({
            url: '../controller/work_attribute_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
        }).done(function(res) {
            console.log(res);
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
        chk_work_num();
    });
    
    //查詢資料
    $('#search_btn').click(function() {
        sel_data_work_attribute_controller();
    });

    function sel_data_work_attribute_controller(){
        var data = {
            OpType: 'sel_data_work_attribute_controller',
        };
        $.ajax({
            url: '../controller/work_attribute_controller.php',
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
                },
                [{
                    'targets': 5,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) {
                        return "<input type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='.bd-mod-table-modal-xl' value = '修改' onclick='edit($(this))'> ";
                    }
                }, {
                    'targets': 6,
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
                        "data": "work_num"
                    },
                    {
                        "data": "work_name"
                    },
                    {
                        "data": "property"
                    },
                    {
                        "data": "capacity"
                    },
                ])
        });
    };

    //刪除
    function del(t, x =0) {
        var Row_id = t.parent().parent().find('td:eq(' + x + ')').text();
        var data = {
            Row_id: Row_id,
            login_user: "<?= $login_user ?>",
            OpType: 'del_data_work_attribute_controller',
        };

        $.ajax({
            url: '../controller/work_attribute_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            sel_data_work_attribute_controller(); //不要重新導向
        }).fail(function(error) {
            console.log(error);
        });
    };
    
    function edit_cancel(){
        $("#edit_property").find("option:selected").removeAttr("selected");
        $("#edit_capacity").find("option:selected").removeAttr("selected");
        // $('#edit_property option[value='+a+']').attr('selected', false);
        // $('#edit_capacity option[value='+b+']').attr('selected', false);
    }
    //互動視窗 取消
    $('#btn_edit_cancel').click(function(){
        edit_cancel();
    });
    //修改 單筆查詢互動視窗
    async function edit(t, x = 0) {
        var Row_id = t.parent().parent().find('td:eq(' + x + ')').text();
        var data = {
            Row_id: Row_id,
            OpType: 'sel_single_work_attribute_controller',
        };

        await $.ajax({
            url: '../controller/work_attribute_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            console.log(obj);
            $('#edit_modal').modal('show');

            $('#edit_Row_id').val(obj[0].Row_id);
            $('#edit_work_num').val(obj[0].work_num);
            $('#edit_work_name').val(obj[0].work_name);
            $('#edit_property option[value='+obj[0].property_num+']').attr('selected', true);
            $('#edit_capacity option[value='+obj[0].capacity_num+']').attr('selected', true);
            // $('#edit_property').val(obj[0].property);
            // $('#edit_capacity').val(obj[0].capacity);
        }).fail(function(error) {
            console.log(error);
        });
    };
    
    // 確認 單筆修改
    $('#btn_edit_uphold').click(function() {
        var Row_id = $('#edit_Row_id').val();
        var work_num = $('#edit_work_num').val();
        var work_name = $('#edit_work_name').val();
        var property = $('#edit_property').val();
        var capacity = $('#edit_capacity').val();

        var data = {
            Row_id: Row_id,
            work_num: work_num,
            work_name: work_name,
            property: property,
            capacity: capacity,
            login_user: "<?= $login_user ?>",
            OpType: 'edit_single_data_work_attribute_controller',
        };
        if (work_num == '') {
            $('#err_modal').modal('show', $('#err_msg').html('工單號碼尚未填寫'));
        } else if (work_name == '') {
            $('#err_modal').modal('show', $('#err_msg').html('工單名稱尚未填寫'));
        } else if (property == '') {
            $('#err_modal').modal('show', $('#err_msg').html('品質屬性尚未填寫'));
        } else if (capacity  == '') {
            $('#err_modal').modal('show', $('#err_msg').html('產能屬性尚未填寫'));
        } else {
            edit_single_data(data);
        };
    });

    async function edit_single_data(data) {
        await $.ajax({
            url: '../controller/work_attribute_controller.php',
            data: data,
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj)
            $('#success_modal').modal('show', $('#suc_msg').html(obj.message));
            edit_cancel();
            sel_data_work_attribute_controller();
        }).fail(function(error) {
            console.log(error);
        });
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
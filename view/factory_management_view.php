<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../src/link_management.php'); ?>
    <?php include('../view/modal_share_view.php'); ?>
    <style>
        <?php include('../src/factory_management_view.css'); ?>
    </style>
    <title>工廠成本、內部與外部失敗作業成本及無生產力與閒置產能作業成本分析表</title>
</head>

<body>
    <div class="back_div_position mt-3 mb-3 ml-3">
        <button type="button" class="btn btn-outline-danger" id='btn_back'>上一頁</button>
    </div>


    <!-- 查詢資料 -->
    <div id="bgc_page">
        <div id="table_sheet">
            <h2 class="text_c">工廠成本、內部與外部失敗作業成本及無生產力與閒置產能作業成本分析表</h2>
            <div id="search_bottom_bar" style="margin-top:20px;;display:flex;position:relative;left:73%;">
            <button  style="float:right;margin:10px;" class="btn btn-outline-primary" onclick="set_default_YMD()">查詢當天</button>
            <button style="float:right;margin:10px;" class="btn btn-outline-primary" onclick="set_current_month()">查詢當月</button>
            </div>
            <div id="search_bar" style="margin:10px auto;display:flex;width:70%;height:auto;padding:30px;background-color:whitesmoke;font-size:20px;">
                <div id="search_bar_box" style="margin:0 auto;display:block;">
                    <div id="search_inner_bar">
                        <div id="search_top_bar">
                            <label>從</label>
                            <select id="mc_start_year"></select>
                            <label>年</label>
                            <select id="mc_start_month"></select>
                            <label>月</label>
                            <select id="mc_start_date">

                            </select>
                            <label>日</label>
                            <label style="margin-left:20px;">至</label>
                            <select id="mc_end_year">
                            </select>
                            <label>年</label>
                            <select id="mc_end_month">
                            </select>
                            <label>月</label>
                            <select id="mc_end_date">
                            </select>
                            <label>日</label>                                              
                            <button  style="float:right;margin:10px;margin-left:20px;" class="btn btn-outline-primary" onclick="search_current_period()">查詢</button>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="text_line">
            <table id="mat_table" class="hover cell-border">
                <thead class="thead_search">                  
                    <tr class="th_search">
                        <th colspan="2"></th>
                        <th colspan="2" class="line-top">工廠成本</th>
                        <th colspan="2" class="line-top">內部失敗作業成本</th>
                        <th colspan="2" class="line-top">外部失敗作業成本</th>
                        <th colspan="2" class="line-top">無生產力作業成本</th>
                        <th colspan="2" class="line-top">閒置產能作業成本</th>
                    </tr>
                    <tr class="th_search_details">
                        <th>日期</th>
                        <th>產品名稱</th>
                        <!-- 工廠成本--------------------------- -->
                        <th class="line-top">金額</th>
                        <th>佔比</th>
                        <!-- 內部失敗作業成本--------------------------- -->
                        <th class="line-top">金額</th>
                        <th>佔比</th>
                        <!-- 外部失敗作業成本--------------------------- -->
                        <th class="line-top">金額</th>
                        <th>佔比</th>
                        <!-- 無生產力作業成本--------------------------- -->
                        <th class="line-top">金額</th>
                        <th>佔比</th>
                        <!-- 閒置產能作業成本--------------------------- -->
                        <th class="line-top">金額</th>
                        <th>佔比</th>
                    </tr>
                </thead>
                <tbody class="th_search_details"></tbody>
            </table>
        </div>
    </div>
</body>

</html>

<script>
    // 上一頁
    $('#btn_back').click(function() {
        window.location.href = "../view/nav_view.php";
    });

    // input.setAttribute("min", datew);

    //set value
    // document.getElementById("startdate").onchange = function() {
    //     var input = document.getElementById("enddate");
    //     input.setAttribute("min", this.value);
    // }


    //default view
    data_mat_table("#mat_table", {}, {
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
                [],
                [
                    {
                        "data": "REAL_DATE"
                    },
                    {
                        "data": "OP_NO"
                    },
                    {
                        "data":"OP_NAME"
                    },
                    {
                        "data": "EMP_NO"
                    },
                    {
                        "data": "human_cost"
                    },
                    {
                        "data":"total_human_cost"
                    },
                    {
                        "data": "MCM_NO"
                    },
                    {
                        "data": "machine_cost"
                    },
                    {
                        "data":"toatl_machine_cost"
                    },
                    {
                        "data":"add_cost"
                    }
                ]);
    //select view
    function get_selected() {
        // console.log(document.getElementById("startdate").value);
        // console.log(document.getElementById("enddate").value);
        var y = Number($('#sel_year').val()) + 1911;
        var m = $('#sel_month').val();

        //工序
        data = {
            "real_data": [
                "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_03\", \"MCM_NO\": \"#24\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.47}",
                "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_07\", \"MCM_NO\": \"#25\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 1.42}",
                "{\"OP_NO\": \"21\", \"EMP_NO\": \"EMP_07\", \"MCM_NO\": \"#26\", \"OP_NAME\": \"test_03\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 1.12}",
                "{\"OP_NO\": \"21\", \"EMP_NO\": \"EMP_04\", \"MCM_NO\": \"#27\", \"OP_NAME\": \"test_03\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 2.33}",
                "{\"OP_NO\": \"20\", \"EMP_NO\": \"EMP_01\", \"MCM_NO\": \"#28\", \"OP_NAME\": \"test_02\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 2.52}",
                "{\"OP_NO\": \"20\", \"EMP_NO\": \"EMP_04\", \"MCM_NO\": \"#28\", \"OP_NAME\": \"test_02\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.18}",
                "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_02\", \"MCM_NO\": \"#29\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.32}",
                "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_03\", \"MCM_NO\": \"#30\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.23}",
                "{\"OP_NO\": \"20\", \"EMP_NO\": \"EMP_01\", \"MCM_NO\": \"#31\", \"OP_NAME\": \"test_02\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 2.52}",
                "{\"OP_NO\": \"25\", \"EMP_NO\": \"EMP_04\", \"MCM_NO\": \"#32\", \"OP_NAME\": \"test_02\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.18}",
                "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_02\", \"MCM_NO\": \"#33\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.32}",
                "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_03\", \"MCM_NO\": \"#34\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.23}",
                "{\"OP_NO\": \"20\", \"EMP_NO\": \"EMP_01\", \"MCM_NO\": \"#35\", \"OP_NAME\": \"test_02\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 2.52}",
                "{\"OP_NO\": \"21\", \"EMP_NO\": \"EMP_04\", \"MCM_NO\": \"#37\", \"OP_NAME\": \"test_02\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.18}",
                "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_02\", \"MCM_NO\": \"#36\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.32}"
            ]
        };
        data2 = {
            "real_data": []
        }
        var len = data.real_data.length;
        for (var i = 0; i < len; i++) {
            var str = data.real_data[i].substring(1, data.real_data[i].length - 1).replace(/(?![\. }])(\"*)/g, '')
            // console.log(str)
            var arr = str.split(',');
            // console.log(arr);
            var obj = {};

            for (var j = 0; j < arr.length; j++) {
                row = arr[j].split(':');
                var key = row[0].trim();
                var value = row[1].trim();
                obj[key] = value;
            }
            data2.real_data[i] = obj;
        };

        

        if (y == data2.real_data[0].YEAR && m == data2.real_data[0].MONTH) {
            sel_data_job_cost_controller(data2);
            // console.log('OK');
        } else {
            var str = '尚無當月資料';
            alert(str);
            // console.log(str);
            data_mat_table("#mat_table", {}, {
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
                [],
                [
                    {
                        "data": "REAL_DATE"
                    },
                    {
                        "data": "OP_NO"
                    },
                    {
                        "data":"OP_NAME"
                    },
                    {
                        "data": "EMP_NO"
                    },
                    {
                        "data": "human_cost"
                    },
                    {
                        "data":"total_human_cost"
                    },
                    {
                        "data": "MCM_NO"
                    },
                    {
                        "data": "machine_cost"
                    },
                    {
                        "data":"toatl_machine_cost"
                    },
                    {
                        "data":"add_cost"
                    }
                ])
        };
    }
    //-------------------------------------------------------------
    function sel_data_job_cost_controller(data2) {
        // console.log(data2);
        $.ajax({
            url: '../controller/job_cost_controller.php',
            data: {
                'OpType': 'sel_data_job_cost_controller',
                'real_data': data2.real_data,
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
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
                [],
                [
                    {
                        "data": "REAL_DATE"
                    },
                    {
                        "data": "OP_NO"
                    },
                    {
                        "data":"OP_NAME"
                    },
                    {
                        "data": "EMP_NO"
                    },
                    {
                        "data": "human_cost"
                    },
                    {
                        "data":"total_human_cost"
                    },
                    {
                        "data": "MCM_NO"
                    },
                    {
                        "data": "machine_cost"
                    },
                    {
                        "data":"toatl_machine_cost"
                    },
                    {
                        "data":"add_cost"
                    }
                ])
        });
    };
    //-------------------------------------------------------------
    //設定start date function
    function set_start_D(year,default_num){
        const timestamp = new Date();
        $('#mc_start_date').empty();
        var month = new Date(timestamp + 8*60*60*1000).getMonth() + 1;
        var date = new Date(timestamp + 8*60*60*1000).getDate();
        var certain_month_date = new Date(year, default_num, 0).getDate();
        if ((year === (new Date(timestamp + 8*60*60*1000).getFullYear() - 1911))&(default_num === month)) {
            for (var i = 1; i < date + 1; i++) {
                if (i === date) {
                    $('#mc_start_date').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
                } else {
                    $('#mc_start_date').append("<option value=" + i + ">" + i + "</option>");                 
                }
            }
        }else{
            for (var i = 1; i < certain_month_date + 1; i++) {
                if (i === certain_month_date) {
                    $('#mc_start_date').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
                } else {
                    $('#mc_start_date').append("<option value=" + i + ">" + i + "</option>");                 
                }
            }
        }        
    }

    //設定start date function
    function set_end_D(year,default_num,default_date){
        const timestamp = new Date();
        $('#mc_end_date').empty();
        var month = new Date(timestamp + 8*60*60*1000).getMonth() + 1;
        var date = new Date(timestamp + 8*60*60*1000).getDate();
        var certain_month_date = new Date(year, default_num, 0).getDate();
        // start ~ end
        if(default_date > 0){
            if ((year === (new Date(timestamp + 8*60*60*1000).getFullYear() - 1911))&(default_num === month)) {
                for (var i = default_date; i < date + 1; i++) {
                    if (i === date) {
                        $('#mc_end_date').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
                    } else {
                        $('#mc_end_date').append("<option value=" + i + ">" + i + "</option>");                 
                    }
                }
            }else{
                for (var i = default_date; i < certain_month_date + 1; i++) {
                    if (i === certain_month_date) {
                        $('#mc_end_date').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
                    } else {
                        $('#mc_end_date').append("<option value=" + i + ">" + i + "</option>");                 
                    }
                }
            }
        }else{
            if ((year === (new Date(timestamp + 8*60*60*1000).getFullYear() - 1911))&(default_num === month)) {
                for (var i = date; i < date + 1; i++) {
                    if (i === date) {
                        $('#mc_end_date').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
                    } else {
                        $('#mc_end_date').append("<option value=" + i + ">" + i + "</option>");                 
                    }
                }
            }else{
                for (var i = certain_month_date; i < certain_month_date + 1; i++) {
                    if (i === certain_month_date) {
                        $('#mc_end_date').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
                    } else {
                        $('#mc_end_date').append("<option value=" + i + ">" + i + "</option>");                 
                    }
                }
            }
        }
    }

    //設定start月份的function
    function set_start_M(year) {
        const timestamp = new Date();
        $('#mc_start_month').empty();
        var month = new Date(timestamp + 8*60*60*1000).getMonth() + 1;
        if (year === (new Date(timestamp + 8*60*60*1000).getFullYear() - 1911)) {
            for (var i = 1; i < month + 1; i++) {
                if (i === month) {
                    set_end_M(parseInt(year),parseInt(month),0);
                    set_start_D(parseInt(year),parseInt(month));
                    set_end_D(parseInt(year),parseInt(month),0);
                    $('#mc_start_month').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
                } else {
                    $('#mc_start_month').append("<option value=" + i + ">" + i + "</option>");                 
                }
            }
        } else {
            for (var i = 1; i < 13; i++) {
                if (i === 1) {
                    set_end_M(parseInt(year),i,0);
                    set_start_D(parseInt(year),i);
                    set_end_D(parseInt(year),i,0);
                    $('#mc_start_month').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
                } else {
                    $('#mc_start_month').append("<option value=" + i + ">" + i + "</option>");
                }
            }
        }
    }

    //設定end月份的function
    function set_end_M(year,default_num,default_num2) {
        //if the start year equals to end year,the minimum date will be set to "the selected start month"
        const timestamp = new Date();
        $('#mc_end_month').empty();
        var month = new Date(timestamp + 8*60*60*1000).getMonth() + 1;
        if (parseInt(year) === (new Date(timestamp + 8*60*60*1000).getFullYear() - 1911)) {
            if((parseInt(month)===default_num)){
                for (var i = month; i < month + 1; i++) {
                    if (i === parseInt(month)) {
                        $('#mc_end_month').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
                    } else {
                        $('#mc_end_month').append("<option value=" + i + ">" + i + "</option>");                    
                    }
                }
            }else{
                for (var i = default_num; i < default_num + 1; i++) {
                    if (i === parseInt(default_num)) {
                        $('#mc_end_month').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
                    } else {
                        $('#mc_end_month').append("<option value=" + i + ">" + i + "</option>");                    
                    }
                }                
            }
        }else{
            for (var i = default_num; i < default_num + 1; i++) {
                if (i === parseInt(default_num)) {
                    $('#mc_end_month').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
                } else {
                    $('#mc_end_month').append("<option value=" + i + ">" + i + "</option>");                    
                }
            }               
        }

    }

    function set_start_year(){
        const timestamp = new Date();
        $('#mc_start_year').empty();
        //設定default值
        var iniyear = 108;
        var year = new Date(timestamp + 8*60*60*1000).getFullYear() - 1911;
        var month = new Date(timestamp + 8*60*60*1000).getMonth() + 1;
        for (var i = iniyear; i < year + 1; i++) {
            if (i === year) {
                $('#mc_start_year').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
            } else {
                $('#mc_start_year').append("<option value=" + i + ">" + i + "</option>");
            }
        }
    }

    function set_end_year(default_num){
        const timestamp = new Date();
        $('#mc_end_year').empty();
        //設定default值
        var year = new Date(timestamp + 8*60*60*1000).getFullYear() - 1911;
        var month = new Date(timestamp + 8*60*60*1000).getMonth() + 1;
        for (var i = default_num; i < default_num + 1; i++) {
            if (i === default_num) {
                $('#mc_end_year').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
            } else {
                $('#mc_end_year').append("<option value=" + i + ">" + i + "</option>");
            }
        }
        
    }

    // get year
    function search_current_period(){
        var start_month = $("#mc_start_month").children('option:selected').val();
        var start_year = $("#mc_start_year").children('option:selected').val();
        var end_year = $("#mc_end_year").children('option:selected').val();
        var end_month = $("#mc_end_month").children('option:selected').val();
        var start_date = $("#mc_start_date").children('option:selected').val();
        var end_date = $("#mc_end_date").children('option:selected').val();
        
    }

    function set_current_month(){
        const timestamp = new Date();
        var year = new Date(timestamp + 8*60*60*1000).getFullYear() - 1911;
        var month = new Date(timestamp + 8*60*60*1000).getMonth() + 1;
        var date = new Date(timestamp + 8*60*60*1000).getDate();
        set_start_year();
        set_end_year(year);
        $("#mc_start_year").val(year);
        $("#mc_end_year").val(year);
        $("#mc_start_month").val(month);
        $("#mc_end_month").val(month);
        $("#mc_start_date").val(1);
        $("#mc_end_date").val(date);

        var start_month = $("#mc_start_month").children('option:selected').val();
        var start_year = $("#mc_start_year").children('option:selected').val();
        var end_year = $("#mc_end_year").children('option:selected').val();
        var end_month = $("#mc_end_month").children('option:selected').val();
        var start_date = $("#mc_start_date").children('option:selected').val();
        var end_date = $("#mc_end_date").children('option:selected').val();
        var mc_id = $("#mc_id").children('option:selected').val();
    }

    function set_default_YMD (){
        const timestamp = new Date();
        var year = new Date(timestamp + 8*60*60*1000).getFullYear() - 1911;
        var month = new Date(timestamp + 8*60*60*1000).getMonth() + 1;

        //set now
        set_start_year();
        set_end_year(year);
        set_start_M(year);
        set_end_M(year,month,0);

        var start_month = $("#mc_start_month").children('option:selected').val();
        var start_year = $("#mc_start_year").children('option:selected').val();
        var end_year = $("#mc_end_year").children('option:selected').val();
        var end_month = $("#mc_end_month").children('option:selected').val();
        var start_date = $("#mc_start_date").children('option:selected').val();
        var end_date = $("#mc_end_date").children('option:selected').val();
        var mc_id = $("#mc_id").children('option:selected').val();
    }
    
    //設定一開始進入頁面的default值
    var update_default_YMD = function() {
        set_default_YMD();
        // output_id(year, month);

    }();

    //監聽select
    var listen_select = function() {
    const timestamp = new Date();
    var default_month = new Date(timestamp + 8*60*60*1000).getMonth() + 1;
    // console.log(default_month);
    var selected_id = $("#mc_id").children('option:selected').val();
    // console.log(selected_id);

    $("#mc_start_year").change(function() {
        var selected_year = $(this).children('option:selected').val();
        var selected_month = $("#mc_start_month").children('option:selected').val();
        set_end_year(parseInt(selected_year));
        set_start_M(parseInt(selected_year));
        var year = new Date(timestamp + 8*60*60*1000).getFullYear() - 1911;
        // set_end_M(parseInt(selected_year),parseInt(selected_month),0);
        output_id(selected_year, selected_month);
        // alert(selected_month);
        // console.log("selected:"+ selected_month);
    })

    $("#mc_end_year").change(function() {
        var selected_month = $("#mc_start_month").children('option:selected').val();
        var selected_year = $("#mc_end_year").children('option:selected').val();
        var end_year = $("#mc_end_year").children('option:selected').val();
        var end_month = $("#mc_end_month").children('option:selected').val();
        var selected_date = $("#mc_start_date").children('option:selected').val();

        if(parseInt(selected_year)===parseInt(end_year)){
            if(parseInt(selected_month)===parseInt(end_month)){
                set_end_M(parseInt(selected_year), parseInt(selected_month),parseInt(selected_date));
            }else{
                set_end_M(parseInt(selected_year), parseInt(selected_month),0);
            }
        }
        
    })

    $("#mc_start_month").change(function() {
        var selected_month = $("#mc_start_month").children('option:selected').val();
        var selected_year = $("#mc_start_year").children('option:selected').val();
        var end_year = $("#mc_end_year").children('option:selected').val();
        var end_month = $("#mc_end_month").children('option:selected').val();
        var selected_date = $("#mc_start_date").children('option:selected').val();

        set_end_M(parseInt(selected_year),parseInt(selected_month),parseInt(selected_date));
        set_start_D(parseInt(selected_year),parseInt(selected_month));
        set_end_D(parseInt(selected_year),parseInt(selected_month),0);
        // console.log(selected_month);
        output_id(selected_year, selected_month);
    });

    $("#mc_end_month").change(function() {
        var selected_month = $(this).children('option:selected').val();
        var selected_year = $("#mc_end_year").children('option:selected').val();
        var end_year = $("#mc_end_year").children('option:selected').val();
        var end_month = $("#mc_end_month").children('option:selected').val();
        var selected_date = $("#mc_start_date").children('option:selected').val();

        // console.log(selected_month);
        output_id(selected_year, selected_month);
    });

    $("#mc_start_date").change(function() {
        var selected_month = $("#mc_start_month").children('option:selected').val();
        var selected_year = $("#mc_start_year").children('option:selected').val();
        var end_year = $("#mc_end_year").children('option:selected').val();
        var end_month = $("#mc_end_month").children('option:selected').val();
        var selected_date = $(this).children('option:selected').val();
        set_end_D(parseInt(selected_year),parseInt(selected_month),parseInt(selected_date));
        // console.log(selected_month);
    });

}();
    // value="2018-07-22"
    //    min="2018-01-01" max="2018-12-31"
    var a = $('#startdate').val();
    console.log(a);
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
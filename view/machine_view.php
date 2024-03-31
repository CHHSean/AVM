<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../src/link_management.php'); ?>
    <?php include('../view/modal_share_view.php'); ?>
    <style>
        <?php include('../src/machine.css'); ?>
    </style>
    <!-- 管理報表 -->
    <title>機器</title>
</head>

<body style="background-color: #f2f2f2;">
    <?php include('../view/button_share_view.php'); ?>
    <div style="width:100%;background-color:white;padding-top:30px;">
        <div id="search_bar" style="margin:0 auto;display:flex;width:60%;height:auto;padding:30px;background-color:whitesmoke;font-size:20px;">
            <div id="search_bar_box" style="margin:0 auto;display:block;">
                <label>時間</label>
                <select id="mc_start_year">
                </select>
                <select id="mc_start_month">
                </select>
                <label style="margin-left:30px;">機器編號</label>
                <select id="mc_id">
                    <option value='null'>ALL</option>
                </select>
            </div>
        </div>
        <div id="graph-container" style="width:60%;height:auto;margin:0 auto;padding-top:30px;padding-bottom:50px;">
            <div style="width:60%;height:auto;margin:0 auto;padding-bottom:50px;">
                <canvas id="myChart" style='display: block;'></canvas>
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
    $('#btn_sel').show();
    $('#btn_mod').hide();
    $('#btn_del').hide();
    $('#btn_sel').hide();
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
    $('#up_table').show();
    $('#add_table').hide();

    $('#upload_btn').click(function() {
        $('#up_table').show();
        $('#add_table').hide();
    });
    $('#add_btn').click(function() {
        $('#add_table').show();
        $('#up_table').hide();
    });

    // 列出當月的machineID
    async function output_id(year, month) {
        var data = {
            OpType: 'setting_mc_id_option',
            Year: year,
            Month: month
        };
        await $.ajax({
            url: '../controller/machine_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
            // async: false,
        }).done(function(res) {
            // console.log("This:"+year+" "+month)
            // console.log(res);
            var str = JSON.parse(res);
            str = str.data;
            var l = str.length;
            $("#mc_id").empty();
            if (str.length != 0) {
                for (var i = 0; i < l; i++) {
                    $("#mc_id").append("<option value=" + str[i].mc_id + ">" + str[i].mc_id + "</option>");
                }
                $("#mc_id").append("<option value=" + null + ">" + "全部" + "</option>");
            } else {
                $("#mc_id").append("<option value=" + 0 + ">" + "無資料" + "</option>");
            }
            output_chart(year, month, $("#mc_id").children('option:selected').val());
        }).fail(function(error) {
            console.log(error);
        });
    }

    // 列出當月的chart資訊
    async function output_chart(year, month, mc_id) {
        var data = {
            OpType: 'Last_confirmation',
            Year: year,
            Month: month,
            mc_id: mc_id
        };
        await $.ajax({
            url: '../controller/machine_controller.php',
            data: data,
            dataType: 'text',
            type: 'POST',
            // async: false,
        }).done(function(res) {
            //console.log(res);
            var str = JSON.parse(res);
            str = str.data;
            console.log(str);
            var l = str.length;
            if (l == 0) {
                $('#myChart').remove();
                $('#graph-container').append('<div id="wrapper" style="height:70wh"><div id="myChart" style="margin:10 auto;padding:30px;background-color:#a5a5a5;color:white;" >查無資料<div></div>');
            }
            for (var i = 0; i < l; i++) {
                console.log(str[i]);
                del_with_chart(str[i], i);
            }

            // $("#mc_id").empty();
            // if(str.length!=0){             
            //     for (var i = 0; i < l; i++) {
            //         $("#mc_id").append("<option value=" + str[i].Row_id + ">" + str[i].mc_id + "</option>");
            //     }
            //     $("#mc_id").append("<option value=" + l + ">" + "全部" + "</option>");
            // }else{
            //     $("#mc_id").append("<option value=" + 0 + ">" + "無資料" + "</option>");
            // }

        }).fail(function(error) {
            console.log(error);
        });
    }


    //設定月份的function
    function set_M(year) {

        $('#mc_start_month').empty();
        if (year == (new Date().getFullYear() - 1911)) {
            var month = new Date().getMonth() + 1;
            for (var i = 1; i < month + 1; i++) {
                if (i == month) {
                    $('#mc_start_month').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
                } else {
                    $('#mc_start_month').append("<option value=" + i + ">" + i + "</option>");

                }
            }
        } else {
            for (var i = 1; i < 13; i++) {
                if (i == 1) {
                    $('#mc_start_month').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
                } else {
                    $('#mc_start_month').append("<option value=" + i + ">" + i + "</option>");
                }
            }
        }
    }

    //設定一開始進入頁面的default值
    var set_default_YM = function() {

        //設定default值
        var iniyear = 108;
        var year = new Date().getFullYear() - 1911;
        var month = new Date().getMonth() + 1;

        for (var i = iniyear; i < year + 1; i++) {
            if (i == year) {
                $('#mc_start_year').append("<option selected = 'selected' value=" + i + ">" + i + "</option>");
            } else {
                $('#mc_start_year').append("<option value=" + i + ">" + i + "</option>");
            }
        }

        set_M(year);
        output_id(year, month);

    }();

    //監聽select
    var listen_select = function() {

        var default_month = new Date().getMonth() + 1;
        // console.log(default_month);
        var selected_id = $("#mc_id").children('option:selected').val();
        // console.log(selected_id);

        $("#mc_start_year").change(function() {
            var selected_year = $(this).children('option:selected').val();
            set_M(selected_year);
            var selected_month = $("#mc_start_month").children('option:selected').val();
            // alert(selected_month);
            // console.log("selected:"+ selected_month);
            output_id(selected_year, selected_month);
        })

        $("#mc_start_month").change(function() {
            var selected_month = $(this).children('option:selected').val();
            var selected_year = $("#mc_start_year").children('option:selected').val();
            // console.log(selected_month);
            output_id(selected_year, selected_month);
        });

        $("#mc_id").change(function() {
            var selected_month = $("#mc_start_month").children('option:selected').val();
            var selected_year = $("#mc_start_year").children('option:selected').val();
            var mc_id = $(this).children('option:selected').val();
            // console.log(mc_id);
            output_chart(selected_year, selected_month, mc_id);
        });

    }();








    // sel_data_machine_cost_controller();
    // //將查詢到的資料印出，並處理其中的圖形
    // function sel_data_machine_cost_controller() {
    //     var data = {
    //         OpType: 'sel_data_machine_cost_controller',
    //     };
    //     $.ajax({
    //         url: '../controller/machine_cost_controller.php',
    //         data: data,
    //         dataType: "text",
    //         type: 'POST'
    //     }).done(function(res) {
    //         var obj = JSON.parse(res);
    //         del_with_chart(obj);
    //     }).fail(function(error) {
    //         console.log(error);
    //     });
    // };

    function del_with_chart(obj, num) {

        console.log(num);
        var chart_list = [];
        chart_list.push(obj.mc_dep_expense, obj.mc_water_cost, obj.mc_electricity_cost, obj.mc_fuel_cost, obj.mc_maintenance_cost, obj.mc_upkeep_cost, obj.mc_rental_expense, obj.mc_parts_cost, obj.mc_other_cost1, obj.mc_other_cost2, obj.mc_other_cost3, obj.mc_other_cost4, obj.mc_other_cost5, obj.mc_total_expense);
        var month = obj.mc_start_month;

        var id;
        if (num == 0) {
            id = 'myChart';
        } else {
            id = 'myChart' + num;
        }
        if ((obj != null)) {
            if (num == 0) {
                $('#graph-container').empty()
            }
            $('#graph-container').append('<canvas id="' + id + '" style="padding:30px;border:solid #f2f2f2 0.1px;margin-top:20px;margin-bottom:40px;border-radius:10px;box-shadow: 3px 3px 5px #e5e5e5;" ><canvas>');
        }

        var selected_month = $("#mc_start_month").children('option:selected').val();
        var mc_id = obj.mc_id;
        var myChart = new Chart(document.getElementById(id).getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['折舊費用', '水費', '電費', '燃油費', '保養費', '維修費', '場地費', '零件費', '其他費用1', '其他費用2', '其他費用3', '其他費用4', '其他費用5', '總費用'],
                datasets: [{
                    label: selected_month + '月 機器' + mc_id,
                    data: chart_list,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.4)',
                        'rgba(54, 162, 235, 0.4)',
                        'rgba(255, 206, 86, 0.4)',
                        'rgba(75, 192, 192, 0.4)',
                        'rgba(153, 102, 255, 0.4)',
                        'rgba(239, 119, 0, 0.4)',
                        'rgba(67, 165, 1, 0.4)',
                        'rgba(132, 0, 57, 0.4)',
                        'rgba(120, 120, 120, 0.4)',
                        'rgba(120, 120, 120, 0.4)',
                        'rgba(120, 120, 120, 0.4)',
                        'rgba(120, 120, 120, 0.4)',
                        'rgba(120, 120, 120, 0.4)',
                        'rgba(255, 80, 0, 0.4)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(239, 119, 0, 1)',
                        'rgba(67, 165, 1, 1)',
                        'rgba(132, 0, 57, 1)',
                        'rgba(120, 120, 120, 1)',
                        'rgba(120, 120, 120, 1)',
                        'rgba(120, 120, 120, 1)',
                        'rgba(120, 120, 120, 1)',
                        'rgba(120, 120, 120, 1)',
                        'rgba(255, 80, 0,)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    labels: {
                        boxWidth: 0,
                        fontSize: 22,
                        fontColor: '#191919'
                    }
                }
            }
        });

    }
    Chart.Legend.prototype.afterFit = function() {
        this.height = this.height + 50;
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
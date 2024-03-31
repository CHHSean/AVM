<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../src/link_management.php'); ?>
    <?php include('../view/modal_share_view.php'); ?>
    <style>
        <?php include('../src/realtime_view.css'); ?>
    </style>
    <title>即時系統戰情室</title>
</head>

<body>
    <div class="back_div_position mt-3 mb-3 ml-3">
        <button type="button" class="btn btn-outline-danger" id='btn_back'>上一頁</button>
    </div>
    <div id="up_table">
        <div class="container">
            <div class="row align-items-end">
                <div class="col">
                    <span class="chart-title">工廠管理</span>
                    <div class="row">
                        <div class="col-sm">
                            <canvas id="barChart" height=250>
                                工廠成本
                        </div>
                        <div class="col-sm">
                            <canvas id="barChart_2" height=250>
                                內部失敗作業成本
                        </div>
                        <div class="col-sm">
                            <canvas id="barChart_3" height=250>
                                無生產力作業成本
                        </div>
                    </div>
                    <!-- <canvas id="barChart" width=100 height=10></canvas> -->
                </div>
            </div>
            <div class="row align-items-end">
                <div class="col">
                    <span class="chart-title">產品管理</span>
                    <div class="row">
                        <div class="col-sm">
                            <canvas id="product_Chart1">
                                產品成本最高前五名
                        </div>
                        <div class="col-sm">
                            <canvas id="product_Chart2">
                                完成數量與每單位成本
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-end">
                <div class="col">
                    <span class="chart-title">工單管理</span>
                    <canvas id="work_order_Chart" width=800 height=180></canvas>
                </div>
            </div>
            <div class="row align-items-end">
                <div class="col">
                    <span class="chart-title">產能管理</span>
                    <div class="row">
                    <div class="col-sm">
                        <canvas id="capacity_Chart1" height=250>
                            全部工單之產能屬性成本佔比圖
                    </div>
                    <div class="col-sm">
                        <canvas id="capacity_Chart2" height=210>
                            無生產力作業成本
                    </div>
                    <div class="col-sm">
                        <canvas id="capacity_Chart3" height=250>
                            無生產力作業成本發生之原因
                    </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-end">
                <div class="col">
                    <span class="chart-title">品質管理</span>
                    <div class="row">
                    <div class="col-sm">
                        <canvas id="property_Chart1" height=250>
                            全部工單之品質屬性成本佔比圖
                    </div>
                    <div class="col-sm">
                        <canvas id="property_Chart2" height=210>
                            內部失敗作業成本
                    </div>
                    <div class="col-sm">
                        <canvas id="property_Chart3" height=250>
                            內部失敗作業成本發生之原因
                    </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-end" style="margin-bottom: 50px;">
                <div class="col">
                    <span class="chart-title">作業管理</span>
                    <canvas id="work_num_Chart" width=800 height=180></canvas>
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
    // $(document).ready(function() {
    //     $('#realtime_table').DataTable();
    //     api_real_data();
    // });
    $('table').dataTable({
        searching: false,
        info: false
    })

    //-------------------------------------------------------
    //工廠管理(工廠成本)
    // api_factory_manage_1_data = {
    //     "real_data": [{
    //         "Status": true,
    //         "Date_Start": "2021-09-07 10:00:00",
    //         "Date_End": "2021-09-08 10:00:00",
    //         "Type": 3,
    //         "Data": [{
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "D123",
    //                 "Machine_ID": "Machine001",
    //                 "Process_ID": "P1",
    //                 "Staff_ID": "Daudin001",
    //                 "Material_Part_No": "AB522",
    //                 "Part_Quantity": 500,
    //                 "BOM_Version": "B01",
    //                 "Update_Machine_Time": 900,
    //                 "Update_Staff_Time": 900
    //             }, 
    //                 "Date": "2021-10-07",
    //                 "Work_Ticked_No": "D123",
    //                 "Machine_ID": "Machine001",
    //                 "Process_ID": "P1",
    //                 "Staff_ID": "Daudin001",
    //                 "Material_Part_No": "AB522",
    //                 "Part_Quantity": 300,
    //                 "BOM_Version": "B01",
    //                 "Update_Machine_Time": 200,
    //                 "Update_Staff_Time": 700
    //             },
    //             {
    //                 "Date": "2021-10-06",
    //                 "Work_Ticked_No": "D123",
    //                 "Machine_ID": "Machine001",
    //                 "Process_ID": "P1",
    //                 "Staff_ID": "Daudin001",
    //                 "Material_Part_No": "AB522",
    //                 "Part_Quantity": 700,
    //                 "BOM_Version": "B01",
    //                 "Update_Machine_Time": 200,
    //                 "Update_Staff_Time": 100
    //             },
    //             {
    //                 "Date": "2021-10-05",
    //                 "Work_Ticked_No": "D123",
    //                 "Machine_ID": "Machine001",
    //                 "Process_ID": "P1",
    //                 "Staff_ID": "Daudin001",
    //                 "Material_Part_No": "AB522",
    //                 "Part_Quantity": 700,
    //                 "BOM_Version": "B01",
    //                 "Update_Machine_Time": 300,
    //                 "Update_Staff_Time": 700
    //             },
    //             {
    //                 "Date": "2021-10-04",
    //                 "Work_Ticked_No": "D123",
    //                 "Machine_ID": "Machine001",
    //                 "Process_ID": "P1",
    //                 "Staff_ID": "Daudin001",
    //                 "Material_Part_No": "AB522",
    //                 "Part_Quantity": 100,
    //                 "BOM_Version": "B01",
    //                 "Update_Machine_Time": 300,
    //                 "Update_Staff_Time": 700
    //             },

    //         ]
    //     }]
    // }
    // var len = api_factory_manage_1_data.real_data[0].Data.length
    // console.log(len);
    // console.log('----------------');
    // api_factory_manage_1();
    // api_factory_manage_2();
    // api_factory_manage_3();
    async function api_factory_manage_1() {

            var today = new Date();
            var endtoday = new Date();
            var Today = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate()+ " 00:00:00";
            var endtoday = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate()+ " " + today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            // console.log(Today);
            // console.log(endtoday);
            dataJSON = {
                    // "Date_Start": "2022-02-23 00:00:00",
                    // "Date_End": "2022-02-24 00:00:00",
                    "Date_Start": Today,
                    "Date_End": endtoday,
                    "Type": 1,
            }
            // console.log(dataJSON)
        await $.ajax({
           type: "POST",
           data: JSON.stringify(dataJSON),
           url: "http://192.168.83.200:8022/AVM/Dashboard",
           dataType: "json",
           contentType: "application/json;charset=utf-8"
        }).done(function(res) {
        var data = res;
        console.log(res);
        // factory_manage_1_controller(data);
        })
        
        // console.log(data);
    };
    async function factory_manage_1_controller(data) {
        await $.ajax({
            url: '../controller/real_time_machine_controller.php',
            data: {
                'OpType': 'factory_manage_1',
                // 'real_data': data.real_data
                'real_data': data
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            // console.log('工廠成本');
            var d_list = sortJSON(obj, 'Date', 'DEC');
            build_factory_chart(d_list, 1, '工廠成本');
        })
    };
    async function api_factory_manage_2() {
        factory_manage_2_controller(api_factory_manage_1_data);

    };
    async function factory_manage_2_controller(api_factory_manage_1_data) {
        await $.ajax({
            url: '../controller/real_time_machine_controller.php',
            data: {
                'OpType': 'factory_manage_2',
                'real_data': api_factory_manage_1_data.real_data
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            // console.log('內部失敗作業成本');
            var d_list = sortJSON(obj, 'Date', 'DEC');
            build_factory_chart(d_list, 2, '內部失敗作業成本');
        })
    };

    async function api_factory_manage_3() {
        factory_manage_3_controller(api_factory_manage_1_data);

    };
    async function factory_manage_3_controller(api_factory_manage_1_data) {
        await $.ajax({
            url: '../controller/real_time_machine_controller.php',
            data: {
                'OpType': 'factory_manage_3',
                'real_data': api_factory_manage_1_data.real_data
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            // console.log('無生產力作業成本');
            var d_list = sortJSON(obj, 'Date', 'DEC');
            build_factory_chart(d_list, 3, '無生產力作業成本');
        })
    };

    //產品管理
    // api_product_data = {
    //     "real_data": [{
    //         "Status": true,
    //         "Date_Start": "2021-10-01 10:00:00",
    //         "Date_End": "2021-10-08 10:00:00",
    //         "Type": 1,
    //         "Data": [{
    //                 "Material_Part_No": "D-0900",
    //                 'M': [{
    //                         "Date": "2021-10-13",
    //                         "Work_Ticked_No": "WT-0900",
    //                         "Counters": 100,
    //                         "Machine_ID": "Machine001",
    //                         "Staff_ID": "Daudin001",
    //                         "BOM_Version": "B1",
    //                         "Update_Machine_Time": 500,
    //                         "Update_Staff_Time": 500
    //                     },
    //                     {
    //                         "Date": "2021-10-13",
    //                         "Work_Ticked_No": "WT-0901",
    //                         "Counters": 150,
    //                         "Machine_ID": "Machine002",
    //                         "Staff_ID": "Daudin002",
    //                         "BOM_Version": "B1",
    //                         "Update_Machine_Time": 800,
    //                         "Update_Staff_Time": 800
    //                     }
    //                 ]
    //             },
    //             {
    //                 "Material_Part_No": "D-0901",
    //                 'M': [{
    //                         "Date": "2021-10-13",
    //                         "Work_Ticked_No": "WT-0900",
    //                         "Counters": 120,
    //                         "Machine_ID": "Machine001",
    //                         "Staff_ID": "Daudin001",
    //                         "BOM_Version": "B1",
    //                         "Update_Machine_Time": 900,
    //                         "Update_Staff_Time": 900
    //                     },
    //                     {
    //                         "Date": "2021-10-13",
    //                         "Work_Ticked_No": "WT-0901",
    //                         "Counters": 160,
    //                         "Machine_ID": "Machine002",
    //                         "Staff_ID": "Daudin002",
    //                         "BOM_Version": "B1",
    //                         "Update_Machine_Time": 800,
    //                         "Update_Staff_Time": 800
    //                     }
    //                 ]
    //             },
    //             {
    //                 "Material_Part_No": "D-0902",
    //                 'M': [{
    //                         "Date": "2021-10-13",
    //                         "Work_Ticked_No": "WT-0900",
    //                         "Counters": 250,
    //                         "Machine_ID": "Machine001",
    //                         "Staff_ID": "Daudin001",
    //                         "BOM_Version": "B1",
    //                         "Update_Machine_Time": 900,
    //                         "Update_Staff_Time": 900
    //                     },
    //                     {
    //                         "Date": "2021-10-13",
    //                         "Work_Ticked_No": "WT-0901",
    //                         "Counters": 210,
    //                         "Machine_ID": "Machine002",
    //                         "Staff_ID": "Daudin002",
    //                         "BOM_Version": "B1",
    //                         "Update_Machine_Time": 750,
    //                         "Update_Staff_Time": 700
    //                     }
    //                 ]
    //             },
    //             {
    //                 "Material_Part_No": "D-0903",
    //                 'M': [{
    //                         "Date": "2021-10-13",
    //                         "Work_Ticked_No": "WT-0900",
    //                         "Counters": 140,
    //                         "Machine_ID": "Machine001",
    //                         "Staff_ID": "Daudin001",
    //                         "BOM_Version": "B1",
    //                         "Update_Machine_Time": 950,
    //                         "Update_Staff_Time": 900
    //                     },
    //                     {
    //                         "Date": "2021-10-13",
    //                         "Work_Ticked_No": "WT-0901",
    //                         "Counters": 120,
    //                         "Machine_ID": "Machine002",
    //                         "Staff_ID": "Daudin002",
    //                         "BOM_Version": "B1",
    //                         "Update_Machine_Time": 800,
    //                         "Update_Staff_Time": 850
    //                     }
    //                 ]
    //             },
    //             {
    //                 "Material_Part_No": "D-0904",
    //                 'M': [{
    //                         "Date": "2021-10-13",
    //                         "Work_Ticked_No": "WT-0900",
    //                         "Counters": 270,
    //                         "Machine_ID": "Machine001",
    //                         "Staff_ID": "Daudin001",
    //                         "BOM_Version": "B1",
    //                         "Update_Machine_Time": 900,
    //                         "Update_Staff_Time": 900
    //                     },
    //                     {
    //                         "Date": "2021-10-13",
    //                         "Work_Ticked_No": "WT-0900",
    //                         "Counters": 130,
    //                         "Machine_ID": "Machine002",
    //                         "Staff_ID": "Daudin002",
    //                         "BOM_Version": "B1",
    //                         "Update_Machine_Time": 800,
    //                         "Update_Staff_Time": 800
    //                     }
    //                 ]
    //             },
    //             {
    //                 "Material_Part_No": "D-0905",
    //                 'M': [{
    //                         "Date": "2021-10-13",
    //                         "Work_Ticked_No": "WT-0900",
    //                         "Counters": 140,
    //                         "Machine_ID": "Machine001",
    //                         "Staff_ID": "Daudin001",
    //                         "BOM_Version": "B1",
    //                         "Update_Machine_Time": 900,
    //                         "Update_Staff_Time": 900
    //                     },
    //                     {
    //                         "Date": "2021-10-13",
    //                         "Work_Ticked_No": "WT-0900",
    //                         "Counters": 150,
    //                         "Machine_ID": "Machine002",
    //                         "Staff_ID": "Daudin002",
    //                         "BOM_Version": "B1",
    //                         "Update_Machine_Time": 800,
    //                         "Update_Staff_Time": 800
    //                     }
    //                 ]
    //             },
    //         ]
    //     }]
    // }
    // api_product_manage_1();
    // api_product_manage_2();
    async function api_product_manage_1() {
        // product_manage_1_controller(api_product_data);
        var today = new Date();
        var endtoday = new Date();
        var Today = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate()+ " 00:00:00";
        var endtoday = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate()+ " " + today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        // console.log(Today);
        // console.log(endtoday);
        dataJSON = {
                // "Date_Start": "2022-02-23 00:00:00",
                // "Date_End": "2022-02-24 00:00:00",
                "Date_Start": Today,
                "Date_End": endtoday,
                "Type": 1,
        }
            // console.log(dataJSON)
        await $.ajax({
           type: "POST",
           data: JSON.stringify(dataJSON),
           url: "http://192.168.83.200:8022/AVM/Dashboard",
           dataType: "json",
           contentType: "application/json;charset=utf-8"
        }).done(function(res) {
        var data = res;
        console.log(res);
            product_manage_1_controller(data);
        })
    };

    async function product_manage_1_controller(api_product_data) {
        await $.ajax({
            url: '../controller/real_time_machine_controller.php',
            data: {
                'OpType': 'product_manage_1',
                // 'real_data': api_product_data.real_data
                'real_data': api_product_data
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            // console.log('產品成本最高前五名');
            var d_list = sortJSON(obj, 'cost', 'DEC');
            build_product_chart(d_list, 1, '產品成本最高前五名');
        })
    }

    async function api_product_manage_2() {
        product_manage_2_controller(api_product_data);
    };

    async function product_manage_2_controller(api_product_data) {
        await $.ajax({
            url: '../controller/real_time_machine_controller.php',
            data: {
                'OpType': 'product_manage_2',
                'real_data': api_product_data.real_data
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            // console.log('完成數量及每單位成本');
            var d_list = sortJSON(obj, 'cost', 'DEC');
            build_product_chart(d_list, 2, '完成數量及每單位成本');
        })
    }



    //工單管理
    // api_work_order_data = {
    //     "real_data": [{
    //         "Status": true,
    //         "Date_Start": "2021-09-07 10:00:00",
    //         "Date_End": "2021-09-08 10:00:00",
    //         "Type": 4,
    //         "Data": [{
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0900",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P1",
    //                 "Update_Machine_Time": 1800,
    //                 "Update_Staff_Time": 1500
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0901",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P1",
    //                 "Update_Machine_Time": 500,
    //                 "Update_Staff_Time": 400
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0902",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P1",
    //                 "Update_Machine_Time": 300,
    //                 "Update_Staff_Time": 200
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0903",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P1",
    //                 "Update_Machine_Time": 700,
    //                 "Update_Staff_Time": 600
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0904",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P1",
    //                 "Update_Machine_Time": 500,
    //                 "Update_Staff_Time": 700
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0905",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P1",
    //                 "Update_Machine_Time": 900,
    //                 "Update_Staff_Time": 2000
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0906",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P1",
    //                 "Update_Machine_Time": 1500,
    //                 "Update_Staff_Time": 1200
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0907",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P1",
    //                 "Update_Machine_Time": 300,
    //                 "Update_Staff_Time": 700
    //             }, {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0908",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P1",
    //                 "Update_Machine_Time": 400,
    //                 "Update_Staff_Time": 700
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0909",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P1",
    //                 "Update_Machine_Time": 100,
    //                 "Update_Staff_Time": 700
    //             },
    //         ]
    //     }]
    // }
    api_work_order();
    async function api_work_order() {
        // work_order_controller(api_work_order_data);
        var today = new Date();
        var endtoday = new Date();
        var Today = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate()+ " 00:00:00";
        var endtoday = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate()+ " " + today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        // console.log(Today);
        // console.log(endtoday);
        dataJSON = {
                // "Date_Start": "2022-02-23 00:00:00",
                // "Date_End": "2022-02-24 00:00:00",
                "Date_Start": Today,
                "Date_End": endtoday,
                "Type": 4,
        }
            // console.log(dataJSON)
        await $.ajax({
           type: "POST",
           data: JSON.stringify(dataJSON),
           url: "http://192.168.83.200:8022/AVM/Dashboard",
           dataType: "json",
           contentType: "application/json;charset=utf-8"
        }).done(function(res) {
        var data = res;
        console.log(res);
            work_order_controller(data);
        })
    };

    async function work_order_controller(api_work_order_data) {
        await $.ajax({
            url: '../controller/real_time_machine_controller.php',
            data: {
                'OpType': 'work_order',
                // 'real_data': api_work_order_data.real_data
                'real_data': api_work_order_data
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // fetch(res).then(response => response.json())
            // fetch(res).then(async response => {
            // try {
            // const data = await response.json()
            //     console.log('response data?', data) 
            // } catch(error) {
            // console.log('Error happened here!')
            // console.error(error)
            // }
            // })
            console.log("test");
            console.log(res);
            var obj = JSON.parse(res);
            // console.log("test");
            // console.log(obj);
            // console.log('工單成本最高前10名');
            var d_list = sortJSON(obj, 'cost', 'DEC');
            build_work_order_chart(d_list, 1, '工單成本最高前10名');
        })
    }

    //作業管理
    api_work_num_data = {
        "real_data": [{
            "Status": true,
            "Date_Start": "2021-09-07 10:00:00",
            "Date_End": "2021-09-08 10:00:00",
            "Type": 4,
            "Data": [{
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0900",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P1",
                    "Update_Machine_Time": 1800,
                    "Update_Staff_Time": 2000
                }, {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0900",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P2",
                    "Update_Machine_Time": 1700,
                    "Update_Staff_Time": 1200
                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0900",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P3",
                    "Update_Machine_Time": 300,
                    "Update_Staff_Time": 500
                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0900",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P4",
                    "Update_Machine_Time": 1400,
                    "Update_Staff_Time": 1700
                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0900",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P5",
                    "Update_Machine_Time": 800,
                    "Update_Staff_Time": 100
                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0900",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P6",
                    "Update_Machine_Time": 400,
                    "Update_Staff_Time": 200
                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0900",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P7",
                    "Update_Machine_Time": 300,
                    "Update_Staff_Time": 600
                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0900",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P8",
                    "Update_Machine_Time": 1800,
                    "Update_Staff_Time": 1500
                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0900",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P9",
                    "Update_Machine_Time": 3000,
                    "Update_Staff_Time": 2000,
                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0900",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P10",
                    "Update_Machine_Time": 200,
                    "Update_Staff_Time": 300
                },

            ]
        }]
    }
    // api_work_num();
    async function api_work_num() {
        work_num_controller(api_work_num_data);
    };

    async function work_num_controller(api_work_num_data) {
        await $.ajax({
            url: '../controller/real_time_machine_controller.php',
            data: {
                'OpType': 'work_num',
                'real_data': api_work_num_data.real_data
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            // console.log('作業成本排名分析');
            var d_list = sortJSON(obj, 'cost', 'DEC');
            build_work_num_chart(d_list, 1, '作業成本排名分析');
        })
    }

    //產能管理
    // api_capacity_data = {
    //     "real_data": [{
    //         "Status": true,
    //         "Date_Start": "2021-09-07 10:00:00",
    //         "Date_End": "2021-09-08 10:00:00",
    //         "Type": 2,
    //         "Data": [{
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0900",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P1",
    //                 "Update_Machine_Time": 900,
    //                 "Update_Staff_Time": 900,
    //                 "Reason": "員工操作不當"
    //             }, {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0901",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P2",
    //                 "Update_Machine_Time": 400,
    //                 "Update_Staff_Time": 700,
    //                 "Reason": "Reason_2"
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0902",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P3",
    //                 "Update_Machine_Time": 500,
    //                 "Update_Staff_Time": 200,
    //                 "Reason": "Reason_3"
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0903",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P4",
    //                 "Update_Machine_Time": 700,
    //                 "Update_Staff_Time": 100,
    //                 "Reason": "Reason_4"
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0904",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P5",
    //                 "Update_Machine_Time": 300,
    //                 "Update_Staff_Time": 700,
    //                 "Reason": "機台無預警停機"
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0905",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P6",
    //                 "Update_Machine_Time": 400,
    //                 "Update_Staff_Time": 800,
    //                 "Reason": "機台維修"
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0906",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P7",
    //                 "Update_Machine_Time": 700,
    //                 "Update_Staff_Time": 400,
    //                 "Reason": "員工備料失誤"
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0907",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P8",
    //                 "Update_Machine_Time": 200,
    //                 "Update_Staff_Time": 300,
    //                 "Reason": "Reason_8"
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0908",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P9",
    //                 "Update_Machine_Time": 200,
    //                 "Update_Staff_Time": 100,
    //                 "Reason": "Reason_9"
    //             },
    //             {
    //                 "Date": "2021-10-08",
    //                 "Work_Ticked_No": "WT-0909",
    //                 "Machine_ID": "Machine001",
    //                 "Staff_ID": "Daudin001",
    //                 "Process_ID": "P10",
    //                 "Update_Machine_Time": 900,
    //                 "Update_Staff_Time": 200,
    //                 "Reason": "排程失誤"
    //             },
    //         ]
    //     }]
    // }
    // api_capacity_manage_1();
    // api_capacity_manage_2();
    // api_capacity_manage_3();
    async function api_capacity_manage_1() {
        var today = new Date();
        var endtoday = new Date();
        var Today = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate()+ " 00:00:00";
        var endtoday = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate()+ " " + today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        dataJSON = {
                "Date_Start": Today,
                "Date_End": endtoday,
                "Type": 2,
        }
        // console.log(dataJSON)
        await $.ajax({
           type: "POST",
           data: JSON.stringify(dataJSON),
           url: "http://192.168.83.200:8022/AVM/Dashboard",
           dataType: "json",
           contentType: "application/json;charset=utf-8"
        }).done(function(res) {
            var data = res;
            console.log(res);
            capacity_manage_1_controller(data);
        })
    };

    async function capacity_manage_1_controller(api_capacity_data) {
        await $.ajax({
            url: '../controller/real_time_machine_controller.php',
            data: {
                'OpType': 'capacity_manage_1',
                'real_data': api_capacity_data
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            // console.log('全部工單之產能屬性成本佔比圖');
            var d_list = sortJSON(obj, 'cost', 'DEC');
            build_capacity_manage_chart(d_list, 1, '全部工單之產能屬性成本佔比圖');
        })
    }

    async function api_capacity_manage_2() {
        capacity_manage_2_controller(api_capacity_data);
    };

    async function capacity_manage_2_controller(api_capacity_data) {
        await $.ajax({
            url: '../controller/real_time_machine_controller.php',
            data: {
                'OpType': 'capacity_manage_2',
                'real_data': api_capacity_data.real_data
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            // console.log('無生產力作業成本前五名');
            var d_list = sortJSON(obj, 'cost', 'DEC');
            build_capacity_manage_chart(d_list, 2, '無生產力作業成本前五名');
        })
    }

    async function api_capacity_manage_3() {
        capacity_manage_3_controller(api_capacity_data);
    };

    async function capacity_manage_3_controller(api_capacity_data) {
        await $.ajax({
            url: '../controller/real_time_machine_controller.php',
            data: {
                'OpType': 'capacity_manage_3',
                'real_data': api_capacity_data.real_data
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            // console.log('無生產力作業成本發生之原因');
            var d_list = sortJSON(obj, 'cost', 'DEC');
            build_capacity_manage_chart(d_list, 3, '無生產力作業成本發生之原因');
        })
    }

    //品質管理
    api_property_data = {
        "real_data": [{
            "Status": true,
            "Date_Start": "2021-09-07 10:00:00",
            "Date_End": "2021-09-08 10:00:00",
            "Type": 3,
            "Data": [{
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0900",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P1",
                    "Update_Machine_Time": 900,
                    "Update_Staff_Time": 900,
                    "Reason": "員工操作不當"

                }, {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0901",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P2",
                    "Update_Machine_Time": 800,
                    "Update_Staff_Time": 200,
                    "Reason": "Reason_2"

                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0902",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P3",
                    "Update_Machine_Time": 700,
                    "Update_Staff_Time": 100,
                    "Reason": "Reason_3"

                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0903",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P4",
                    "Update_Machine_Time": 300,
                    "Update_Staff_Time": 600,
                    "Reason": "Reason_4"

                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0904",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P5",
                    "Update_Machine_Time": 500,
                    "Update_Staff_Time": 400,
                    "Reason": "機台無預警停機"

                }, {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0905",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P6",
                    "Update_Machine_Time": 400,
                    "Update_Staff_Time": 400,
                    "Reason": "員工教育訓練不足"

                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0906",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P7",
                    "Update_Machine_Time": 500,
                    "Update_Staff_Time": 300,
                    "Reason": "機台設定失誤"

                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0907",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P8",
                    "Update_Machine_Time": 500,
                    "Update_Staff_Time": 200,
                    "Reason": "Reason_8"

                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0908",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P9",
                    "Update_Machine_Time": 700,
                    "Update_Staff_Time": 200,
                    "Reason": "Reason_9"

                },
                {
                    "Date": "2021-10-08",
                    "Work_Ticked_No": "WT-0909",
                    "Machine_ID": "Machine001",
                    "Staff_ID": "Daudin001",
                    "Process_ID": "P10",
                    "Update_Machine_Time": 900,
                    "Update_Staff_Time": 100,
                    "Reason": "原材料損壞"

                },
            ]
        }]
    }
    // api_property_manage_1();
    // api_property_manage_2();
    // api_property_manage_3();
    async function api_property_manage_1() {
        property_manage_1_controller(api_property_data);
    };

    async function property_manage_1_controller(api_property_data) {
        await $.ajax({
            url: '../controller/real_time_machine_controller.php',
            data: {
                'OpType': 'property_manage_1',
                'real_data': api_property_data.real_data
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            // console.log('全部工單之品質屬性成本佔比圖');
            var d_list = sortJSON(obj, 'cost', 'DEC');
            build_property_manage_chart(d_list, 1, '全部工單之品質屬性成本佔比圖');
        })
    }

    async function api_property_manage_2() {
        property_manage_2_controller(api_property_data);
    };

    async function property_manage_2_controller(api_property_data) {
        await $.ajax({
            url: '../controller/real_time_machine_controller.php',
            data: {
                'OpType': 'property_manage_2',
                'real_data': api_property_data.real_data
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            // console.log('內部失敗作業成本前五名');
            var d_list = sortJSON(obj, 'cost', 'DEC');
            build_property_manage_chart(d_list, 2, '內部失敗作業成本前五名');
        })
    }

    async function api_property_manage_3() {
        property_manage_3_controller(api_property_data);
    };

    async function property_manage_3_controller(api_property_data) {
        await $.ajax({
            url: '../controller/real_time_machine_controller.php',
            data: {
                'OpType': 'property_manage_3',
                'real_data': api_property_data.real_data
            },
            dataType: "text",
            type: 'POST'
        }).done(function(res) {
            // console.log(res);
            var obj = JSON.parse(res);
            // console.log(obj);
            // console.log('內部失敗作業成本發生之原因');
            var d_list = sortJSON(obj, 'cost', 'DEC');
            build_property_manage_chart(d_list, 3, '內部失敗作業成本發生之原因');
        })
    }




    //-------------------------------------------------------
    // //工單
    // data = {
    //     "real_data": [
    //         "{\"EMP_NO\": \"EMP_03\", \"MCM_NO\": \"#24\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355345\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 0.47, \"mcm_work_time\": 0.47}",
    //         "{\"EMP_NO\": \"EMP_07\", \"MCM_NO\": \"#25\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355350\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 1.42, \"mcm_work_time\": 1.42}",
    //         "{\"EMP_NO\": \"EMP_07\", \"MCM_NO\": \"#26\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355351\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 1.12, \"mcm_work_time\": 1.12}",
    //         "{\"EMP_NO\": \"EMP_04\", \"MCM_NO\": \"#27\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355350\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 2.33, \"mcm_work_time\": 2.33}",
    //         "{\"EMP_NO\": \"EMP_01\", \"MCM_NO\": \"#28\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355350\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 2.52, \"mcm_work_time\": 3.22}",
    //         "{\"EMP_NO\": \"EMP_04\", \"MCM_NO\": \"#28\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355350\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 0.18, \"mcm_work_time\": 3.22}",
    //         "{\"EMP_NO\": \"EMP_02\", \"MCM_NO\": \"#29\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355345\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 0.32, \"mcm_work_time\": 0.32}",
    //         "{\"EMP_NO\": \"EMP_03\", \"MCM_NO\": \"#30\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355345\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 0.23, \"mcm_work_time\": 0.23}",
    //         "{\"EMP_NO\": \"EMP_03\", \"MCM_NO\": \"#24\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355345\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 0.47, \"mcm_work_time\": 0.47}",
    //         "{\"EMP_NO\": \"EMP_07\", \"MCM_NO\": \"#25\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355350\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 1.42, \"mcm_work_time\": 1.42}",
    //         "{\"EMP_NO\": \"EMP_07\", \"MCM_NO\": \"#26\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355350\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 1.12, \"mcm_work_time\": 1.12}",
    //         "{\"EMP_NO\": \"EMP_04\", \"MCM_NO\": \"#27\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355350\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 2.33, \"mcm_work_time\": 2.33}",
    //         "{\"EMP_NO\": \"EMP_01\", \"MCM_NO\": \"#28\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355350\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 2.52, \"mcm_work_time\": 3.22}",
    //         "{\"EMP_NO\": \"EMP_04\", \"MCM_NO\": \"#28\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355350\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 0.18, \"mcm_work_time\": 3.22}",
    //         "{\"EMP_NO\": \"EMP_02\", \"MCM_NO\": \"#29\", \"PART_NO\": \"A107B002444\", \"ORDER_NO\": \"s04355345\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\", \"emp_work_time\": 0.32, \"mcm_work_time\": 0.32}",

    //     ]
    // };
    // data1 = {
    //     "real_data": []
    // }
    // var len = data.real_data.length;
    // for (var i = 0; i < len; i++) {
    //     var str = data.real_data[i].substring(1, data.real_data[i].length - 1).replace(/(?![\. }])(\"*)/g, '')
    //     // console.log(str)
    //     var arr = str.split(',');
    //     // console.log(arr);
    //     var obj = {};
    //     for (var j = 0; j < arr.length; j++) {
    //         row = arr[j].split(':');
    //         var key = row[0].trim();
    //         var value = row[1].trim();
    //         obj[key] = value;
    //     }
    //     data1.real_data[i] = obj;
    // };
    // // console.log(data);
    // api_work_order_data();
    // var api = '尚未串接';
    // async function api_work_order_data() {
    //     //     var today = new Date();
    //     //     var Today = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
    //     //     // console.log(Today);
    //     //     dataJSON = {
    //     //         "START_DATE": Today,
    //     //         "END_DATE": Today
    //     //     }
    //     // await $.ajax({
    //     //    type: 'POST',
    //     //    data: JSON.stringify(dataJSON),
    //     //    url: api,
    //     //    contentType: "application/json;charset=utf-8"
    //     // }).done(function(res) {
    //     //     // console.log(res);
    //     // var len = data.real_data.length;
    //     // for (var i = 0; i < len; i++) {
    //     //     var str = data.real_data[i].substring(1, data.real_data[i].length - 1).replace(/(?![\. }])(\"*)/g, '')
    //     //     // console.log(str)
    //     //     var arr = str.split(',');
    //     //     // console.log(arr);
    //     //     var obj = {};
    //     //     for (var j = 0; j < arr.length; j++) {
    //     //         row = arr[j].split(':');
    //     //         var key = row[0].trim();
    //     //         var value = row[1].trim();
    //     //         obj[key] = value;
    //     //     }
    //     //     data.real_data[i] = obj;
    //     // };
    //     // work_order_controller(data);
    //     // })
    //     work_order_controller(data1);
    //     // console.log(data);
    // };
    // async function work_order_controller(data1) {
    //     await $.ajax({
    //         url: '../controller/real_time_machine_controller.php',
    //         data: {
    //             'OpType': 'work_order',
    //             'real_data': data1.real_data
    //         },
    //         dataType: "text",
    //         type: 'POST'
    //     }).done(function(res) {
    //         console.log(res);
    //         var obj = JSON.parse(res);
    //         console.log('工單');
    //         var d_list = sortJSON(obj, 'add_cost', 'DEC');
    //         build_bar_chart(d_list, 1);
    //         console.log(obj)
    //     })
    // };
    // //-------------------------------------------------------
    // //工序
    // data = {
    //     "real_data": [
    //         "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_03\", \"MCM_NO\": \"#24\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.47}",
    //         "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_07\", \"MCM_NO\": \"#25\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 1.42}",
    //         "{\"OP_NO\": \"21\", \"EMP_NO\": \"EMP_07\", \"MCM_NO\": \"#26\", \"OP_NAME\": \"test_03\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 1.12}",
    //         "{\"OP_NO\": \"21\", \"EMP_NO\": \"EMP_04\", \"MCM_NO\": \"#27\", \"OP_NAME\": \"test_03\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 2.33}",
    //         "{\"OP_NO\": \"20\", \"EMP_NO\": \"EMP_01\", \"MCM_NO\": \"#28\", \"OP_NAME\": \"test_02\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 2.52}",
    //         "{\"OP_NO\": \"20\", \"EMP_NO\": \"EMP_04\", \"MCM_NO\": \"#28\", \"OP_NAME\": \"test_02\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.18}",
    //         "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_02\", \"MCM_NO\": \"#29\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.32}",
    //         "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_03\", \"MCM_NO\": \"#30\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.23}",
    //         "{\"OP_NO\": \"20\", \"EMP_NO\": \"EMP_01\", \"MCM_NO\": \"#31\", \"OP_NAME\": \"test_02\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 2.52}",
    //         "{\"OP_NO\": \"25\", \"EMP_NO\": \"EMP_04\", \"MCM_NO\": \"#32\", \"OP_NAME\": \"test_02\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.18}",
    //         "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_02\", \"MCM_NO\": \"#33\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.32}",
    //         "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_03\", \"MCM_NO\": \"#34\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.23}",
    //         "{\"OP_NO\": \"20\", \"EMP_NO\": \"EMP_01\", \"MCM_NO\": \"#35\", \"OP_NAME\": \"test_02\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 2.52}",
    //         "{\"OP_NO\": \"21\", \"EMP_NO\": \"EMP_04\", \"MCM_NO\": \"#37\", \"OP_NAME\": \"test_02\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.18}",
    //         "{\"OP_NO\": \"19\", \"EMP_NO\": \"EMP_02\", \"MCM_NO\": \"#36\", \"OP_NAME\": \"test_01\", \"YEAR\": \"2021\",\"MONTH\": \"6\",\"DAY\": \"13\" , \"EMP_WORK_TIME\": 0.32}"
    //     ]
    // };
    // data2 = {
    //     "real_data": []
    // }
    // var len = data.real_data.length;
    // for (var i = 0; i < len; i++) {
    //     var str = data.real_data[i].substring(1, data.real_data[i].length - 1).replace(/(?![\. }])(\"*)/g, '')
    //     // console.log(str)
    //     var arr = str.split(',');
    //     // console.log(arr);
    //     var obj = {};

    //     for (var j = 0; j < arr.length; j++) {
    //         row = arr[j].split(':');
    //         var key = row[0].trim();
    //         var value = row[1].trim();
    //         obj[key] = value;
    //     }
    //     data2.real_data[i] = obj;
    // };
    // // console.log(data);
    // api_work_num_data();
    // var api = '尚未串接';
    // async function api_work_num_data() {
    //     //     var today = new Date();
    //     //     var Today = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
    //     //     // console.log(Today);
    //     //     dataJSON = {
    //     //         "START_DATE": Today,
    //     //         "END_DATE": Today
    //     //     }
    //     // await $.ajax({
    //     //    type: 'POST',
    //     //    data: JSON.stringify(dataJSON),
    //     //    url: api,
    //     //    contentType: "application/json;charset=utf-8"
    //     // }).done(function(res) {
    //     //     // console.log(res);
    //     // for (var i = 0; i < len; i++) {
    //     //     var str = data.real_data[i].substring(1, data.real_data[i].length - 1).replace(/(?![\. }])(\"*)/g, '')
    //     //     // console.log(str)
    //     //     var arr = str.split(',');
    //     //     // console.log(arr);
    //     //     var obj = {};
    //     //     for (var j = 0; j < arr.length; j++) {
    //     //         row = arr[j].split(':');
    //     //         var key = row[0].trim();
    //     //         var value = row[1].trim();
    //     //         obj[key] = value;
    //     //     }
    //     //     data.real_data[i] = obj;
    //     // };
    //     // work_num_controller(data);
    //     // })
    //     work_num_controller(data2);
    //     // console.log(data);
    // };

    // async function work_num_controller(data2) {
    //     await $.ajax({
    //         url: '../controller/real_time_machine_controller.php',
    //         data: {
    //             'OpType': 'work_num',
    //             'real_data': data2.real_data
    //         },
    //         dataType: "text",
    //         type: 'POST'
    //     }).done(function(res) {
    //         // console.log(res);
    //         var obj = JSON.parse(res);
    //         console.log('工序');
    //         console.log(obj);
    //         var d_list = sortJSON(obj, 'add_cost', 'DEC');
    //         build_bar_chart(d_list, 2);
    //     })
    // };
    // //-------------------------------------------------------
    function sortJSON(arr, key, way) {
        return arr.sort(function(a, b) {
            var x = a[key];
            var y = b[key];
            if (way === 'ASC') {
                return ((x < y) ? -1 : ((x > y) ? 1 : 0));
            }
            if (way === 'DEC') {
                return ((x > y) ? -1 : ((x < y) ? 1 : 0));
            }
        });
    }

    function build_factory_chart(dataObjList, bar_name, title_name) {

        var name_list = [];
        var data_list = [];
        var color_list = [];
        var label;
        for (var i = 0; i < dataObjList.length; i++) {

            const item = dataObjList[i];

            //first canvas
            if (bar_name == 1) {
                // console.log(item.Date);
                name_list.push(item.Date);
                data_list.push(parseFloat(item.factory_cost));
                color_list.push("#5cabf9");
                label = '工廠成本';
            } else if (bar_name == 2) {
                // console.log(item.Date);
                name_list.push(item.Date);
                data_list.push(parseFloat(item.cost));
                color_list.push("#5cabf9");
                label = '內部失敗作業成本';
            } else if (bar_name == 3) {
                // console.log(item.Date);
                name_list.push(item.Date);
                data_list.push(parseFloat(item.cost));
                color_list.push("#5cabf9");
                label = '無生產力作業成本';
            }
            // if (bar_name == 1) {
            //     name_list.push(item.ORDER_NO);
            //     data_list.push(parseFloat(item.add_cost));
            //     color_list.push("#5cabf9");
            //     label = '工單成本';
            // } else if (bar_name == 2) {
            //     name_list.push(item.OP_NO);
            //     data_list.push(parseFloat(item.add_cost));
            //     label = '作業成本';
            //     color_list.push("#5cabf9");
            // }


        }

        // console.log(name_list);
        // console.log(data_list);
        const data = {
            labels: name_list,
            datasets: [{
                label: label,
                data: data_list,
                backgroundColor: color_list,
                borderWidth: 1
            }]
        };
        if (bar_name == 1) {
            var chart = new Chart(barChart, {
                type: 'bar',
                data: data,
                options: {
                    title: {
                        display: true,
                        fontSize: '15',
                        text: title_name
                    },
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '成本'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '日期'
                            }
                        }]
                    }
                }
            });
        } else if (bar_name == 2) {
            var chart_2 = new Chart(barChart_2, {
                type: 'bar',
                data: data,
                options: {
                    title: {
                        display: true,
                        fontSize: '15',
                        text: title_name
                    },
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '成本'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '日期'
                            }
                        }]
                    }
                }
            });
        } else if (bar_name == 3) {
            var chart_3 = new Chart(barChart_3, {
                type: 'bar',
                data: data,
                options: {
                    title: {
                        display: true,
                        fontSize: '15',
                        text: title_name
                    },
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '成本'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '日期'
                            }
                        }]
                    }
                }
            });
        }
        // if (bar_name == 1) {
        //     var chart = new Chart(barChart, {
        //         type: 'bar',
        //         data: data,
        //         options: {
        //             responsive: true,
        //             legend: {
        //                 display: false
        //             },
        //             scales: {
        //                 y: {
        //                     beginAtZero: true
        //                 },
        //                 yAxes: [{
        //                     scaleLabel: {
        //                         display: true,
        //                         labelString: '成本'
        //                     }
        //                 }],
        //                 xAxes: [{
        //                     scaleLabel: {
        //                         display: true,
        //                         labelString: '工單別'
        //                     }
        //                 }]
        //             }
        //         }
        //     });
        // } else if (bar_name == 2) {
        //     var chart = new Chart(barChart2, {
        //         type: 'bar',
        //         data: data,
        //         options: {
        //             responsive: true,
        //             legend: {
        //                 display: false
        //             },
        //             scales: {
        //                 y: {
        //                     beginAtZero: true
        //                 },
        //                 yAxes: [{
        //                     scaleLabel: {
        //                         display: true,
        //                         labelString: '成本'
        //                     }
        //                 }],
        //                 xAxes: [{
        //                     scaleLabel: {
        //                         display: true,
        //                         labelString: '作業別'
        //                     }
        //                 }]

        //             }
        //         }
        //     });
        // }


    }

    function build_work_order_chart(dataObjList, bar_name, title_name) {

        var name_list = [];
        var data_list = [];
        var color_list = [];
        var label;
        for (var i = 0; i < dataObjList.length; i++) {

            const item = dataObjList[i];

            //first canvas
            if (bar_name == 1) {
                // console.log(item.Date);
                name_list.push(item.Work_Ticked_No);
                data_list.push(parseFloat(item.cost));
                color_list.push("#5cabf9");
                label = '工單成本最高前10名';
            }
        }

        // console.log(name_list);
        console.log(data_list);
        const data = {
            labels: name_list,
            datasets: [{
                label: label,
                data: data_list,
                backgroundColor: color_list,
                borderWidth: 1
            }]
        };
        if (bar_name == 1) {
            var chart = new Chart(work_order_Chart, {
                type: 'bar',
                data: data,
                options: {
                    title: {
                        display: true,
                        fontSize: '15',
                        text: title_name
                    },
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '成本'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '工單'
                            }
                        }]
                    }
                }
            });
        }
    }

    function build_work_num_chart(dataObjList, bar_name, title_name) {

        var name_list = [];
        var data_list = [];
        var color_list = [];
        var label;
        for (var i = 0; i < dataObjList.length; i++) {

            const item = dataObjList[i];

            //first canvas
            if (bar_name == 1) {
                // console.log(item.Date);
                name_list.push(item.work_name);
                data_list.push(parseFloat(item.cost));
                color_list.push("#5cabf9");
                label = '作業成本排名分析';
            }
        }

        // console.log(name_list);
        // console.log(data_list);
        const data = {
            labels: name_list,
            datasets: [{
                label: label,
                data: data_list,
                backgroundColor: color_list,
                borderWidth: 1
            }]
        };
        if (bar_name == 1) {
            var chart = new Chart(work_num_Chart, {
                type: 'bar',
                data: data,
                options: {
                    title: {
                        display: true,
                        fontSize: '15',
                        text: title_name
                    },
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '成本'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '作業別'
                            }
                        }]
                    }
                }
            });
        }
    }

    function build_capacity_manage_chart(dataObjList, bar_name, title_name) {

        var name_list = [];
        var data_list = [];
        var color_list = [];
        var label;
        for (var i = 0; i < dataObjList.length; i++) {

            const item = dataObjList[i];

            //first canvas
            if (bar_name == 1) {
                var data_2 = {
                    datasets: [{
                        data: [item.cap_cost,
                            item.non_cost,
                            item.indirect_cost,
                            item.idle_cost,
                        ],
                        backgroundColor: [
                            '#5b9bd5',
                            '#ed7d31',
                            '#a5a5a5',
                            '#ffc000'
                        ],
                    }],
                    labels: [
                        '有生產力作業',
                        '無生產力作業',
                        '間接生產力作業',
                        '閒置產能作業'
                    ]
                };
            } else if (bar_name == 2) {
                // console.log(item.Date);
                name_list.push(item.Work_Ticked_No);
                data_list.push(parseFloat(item.cost));
                color_list.push("#5cabf9");
                label = '無生產力作業成本前五名';
            } else if (bar_name == 3) {
                // console.log(item.Date);
                name_list.push(item.Reason);
                data_list.push(parseFloat(item.cost));
                color_list.push("#5cabf9");
                label = '無生產力作業成本發生之原因';
            }
        }

        // console.log(name_list);
        // console.log(data_list);
        const data = {
            labels: name_list,
            datasets: [{
                label: label,
                data: data_list,
                backgroundColor: color_list,
                borderWidth: 1
            }]
        };
        if (bar_name == 1) {
            var myDoughnutChart_2 = new Chart(capacity_Chart1, {
                type: 'pie',
                data: data_2,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 120,
                            fontSize: 15
                        }
                    },
                    title: {
                        display: true,
                        text: '全部工單之產能屬性成本佔比圖'
                    }
                }
            });
        } else if (bar_name == 2) {
            var chart = new Chart(capacity_Chart2, {
                type: 'bar',
                data: data,
                options: {
                    title: {
                        display: true,
                        fontSize: '15',
                        text: title_name
                    },
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '成本'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '工單別'
                            }
                        }]
                    }
                }
            });
        } else if (bar_name == 3) {
            var chart = new Chart(capacity_Chart3, {
                type: 'bar',
                data: data,
                options: {
                    title: {
                        display: true,
                        fontSize: '15',
                        text: title_name
                    },
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '成本'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '無生產力原因別'
                            }
                        }]
                    }
                }
            });
        }
    }

    function build_property_manage_chart(dataObjList, bar_name, title_name) {

        var name_list = [];
        var data_list = [];
        var color_list = [];
        var label;
        for (var i = 0; i < dataObjList.length; i++) {

            const item = dataObjList[i];

            //first canvas
            if (bar_name == 1) {
                var data_2 = {
                    datasets: [{
                        data: [item.prevent_cost,
                            item.identi_cost,
                            item.external_cost,
                            item.internal_cost,
                        ],
                        backgroundColor: [
                            '#5b9bd5',
                            '#ed7d31',
                            '#a5a5a5',
                            '#ffc000'
                        ],
                    }],
                    labels: [
                        '預防作業',
                        '鑑定作業',
                        '外部失敗作業',
                        '內部失敗作業'
                    ]
                };
            } else if (bar_name == 2) {
                // console.log(item.Date);
                name_list.push(item.Work_Ticked_No);
                data_list.push(parseFloat(item.cost));
                color_list.push("#5cabf9");
                label = '內部失敗作業成本前五名';
            } else if (bar_name == 3) {
                // console.log(item.Date);
                name_list.push(item.Reason);
                data_list.push(parseFloat(item.cost));
                color_list.push("#5cabf9");
                label = '內部失敗作業成本發生之原因';
            }
        }

        // console.log(name_list);
        // console.log(data_list);
        const data = {
            labels: name_list,
            datasets: [{
                label: label,
                data: data_list,
                backgroundColor: color_list,
                borderWidth: 1
            }]
        };
        if (bar_name == 1) {
            var myDoughnutChart_2 = new Chart(property_Chart1, {
                type: 'pie',
                data: data_2,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 120,
                            fontSize: 15
                        }
                    },
                    title: {
                        display: true,
                        text: '全部工單之品質屬性成本佔比圖'
                    }
                }
            });
        } else if (bar_name == 2) {
            var chart = new Chart(property_Chart2, {
                type: 'bar',
                data: data,
                options: {
                    title: {
                        display: true,
                        fontSize: '15',
                        text: title_name
                    },
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '成本'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '工單別'
                            }
                        }]
                    }
                }
            });
        } else if (bar_name == 3) {
            var chart = new Chart(property_Chart3, {
                type: 'bar',
                data: data,
                options: {
                    title: {
                        display: true,
                        fontSize: '15',
                        text: title_name
                    },
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '成本'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '內部失敗原因別'
                            }
                        }]
                    }
                }
            });
        }
    }

    function build_product_chart(dataObjList, bar_name, title_name) {


        if (bar_name == 1) {
            let name_list = [];
            let data_list = [];
            let color_list = [];

            for (let i = 0; i < dataObjList.length; i++) {
                name_list.push(dataObjList[i].Material_Part_No);
                data_list.push(dataObjList[i].total_tmp);
                color_list.push("#5cabf9");
            }

            const data = {
                labels: name_list,
                datasets: [{
                    data: data_list,
                    backgroundColor: color_list,
                    borderWidth: 1
                }]
            };
            // console.log("have " + dataObjList[0].total_tmp);
            var chart = new Chart(product_Chart1, {
                type: 'bar',
                data: data,
                options: {
                    title: {
                        display: true,
                        fontSize: '15',
                        text: title_name
                    },
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '成本'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '工單'
                            }
                        }]
                    }
                }
            });
        } else if (bar_name == 2) {
            let name_list = [];
            let product_num_list = [];
            let data_list = [];
            let count_list = [];
            let color_list = [];
            // console.log(dataObjList);
            //數量
            for (let i = 0; i < dataObjList.length; i++) {
                name_list.push(dataObjList[i].product_name);
                count_list.push(dataObjList[i].count);
                color_list.push("#5cabf9");
            }
            //成本
            for (let j = 0; j < dataObjList.length; j++) {
                product_num_list.push(dataObjList[j].product_num);
                data_list.push(dataObjList[j].unit_cost);
                // color_list.push("#ed7d31");
            }

            //統一labels 分開dataset
            // console.log("here");
            // console.log(count_list);
            // console.log(data_list);
            const data ={
                labels: name_list,
                datasets: [{
                    type: 'bar',
                    label: '數量',
                    data: count_list,
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 1,
                    order: 2
                },
                {
                    type: 'line',
                    label: '成本',
                    data: data_list,
                    fill: false,
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1,
                    order: 1
                }]                
            }
            // console.log(data);
            var chart = new Chart(product_Chart2, {
                type: 'bar',
                data: data,
                options: {
                    title: {
                        display: true,
                        fontSize: '15',
                        text: title_name
                    },
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            stacked: true
                        },
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '成本'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: '工單'
                            }						
                        }]
                    }
                }
            });
        }
    }


    // function functionC() {
    // api_work_order_data();
    // api_work_num_data();
    // }

    // setInterval(functionC, 1000);
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
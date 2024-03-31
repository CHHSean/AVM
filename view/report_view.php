<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../src/link_management.php'); ?>
    <?php include('../view/modal_share_view.php'); ?>
    <style>
    </style>
    <title>即時系統戰情室</title>
</head>

<body style="background-color: #f2f2f2;">
    <div class="back_div_position mt-3 mb-3 ml-3">
        <button type="button" class="btn btn-outline-danger" id='btn_back' style="margin:10px 10px;">上一頁</button>
    </div>
    
    <div id="up_table" style="border:0.05px solid white;background-color:white;padding:10px;">
    <div style="display:flex;text-align: center;align-items: center;width:40%;margin:10px auto;">
    <p style="font-size:20px;padding-right:20px;padding-top:10px;">起始時間</p><input type="date" name="start" id="startdate" style="margin-right:20px;" onchange="handler(event);">
    <p style="font-size:20px;padding-right:20px;padding-top:10px;">結束時間</p><input type="date" name="start" id="enddate">
    <button id="search" style="margin-left:20px;" onclick="get_selected()">搜尋</button>
    </div>
    </div>
</body>

</html>

<script>
    // 上一頁
    $('#btn_back').click(function() {
        window.location.href = "../view/nav_view.php";
    });
    
    var d = new Date();
    var day =d.getDate();
    var month = d.getMonth()+1; 

    if(d.getMonth()<10){
    var month = "0"+(d.getMonth()+1); 
    }

    if(d.getDate()<10){
    day = "0"+d.getDate(); 
    }

    var datew = d.getFullYear()+"-"+month+"-"+day;
    var datew = datew.toString();

    $("[name=start]").val(datew);
    $("[name=end]").val(datew);
    $("[name=start]").prop('max',datew);
    $("[name=end]").prop('max',datew);
    var input = document.getElementById("enddate");
    input.setAttribute("min", datew);    

    //set value
    document.getElementById("startdate").onchange = function () {
        var input = document.getElementById("enddate");
        input.setAttribute("min", this.value);
    }

    function get_selected(){
        console.log(document.getElementById("startdate").value);
        console.log(document.getElementById("enddate").value);
    }
    // value="2018-07-22"
    //    min="2018-01-01" max="2018-12-31"

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
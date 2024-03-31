<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../src/link_management.php'); ?>
    <style>
        <?php include('../src/nav_view.css'); ?>
    </style>
    <title>首頁</title>
</head>

<body>
    <div class="header">
        <h1 class="header-ch">
        智慧製造即時製造成本管理系統</h1>
        <h3 class="header-eng">AVM System</h3>
    </div>
    <nav class="navbar navbar-expand-sm navbar-dark bg-secondary">
        <div class="collapse navbar-collapse" id="main_nav">

            <ul class="navbar-nav">

                <li class="nav-item"><a id="home-link" class="nav-link" href="#"> <img class="home-img" src="../picture/home.png" alt=""> 首頁 </a></li>
                <li class="nav-item dropdown">
                <a id="manage-report" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">管理報表</a>
                <ul class="dropdown-menu">
                    <li> <a class="dropdown-item" href="#"> 作業管理 &raquo; </a>
                    <ul class="dropdown-submenu">
                        <li><a class="dropdown-item" href="../view/job_report_view.php">作業管理分析表</a></li>
                    </ul>
                    <li> <a class="dropdown-item" href="#"> 品質管理 &raquo; </a>
                    <ul class="dropdown-submenu">
                        <li><a class="dropdown-item" href="../view/property_view.php">品質屬性成本分析表</a></li>
                        <li><a class="dropdown-item" href="../view/mc_property_view.php">工單品質屬性成本分析表</a></li>
                    </ul>
                    <li> <a class="dropdown-item" href="#"> 產能管理 &raquo; </a>
                    <ul class="dropdown-submenu">
                        <li><a class="dropdown-item" href="../view/production_view.php">產能屬性成本分析表</a></li>
                        <li><a class="dropdown-item" href="../view/mc_production_view.php">工單產能屬性成本分析表</a></li>
                    </ul>
                    <li> <a class="dropdown-item" href="#"> 工單管理 &raquo; </a>
                    <ul class="dropdown-submenu">
                        <li><a class="dropdown-item" href="../view/all_work_order_report_view.php">全部工單成本分析表</a></li>
                        <!-- <li><a class="dropdown-item" href="../view/single_work_order_report_view.php">個別工單之作業成本分析表</a></li> -->
                    </ul>
                    </li>
                    <li> <a class="dropdown-item" href="#"> 產品管理 &raquo; </a>
                    <ul class="dropdown-submenu">
                        <li><a class="dropdown-item" href="../view/product_cost_view.php">產品成本分析表</a></li>
                    </ul>
                    </li>
                    <li> <a class="dropdown-item" href="#"> 工廠管理 &raquo; </a>
                    <ul class="dropdown-submenu">
                        <li><a class="dropdown-item" href="../view/factory_management_view.php">工廠成本、內部失敗作業成本及無生產力作業成本分析表</a></li>
                    </ul>
                    </li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                    <a id="doc-link" class="nav-link  dropdown-toggle" data-toggle="dropdown">文件</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../view/machine_cost_view.php">機器成本</a></li>
                        <li><a class="dropdown-item" href="../view/human_resource_cost.php">人事成本</a></li>
                        <li><a class="dropdown-item" href="../view/work_attribute_view.php">作業屬性</a></li>
                        <li><a class="dropdown-item" href="../view/material_view.php">材料管理</a></li>
                        <li><a class="dropdown-item" href="../view/indirect_human_cost_view.php">間接人事成本</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a id="realtime-link" class="nav-link" href="../view/realtime_view.php">即時系統戰情室</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <button id="log_out" class="nav-link"> 登出<img class="logout-img" src="../picture/logout.png" alt="logout"> </button>
                </li>
            </ul>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapse_target">

        </div>
    </nav>
    <div class="mb-3" style="text-align:center;">
        <img class="middle-img" src="../picture/index_photo.png">
    </div>
</body>

</html>

<script>
    $('#log_out').click(function() {
        window.location.replace('../view/login_view.php');
    });
    cookieArray = document.cookie.split(";");
    for (var i = 0; i < cookieArray.length; i++) {
        thisCookie = cookieArray[i].split("=");
        // console.log(thisCookie);
        if (thisCookie[0] == 'user') {
            // console.log(thisCookie[1]);
            break;
        }
    }
</script>

<style>
    @media all and (min-width: 600px) {
        .navbar .nav-item .dropdown-menu{
            display: none;
        }
        .dropdown-menu li{ position: relative; 	}
        .nav-item .dropdown-submenu{
            display: none;
            position: absolute;
		    left:100%;
            top:-5px;
            border-style:solid;border-width:0.1px;border-color:#c4cad1;border-left-color:#cccccc;
            margin-top:5px;margin-right:-10px;
            background-color: #fff;
            border-radius: 2px;
            text-decoration: none;
            list-style-type:none;
        }
        /* .navbar .nav-item:hover .nav-link {
            color: #FFFFFF;
        } */
        
        .navbar .nav-item:hover .dropdown-menu{
            display: block;
        }
        .dropdown-menu > li:hover > .dropdown-submenu{ display: block; }
        .navbar .nav-item .dropdown-menu{
            margin-top: 0;
        }
    }

    .dropdown_div_line_color {
        border-color: black;
    }
</style>
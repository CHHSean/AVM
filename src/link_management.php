<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="../picture/isvms-16x16.png" sizes="16x16">
<script src="../src/jquery-3.5.1.min.js"></script>
<script src="../src/bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
<script src="../src/bootstrap-4.5.0/js/bootstrap.min.js"></script>
<!-- <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css"> -->
<script src="../src/datatables/js/jquery.dataTables.min.js"></script>
<script src="../src/datatables/datatable_module.js"></script> <!-- 引入datatable模組 -->
<script src="../src/chart.js"></script>
<script src="../src/chart/chart_module.js"></script> <!-- 引入chart模組 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link href="../src/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="../src/bootstrap-4.5.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"/>

<?php if (isset($_COOKIE["user"])) {
    $login_user = $_COOKIE["user"];
} ?>
function build_pie_chart(dataObjList) {
    var data_2 = {
        datasets: [{
            data: dataObjList,
            backgroundColor: [
                '#5b9bd5',
                '#ed7d31',
                '#a5a5a5',
                '#ffc000'
            ],
        }],
        labels: [
            '運轉成本',
            '待機成本',
            '停機成本',
            '未開機成本'
        ]
    };
    var myDoughnutChart_2 = new Chart(pieChart, {
        type: 'pie',
        data: data_2,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 12,
                }
            }
        }
    });
}

// 即時戰情室-圖表 全部機器成本分析與比較圖

function build_bar_chart(dataObjList, labels) {

    var chart = new Chart(barChart, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: dataObjList,

        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom'
            },
            scales: {
                xAxes: [{
                    stacked: true
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    });

}

function build_multi_pie_chart(dataObjList, pieChart) {

    var data_multi = {
        datasets: [{
            data: dataObjList,
            backgroundColor: [
                '#5b9bd5',
                '#ed7d31',
                '#a5a5a5',
                '#ffc000'
            ],
        }],
        labels: [
            '運轉成本',
            '待機成本',
            '停機成本',
            '未開機成本'
        ]
    };
    var myPieChart = new Chart(pieChart, {
        type: 'pie',
        data: data_multi,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 12,
                }
            }
        }
    });
}

function build_pie_sheet(mc_num_obj) {

    for (var i = 0; i <= mc_num_obj.length + 1; i++) {
        var data = "<div style='width:20%;margin: 10px auto;padding-top:100px;'>" +
            "<h2>個別機器" + (i + 1) + "成本分析比較圖</h2>" + "<hr style='width:30%;'>" + "</div>" +
            "<div style='width:45%;height:auto;margin:auto;padding-top:50px;padding-bottom:50px;'>" +
            "<canvas id='barChart' width=800 height=600></canvas>" + "</div>";
        document.getElementById('per_pieChart').innerHTML += data;
    }

}
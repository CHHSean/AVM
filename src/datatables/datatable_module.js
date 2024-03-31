//name:輸入table id,
// obj：輸入json data,
// commandlist:datatable option 設定,
// col_def:columnDefs,
// col_table:columns
function data_mat_table(name,obj,commandlist,col_def,col_table) {

    var object1={
        data: obj, 
        columnDefs: col_def, 
        columns:col_table
    };
    var object2={ 
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
    
    var data_table_obj={...object1,...object2,...commandlist};
    $(name).DataTable(
        data_table_obj
    );

}

// create another table with Child row (data-table);
function data_nest_table(name) {

    var object2={ 
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
        'dom' : 't',
        'columns': [
          {
            'className': 'details-control',
            'orderable': false,
            'data': null,
            'defaultContent': ''
          },
          null,
          null,
          null,
          null,
          null,
        ],
        'columnDefs': [
          {
            'targets': [0],
            'width': '10px',
          },
          {
            'targets': [1,2],
            'className' : 'dt-left',
          },
          {
            'targets' : [3,4,5, 6],
            'className' : 'dt-right',
            'width': '100px',
          },
        ],
        ...object2
      });
    
      // Add event listener for opening and closing details
      $(name+' tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
    
        if (row.child.isShown()) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
        }
          else
        {
          // Open this row
          row.child(format(row.data())).show();
          tr.addClass('shown');
        }
      });    

}

function format(rowData) { 
    
    var data = [
      ['Brown, John', 'Staff', '50', '$2,50', 'sort Values ->', '3264.87'],
      ['Smith, Mary', 'Consultant', '50', '$2,500', 'sort Values ->', '3265.12'],
      ['Bloggs, Joe', 'Manager', '10', '$5,000', 'sort Values ->', '3265.00'],
    ];
    
      
    var sortedArray = data.sort(function(a, b) {
      return a[5] - b[5];
    });
  
    var childTable = '<tr>';
        
    for (i=0; i<sortedArray.length; i++) {
        childTable += '<tr>' +
          '<td></td>' +
            '<td>' + data[i][0] + '</td>' +
            '<td>' + data[i][1] + '</td>' +
            '<td class="dt-right">' + data[i][2] + '</td>' +
            '<td class="dt-right">' + data[i][3] + '</td>' +
            '<td class="dt-right">' + data[i][4] + '</td>' +
            '<td class="dt-right">' + data[i][5] + '</td>' +
          '</tr>';
      }

    childTable += '</tr>';
    return $(childTable).toArray();
  }
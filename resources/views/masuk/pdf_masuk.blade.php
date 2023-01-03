<!DOCTYPE html>
<html>
<head>
    <title>Supply Produksi</title>
    <style>
        
        @media print {
            html, body {
                font-size: 12px !important;
                font-family: 'Calibri' !important;
                margin : 0.5em 0.22em 0 0.22em;
                
            }
            .modal-dialog {
                position: relative;
                top: 0;
                left: 0;
            }
        }
        body{
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        .table th {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        
        .table td {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        .bordered td {
            border-color: #959594;
            border-style: solid;
            border-width: 1px;
        }
        table {
            border-collapse: collapse;
        }
        caption {
            background-color: #F7F7F7;
            border-color: #959594;
            border-style: solid;
            border-width: 1px;
        }
        .coba{
            float:left;
            width:45%;
        }
        .coba2{
            float:left;
            width:20%;
        }
    </style>
</head>
<body>
    @php
    use Carbon\Carbon;
    @endphp
    <div class="col-xs-12">
    <table>
                    <tbody>
                        <tr>
                        <td colspan="4" align="center"> <img src="{{$qr_code_1}}" width="100"></td>
                    </tr>
                </tbody>
            </table>
            <table>
                    <tbody>
                        <tr>
                        <td colspan="4" style="text-align:center;"> Out Going Ticket </td>
                    </tr>
                </tbody>
            </table>
</div>
</body>
</html>
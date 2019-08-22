<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Payroll</title>
    <!-- Bootstrap Core CSS -->
    {!! Html::style('css/bootstrap/bootstrap.css') !!}
    
    <style type="text/css">
      body{
        font-size: 11px;
      }
      table#table-salary-description{
        width: 100%;
      }
      table#table-salary-description td{
        padding: 4px;
        vertical-align: top;
        border: 1px solid;
      }

      table#table-manhour-summary td{
        text-align: center;
        border:1px solid;
      }
      td.centered-bordered{
        text-align: center;
      }
      tr.weekend{
        color: red;
      }
      td.weekend{
        color: red;
      }

      table#extra_payment_table_adder td{
        vertical-align: center;
        border:none;
      }
      table#extra_payment_table_substractor td{
        vertical-align: center;
        border:none;
      }
    </style>
</head>

<body>
  @if($user->type == 'office')
  @else
    @include('pdf.payroll.outsource')
  @endif
</body>
</html>

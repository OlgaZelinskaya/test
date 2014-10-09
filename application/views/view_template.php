<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8" />   
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js' ></script>
<link rel="stylesheet" href="/test/css/style.css" type="text/css" /> 

</head> 
 
<body>

<table class="menu">
 <tr >
  <td onClick="document.location.href = '/test/course';" class="td1">Курс валют</td>
  <td  class="td1" id="goToExchange">Операции обмена</td>
  <td onClick="document.location.href = '/test/report';" class="td1">Отчеты</td>
 </tr>
</table>

<?php include 'application/views/'.$view_content;
 //include 'application/views/view_report.php;' ?>

</body> 
    
    
</html>

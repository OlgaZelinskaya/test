<head>
<link rel="stylesheet" href="/test/css/style.css" type="text/css" /> 
<script  src="/test/js/ajax.js"></script>  
<script  src="/test/js/jquery.js" ></script>
<script  src="/test/js/date.js"></script>
<script  src="/test/js/jquery.datePicker-2.1.2.js"></script>
<link rel="stylesheet" href="/test/css/datepicker.css" type="text/css" /> 

<script>
$(function()
{
$('#date1').datePicker({
startDate: '01-01-1000',
endDate: '01-01-3000'
});
});
</script>

<script>
$(function()
{
$('#date2').datePicker({
startDate: '01-01-1000',
endDate: '01-01-3000'
});
});
</script>
</head> 

<body>
<table width="100%" > 
<tr>
<td width="30%" ></td>
<td width="40%" > 
    <p>&nbsp;</p>      
 	<div id="d1" class="div1"  >
    <form method="post" id="myform">
    <p>
    <label>Выберите период отчета: </label>
    </p>
    <p>
    <label>с</label> 
    <input name="date1" type="text" id="date1" size="10"   >
    <label>по  </label>
    <input name="date2" type="text" id="date2" size="10"   >
    </p>
    &nbsp;

   <input name="report" type="button" value="Построить отчет"  id="report" disabled="disabled" >
    </form>
     </div>
    
     <div class="result"  id="result"></div>
</td>
<td width="30%"></td>
</tr>
</table>
</body>
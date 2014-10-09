<head>
<script  src="/test/js/ajax.js"></script>  
<script  src="/test/js/jquery.js" ></script>
<script  src="/test/js/date.js"></script>
<script  src="/test/js/jquery.datePicker-2.1.2.js"></script>
<link rel="stylesheet" href="/test/css/datepicker.css" type="text/css" /> 
<link rel="stylesheet" href="/test/css/style.css" type="text/css" /> 


<script>
$(function()
{
$('#Date').datePicker({
startDate: '01-01-1000',
endDate: '01-01-3000'
});
});
</script>

</head> 


<table width="100%" > 
 <tr>
  <td width="30%" ></td>
  <td width="40%" > 
  <p>&nbsp;</p>

  <form method="post" id="myform"  >
   <div  class="div1" >
   <p> 
   <label> Данные о курсе на </label>
   <input name="Date" type="text" id="Date" size=10 >  
   </p>
   <p> 
   &nbsp;&nbsp;
   <label>Покупка </label>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <label>Продажа </label>
   </p>
   <p>
   <label>USD </label>
   <input name="BuyUSD" type="text" id="BuyUSD" size="8" >
   <input name="SaleUSD" type="text" id="SaleUSD" size="8"> 
   </p>
   <p>
   <label>EUR</label>
   <input name="BuyEUR" type="text" id="BuyEUR" size="8">
   <input name="SaleEUR" type="text" id="SaleEUR" size="8">
   </p>
   <p>
   <label>RUB</label>
   <input name="BuyRUB" type="text" id="BuyRUB" size="8" >
   <input name="SaleRUB" type="text" id="SaleRUB" size="8" >
   </p>
   <p>
   <input type="button" name="save" id="save" value="Сохранить" disabled="disabled" onClick="send_kurs();" >  
   <input type="reset"  value="Новая запись" id="reset1" onClick="resetKurs();">
   </p>
  </div> 
  <div id="result" class="result"></div>
 </form>
 </td>
 <td width="30%" >
 </td>
 </tr>
</table>

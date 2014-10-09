<head>
<link rel="stylesheet" href="/test/css/style.css" type="text/css" /> 
 <script  src="/test/js/ajax.js"></script>  
</head> 
 

<table width="100%" > 
 <tr>
  <td width="30%" ></td>
  <td width="40%" align="center" >          
  <p>&nbsp;</p>
   <form id="formExchange"  method="post" >
    <div  id="d1" class="div1"  >
    <p>
    <input  type="radio" name="radio" id="sale" value="sale"   checked  class="f1"> 
    <label for="sale">Продажа валюты</label>
    
    <input type="radio" name="radio" id="buy" value="buy" class="f1">
    <label for="buy">Покупка валюты</label>
    </p>
    </div>

    <div id="d2" class="div1"  >
    <label id="label1">Операция обмена №</label>
    <input name="numberSale"  type="text"   id="numberSale"  size="5" readonly value="<?php echo $data['number']+1 ?>">
    <label>от</label>
    <input name="dateSale"  type="text"   size= 10" readonly value="<?php echo $data['today'] ?>">
    <p>&nbsp;</p>
    <label>Валюта </label>
    <select name="selectSale" id="selectSale"  class="f2">
    <option> </option>
    <option>USD</option>
    <option>EUR</option>
    <option>RUB</option>
    </select>
    <label>Курс</label>
    <input name="kursSale"  type="text"  class="f2"   id="kursSale" size="10"    readonly>&nbsp;&nbsp;
    <p>
    <labelb >Сумма операции</label> 
    <input name="sumSale" id="sumSale" type="text"  size="    13" class="f2">&nbsp;&nbsp;&nbsp;&nbsp;
    </p>
 
    <p>
    &nbsp;&nbsp;&nbsp;&nbsp; <label>Эквивалент в гривнах  </label>
    <input name="ekvSale" type="text" id="resultSum"   class="f2" size="14"     readonly >
    </p>
    <hr color=#989898  >

    <p>
    <label>Корреспондент:  </label>
    </p>

    <p>
    <label>Серия, номер паспорта  </label>
    <input name="pasSale" type="text" id="pasport"  class="f2">
    </p>
    <p>
    <label>Фамилия  </label>
    <input name="famSale" type="text" id="Fam" class="f2">
    </p>
    <p>
    <label>Имя  </label>
    <input name="nameSale" type="text" id="Name" class="f2">        			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </p>
    <p>
    <label>Отчество  </label>
    <input name="otchSale" type="text" id="Otch" class="f2">
    </p>

    <p>
    <input type="button" name="saveSale" id="saveSale" value="Сохранить" >
    <input type="reset" value="Новая операция" id="reset" onClick="resetKurs1();">
    </p>
   </div>
  </form>
   <div class="result" id="result"></div>
  </td>
  <td width="30%" >
 </td>
</tr>
</table>
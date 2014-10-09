<?php 

//Dывод в виде таблицы
echo "<table class=tableO>";

//Шапка таблицы	 
echo 
"<tr bgcolor=#D8D8D8><td >","Дата операции",
"</td><td>","№",
"</td><td>","Корреспондент",
"</td><td>","Доход",
"</td><td>","Расход",
"</td></tr>";

//Первая строка таблицы
//Дату преобразуем в формат дд-мм-гггг	
if ($data[0]['Date'])
{
$data[0]['Date']=date("d-m-Y", strtotime($data[0]['Date']));	
}	
echo 
"<tr><td class=tdOO>",$data[0]['Date'],
"</td><td class=tdOO>",$data[0]['Id'],
"</td><td class=tdOO>",$data[0]['Fam']," ", $data[0]['Name'], " ",$data[0]['Otch'],
"</td><td class=tdOO>",$data[0]['Sale'],
"</td><td class=tdOO>",$data[0]['Buy'],
"</td></tr>";

//Все остальные строки таблицы
$i = 1;
$n=$data['count'];
do 
{
//Дату преобразуем в формат дд-мм-гггг		
if ($data[$i]['Date'])
{
$data[$i]['Date']=date("d-m-Y", strtotime($data[$i]['Date']));	
}	
//Определяем четность-нечетность строки, чтобы таблица была полосатой 
  if($i%2)   
  {$clas="tdO";}
  else
  {$clas="tdOO";}
//Если дата текущей строки та же, что и в пердыдущей, то оставляем ячейку пустой 
  if ( $data[$i]['Date']!=$data[$i-1]['Date'] ) 
   {
   echo "<tr><td class=",$clas,">",$data[$i]['Date'];
   }
   else
   {
   echo "<tr><td class=",$clas,">"," ";
   }
  echo
  "</td><td class=",$clas,">",$data[$i]['Id'],
  "</td><td class=",$clas,">",$data[$i]['Fam']," ", $data[$i]['Name'], " ",$data[$i]['Otch'],
  "</td><td class=",$clas,">",$data[$i]['Sale'],
  "</td><td class=",$clas,">",$data[$i]['Buy'],
  "</td></tr>";
 }
 while ($i++<$n);
 
// Выводим итоговые строки 
echo 
"<tr bgcolor=#D8D8D8><td colspan=3>","Итого за период:",
"</td><td>",number_format($data[$n+1]['Sale'], 2, '.', ''),
"</td><td>",number_format($data[$n+2]['Buy'], 2, '.', ''),
"</td></tr>";
echo
"<tr bgcolor=#D8D8D8><td colspan=3>",$data['itogName'],
"</td><td colspan=2 align=center>",number_format($data['itog'], 2, '.', ''),
"</td></tr>";

echo "</table>";	

?>

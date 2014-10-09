<?php
//Класс извлекает данные из БД, на основе которых строится отчет
class newReport extends Model
{
	public $result;
	
function __construct() 
	{
	$this->result['flag']=0;
	$this->result['error']='';
	}

// Полученные из БД данные выводим в отчет
function dataReportOutput($date1, $date2)	 
{ 
$data=$this->dataReport($date1, $date2);	  
include "application/views/view_reportData.php";
	
}

//Выбираем данные для отчета, за указанный пользователе мпериод
function dataReport($date1, $date2)
{
$this->result['date1']=$date1;
$this->result['date2']=$date2;

$date1= date("Y-m-d", strtotime($date1));
$date2= date("Y-m-d", strtotime($date2));

// Выбираем из БД данные, необходимые для отчета
/*Результат запроса будет иметь поля: 
Дата операции,  паспорт, ФИО корреспондента,  ИД операции, Сумма дохода, Сумма расхода.

Результирующая таблица состоит из двух частей: сначала выбираются операции продажи, потом операции покупки валюты. В операциях продажи поле "сумма расхода" -пустое, в операциях покупки поле "сумма дохода" - пустое.

Затем данные сортируются в пригодном для отчета порядке*/
  $Qdata = mysql_query("SELECT Date, Kor, Fam, Name, Otch, Id, SumGrn as Sale, ' ' as Buy, Vid FROM Exchange inner join Kor On Exchange.Kor=Kor.Pasport Where Date >= '$date1' and Date <= '$date2' and Vid = 'sale'  
union 
SELECT Date, Kor, Fam, Name, Otch, Id, ' ' as Sale, SumGrn as Buy,  Vid FROM Exchange inner join Kor On Exchange.Kor=Kor.Pasport Where Date >= '$date1' and Date <= '$date2' and Vid = 'buy'   Order by Date, Id, Kor, Fam,  Name, Otch, Vid; ");
while ($this->result[] = mysql_fetch_assoc($Qdata));
$this->result['count']=mysql_num_rows($Qdata);

// Проверяем, есть ли данные в выборке
$n=$this->result['count'];
if ($n==0) 
 {
 $this->result['error']="За выбранный период нет операций!";
 }
 
// Выбираем данные для итоговых значений отчета: суммы по продаже и по покупке

$Qtotal = mysql_query("SELECT Sum(SumGrn) as Sale, ' ' as Buy FROM Exchange  Where Date >= '$date1' and Date <= '$date2' and Vid = 'sale' 
union 
SELECT ' ' as Sale, Sum(SumGrn) as Buy FROM Exchange Where Date >= '$date1' and Date <= '$date2' and Vid = 'buy' ");
while ($this->result[] = mysql_fetch_assoc($Qtotal));

// Находим прибыль/убыток
$this->result['itog']=$this->result[$n+1]['Sale'] - $this->result[$n+2]['Buy'];
  if ($this->result['itog']>=0)
   {
	$this->result['itogName']="Прибыль за период:";
	}
  else 
  {
   $this->result['itogName']="Убыток за период:";
   }

return $this->result;
}


}


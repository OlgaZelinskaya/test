<?php

class enterDataExchange extends Model
{
public $result;
	
//Переводим сумму операции обмена в гривны: в зависимости от выбранной валюты и от вида операции (покупки или продажи)
function sum_oper($valyuta, $kurs, $sum, $sale) 
{
$today =  date("Y-m-d");
$result['sum']=$sum;
$result['kurs']=$kurs;
	 
//Определяем курс валюты, если вид операции - продажа
if ($sale=="true")
 {
$Q = mysql_query("SELECT Sale FROM Kurs Where Date= '$today' and Valyuta='$valyuta' ");
 	while ($row = mysql_fetch_array($Q))
 	 {
	 $result['kurs']=number_format($row[Sale], 3, '.', '');
	 }
	}
//Определяем курс валюты, если вид операции - покупка
	else
	 {
	 $Q = mysql_query("SELECT Buy FROM Kurs Where Date= '$today' and Valyuta='$valyuta' ");
 	while ($row = mysql_fetch_array($Q))
 	{
	$result['kurs']=number_format($row[Buy], 3, '.', '');
	}
   }
//Расчитываем эквивалент в гривнах
$result['sumGrn'] =number_format($result['kurs']*$result['sum'], 2, '.', ''); 
echo json_encode($result);  
}



// По введенным паспортным данным находим ФИО корреспондента
function outputKor($pasport) 
{
$Q = mysql_query("SELECT Fam, Name, Otch FROM Kor Where Pasport = '$pasport';");
$result = mysql_fetch_assoc($Q);
echo json_encode($result);  
}

}



 // Сохранение данных из формы обмена валют в БД
class saveDataExchange extends Model
{
	public $result;
	
function __construct() 
{
$this->result['flag']=0;
$this->result['error']=0;
}


//Определяем номер следующей обменной операции	
function new_date() 
{
$result['today'] =  date("d.m.Y");    
$Q = mysql_query("SELECT MAX(Id) as Id FROM Exchange");
while ($row = mysql_fetch_array($Q))
{$result['number'] = $row[Id];}
return $result; 
}
	

// Проверка всех введенных данных
function data_exchange($data) 
{
$this->empty_data($data);
if (!$this->result['error'])
 {	
 $this->result['error']=0;
 $this->validate_sum($data['sumSale']);
   if (!$this->result['error'])
   {
   $this->validate_pas($data['pasSale']);
     if (!$this->result['error'])
      {
      $this->validate_fio($data);
	  if (!$this->result['error'])
       {
     $data['famSale']=$this-> format_fio($data['famSale'], 1);
	   $data['nameSale']=$this-> format_fio($data['nameSale'], 1);
	   $data['otchSale']=$this-> format_fio($data['otchSale'], 1);
	   $data['pasSale']=$this-> format_fio($data['pasSale'], 2);
	   $this->save_data($data);	 
       }	 
      }
   }
 }
echo json_encode($this->result); 
}

//Проверка: все поля - не пустые
function empty_data($d) 	{
  foreach ($d as $key=>$value)
    {
	if (!$value)
   	 {
 	 $this->result['error']="Необходимо заполнить все поля!";
	 }
	}	
  return $this->result['error'];
}

//Проверка: сумма операции - целочисленное значение
function validate_sum($sum) 	{

	   if (!preg_match("~^\d*$~ ", $sum))
		{
		$this->result['error']="Некорректный формат суммы! (Сумма - целое число)";
		}
	return $this->result['error'];
	}
	
	
//Проверка: паспортные данные в формате АЇ123456 (две букві кириллицы и шесть цифр)
function validate_pas($pas) 	
{
	   if (!preg_match("~^\s*[а-яА-ЯЄєЇїІіҐґ]{2}\s*[0-9]{6}\s*$~u", $pas))
		{
		$this->result['error']="Некорректный формат паспортных данных! (Пример: АЇ123456)";
		}
	return $this->result['error'];
		

}

//Проверка: ФИО - текст на кириллице
function validate_fio($d) 	{
	$this->result['error']=0;
	
if((!preg_match("~^[А-Яа-яЇїІіЄєҐґ-\s]+$~u", $d['famSale'])) or (strlen($d['famSale'])<3) )
 {
 $this->result['error']="Некорректно указана фамилия корреспондента!";
  
 }
 else
 {	
   if(!preg_match("~^[А-Яа-яЇїІіЄєҐґ-\s]+$~u", $d['nameSale']) or strlen($d['nameSale'])<3)
   {
   $this->result['error']="Некорректно указано имя корреспондента!";
 
   }
   else
   {	
   if(!preg_match("~^[А-Яа-яЇїІіЄєҐґ-\s]+$~u", $d['otchSale']) or strlen($d['otchSale'])<3)
   {
   $this->result['error']="Некорректно указано отчество корреспондента!"; 
   }
  }
}
return $this->result['error'];
}

//Преобразовываем ФИО и паспорт (предварительно убрав пробелы) к виду: Первая буква заглавная, остальные маленькие. В паспорте - две первые буквы заглавные
function format_fio($string, $param) 
{ 
$string = mb_ereg_replace("[\s]+","", $string); 
$string=mb_strtolower($string, 'utf-8'); 
$string = mb_strtoupper(mb_substr($string, 0,$param, "UTF-8"), "UTF-8").mb_substr($string, $param, mb_strlen($string), "UTF-8" );  
return $string; 
}


//Сохранение  данных об операции обмена в БД
function save_data($d)
{
// Вносим данные из формы в БД	
$d['dateSale'] = date("Y-m-d", strtotime($d['dateSale']));
$d['ekvSale'] = number_format($d['ekvSale'], 2, '.', '');		

mysql_query( "INSERT INTO Exchange (Vid, Date, Valyuta, SumVal, SumGrn, Kor)" ."VALUES('{$d["radio"]}', '{$d["dateSale"]}', '{$d["selectSale"]}', '{$d["sumSale"]}', '{$d["ekvSale"]}', '{$d["pasSale"]}');");

$this->result['flag']=1;
$this->result['error']= "Новая запись внесена в базу!";

// Если корреспондент новый, то его тоже вносим
$Q = "SELECT Pasport FROM Kor Where Pasport = '$d[pasSale]';";
$row = mysql_query($Q);
if (mysql_num_rows($row)==0)
{    
mysql_query ( "INSERT INTO Kor (Fam, Name, Otch, Pasport)" . "VALUES('{$d["famSale"]}', '{$d["nameSale"]}', '{$d["otchSale"]}', '{$d["pasSale"]}');");
}
return $this->result['error'];
}

}


<?php

class Validation extends Model
{

	private $result = array();

	
function __construct() 
{
$this->result['flag']=0;
$this->result['error']=0;
}
	
//Проверяем и форматируем введенную дату	
function enter_user_date($date)	 
{	
$this->validate_date($date);
 if (!$this->result['error'])
 {
 $this->format_date($date);			
 }

return $this->result;
}



//Проверка: Формат даты дд-(-./)мм(-./)гггг	
function validate_date($date) 
	{
	if(!preg_match("~^(0[1-9]|[12][0-9]|3[01])[-\.\/,](0[1-9]|1[012])[-\.\//,]\d{4}$~", $date) )
	{
	$this->result['error']="Некорректный формат даты!"; 
	}
	return $this->result['error'];
	}
	
	
	
//Приводим дату к формату гггг-мм-дд. Если дата очень ранняя, или очень поздняя - нет смысла с ней работать, заменяем ее на сегодняшнюю	
function format_date($date)	
	{
// В полученной дате символы "/"  "."  "," заменяем на "-" 
 	 $date= preg_replace('~[\/\.,]+~', '-', $date);
//Замена даты на текущую
	 $date= date("Y-m-d", strtotime($date));
	 if ($date<"2000-01-01" or $date>"2030-01-01" )
	  {
	  $date=date("Y-m-d");
 	  }
     $this->result['newDate']=date("d-m-Y", strtotime($date));
	 return $this->result['newDate']; 
  }




//Проверка: дана начала периода должна быть не более поздней, чем дата конца периода
function validate_period($date1, $date2) 	
{
 $date1= date("Y-m-d", strtotime($date1));
 $date2= date("Y-m-d", strtotime($date2));
 if ($date1>$date2)
 {
 $this->result['error']="Дата начала периода больше даты конца периода!";
 }
return $this->result;
}


// Проверка: все поля должны быть заполнены
function empty_data($data) 	
{
  foreach ($data as $key=>$value)
    {
	if (!$value)
   	 {
 	 $this->result['error']="Необходимо заполнить все поля!";
	 }
	}
  return $this->result;
  }


//Проверка: значение курса валюты - числовое значение
function validate_Kurs($data) 	
{
	foreach($data as $key=>$value)
	{
	 if ($key!='Date')
	   {
	   if (!preg_match("~^\d*[\.,]?\d*$~ ", $value))
		{
		$this->result['error']="Некорректный формат курса!";
		}
		}
	}
	return $this->result;
}
		



//Проверка: сумма операции - целочисленное значение
function validate_sum($sum) 	{

	   if (!preg_match("~^\d*$~ ", $sum))
		{
		$this->result['error']="Некорректный формат суммы! (Сумма - целое число)";
		}
	return $this->result['error'];
	}
	
	
	
//Проверка паспортных данных: две буквы кириллицы, шесть цифр
function validate_pas($pas) 	{

	   if (!preg_match("~^\s*[а-яА-ЯЄєЇїІіҐґ]{2}\s*[0-9]{6}\s*$~u", $pas))
		{
		$this->result['error']="Некорректный формат паспортных данных! (Пример: АЇ123456)";
		}
	return $this->result['error'];
}



// Проверка: ФИО - строка на кириллице, не менее 2х букв
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



//Преобразовываем ФИО к виду: Первая буква заглавная, остальные маленькие(предварительно убрав пробелы). $param - количество заглавных букв в строке (в фио - одна первая буква, в паспорте - две первые буквы)
function format_fio($string, $param) 
{ 
$string = mb_ereg_replace("[\s]+","", $string); 
$string=mb_strtolower($string, 'utf-8'); 
$string = mb_strtoupper(mb_substr($string, 0,$param, "UTF-8"), "UTF-8").mb_substr($string, $param, mb_strlen($string), "UTF-8" );  
return $string; 
}



	
}
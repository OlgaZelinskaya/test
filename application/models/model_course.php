<?php
// Класс выполняет обработку введенной даты в форму для курсов валют:
//В зависимости от значения даты: 
  //Или выводятся курсы валют за введенную дату (если они уже установлены)
  //Или дается возможность ввсести их (если они еще не были установлены)
  //Или сообщается о том, что они не были введены, и ввести их уже нельзя (если указанная дата уже прошла)
class Set_Date extends Model
{
	private $result = array();
	
function __construct() 
	{
	$this->result['flag']=0;
	$this->result['error']=0;
	}
	

//Вызываем метод обработки даты	
function set_user_date($date)	 
{	
$this->get_data($date);
return $this->result;
}	

	
//Обработка введенной даты: 
//Если курсы за выбранную дату установлены, выводим их
//Если курсы не установлены и дата введена уже прошедшая, оставляем пустые поля и сообщение о том, что курсов за этот день нет
//Если курсы не установлены, и дата текущая, или будующая - ничего не выводим
function get_data($date)	 
	{

$date= date("Y-m-d", strtotime($date));
 	$kursVal = mysql_query("SELECT Valyuta, Buy, Sale From Kurs Where date='$date' order by Valyuta");
 	while ($this->result[] = mysql_fetch_assoc($kursVal));
	 //Если установлены курсы валют за введенную дату
	 if ($this->result[1])
	  {
	  $this->result['inf']="Данные доступны только для просмотра!";
	  $this->result['flag']=1;
	  }
	  //Если за введенную дату курсы не установлены
	 else 
	  {
	  if ($date<date("Y-m-d")) {
	  $this->result['inf']="За выбранную дату не установлены курсы валют!";
	  $this->result['flag']=2;
	  }	
	  }
	 $this->result['newDate']=date("d-m-Y", strtotime($date)); 
	 return $this->result; 
	}
}




// Класс выполняет сохранение введенных курсов валют в базу данных.
class Set_Course 
{	
private $result = array();


function __construct() 
{
$this->result['flag']=0;
$this->result['error']=0;
}


function enter_kurs($Kurs)	 
{ 
$this->save_Kurs($Kurs);  
return $this->result;
}

//
function save_Kurs($Kurs) 	
{
//Дату в БД вводим в формате гггг-мм-дд
$Kurs['Date']= date("Y-m-d", strtotime($Kurs['Date']));
 
// Значения курсов  приводим к формату 3 знака после точки
foreach ($Kurs as $key=>$value)
 {
  if ($key!='Date')
  {
  $Kurs[$key]=number_format(preg_replace('~[,]+~', '.', $value), 3, '.', '');
  }
}
//Вносим значения в БД. Это будет 3 строчки:
 // Курс доллара
mysql_query ( "INSERT INTO kurs (Date, Valyuta, Buy, Sale)" ."VALUES('{$Kurs["Date"]}','USD', '{$Kurs["BuyUSD"]}', '{$Kurs["SaleUSD"]}');");
 //Курс евро
mysql_query ( "INSERT INTO Kurs (Date, Valyuta, Buy, Sale)" . "VALUES('{$Kurs["Date"]}','EUR', '{$Kurs["BuyEUR"]}', '{$Kurs["SaleEUR"]}');");
 //Курс рубля
mysql_query ( "INSERT INTO Kurs (Date, Valyuta, Buy, Sale)" . "VALUES('{$Kurs["Date"]}', 'RUB', '{$Kurs["BuyRUB"]}', '{$Kurs["SaleRUB"]}');");
		
$this->result['error']="Курсы валют внесены в базу данных!";

//Флаг=1 говорит об успешном сохранении. Т.к. могут быть случаи, когда кнопка "Сохранить", нажата, но данные не сохранены - из-за некорректности данных
$this->result['flag']=1;
return $this->result['error'];
 }
}



//Класс определяет, возможно ли перейти к вкладке "Обмен валют.Переход возможен только если курсы валют установлены на сегодняшний день
class goToExchange 
{	
private $result = array();

function __construct() 
{
$this->result['flag']=0;
$this->result['error']=0;
}


// Проверям, установлены ли курсы на текущую дату: если результат запроса не пустой, значит курсы установлены
function proverka()	 
{ 
$today=date("Y-m-d");
$Q = mysql_query("SELECT Sale, Buy From Kurs Where Date='$today'");
while ($this->result[] = mysql_fetch_assoc($Q))
if ($this->result[1])
 {
 $this->result['flag']=1;
 }
$this->result["error"]="Для перехода к операциям обмена необходимо внести курсы валют на сегодня!";
echo json_encode($this->result);
}
}
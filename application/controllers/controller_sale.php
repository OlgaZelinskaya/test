<?php
//  ласс перенаправл€ет к модели в зависимости от действий пользовател€
class Controller_Sale extends Controller
{

	function __construct()
	{
	$this->view = new View();
	}
// ƒействие по умолчанию - загрузка страницы "ќперации обмена"	
function action_index()
	{
	 // метод new_date() определ€ет номер операции обмена и устанавливает текущую дату в форму
	 include "application/models/model_sale.php";
	 $modelExchange = new  saveDataExchange();
	 $data=$modelExchange->new_date();
	 $this->view->generate('view_sale.php', 'view_template.php', $data);
	}
	
	
//¬веденные сумма операции, валюта, вид направл€ютс€ на обработку	
function action_enterDataExchange()  
	{
	$UserValyuta  = $_POST[valyuta];
	$UserKurs = $_POST[kurs];
	$UserSum = $_POST[sum];  
	$operSale = $_POST[operSale];
		
	include "application/models/model_sale.php";
	$modelExchange1 = new enterDataExchange();
	$modelExchange1->sum_oper($UserValyuta, $UserKurs, $UserSum, $operSale);
	}
	
	
// ¬веденные паспортные данные направл€ютс€ на проверку: есть ли в Ѕƒ уже такой корреспондент	
function action_enterPasport()  
	{
	$userPasport  = $_POST[pasport];
	include "application/models/model_sale.php";
	$modelExchange2 = new enterDataExchange();
	$modelExchange2->outputKor($userPasport);
	}
	
	
//¬се данные формы направл€ютс€ на проверку сохранение	
function action_saveData()  
	{
	$userDataExchange = $_POST;
	include "application/models/model_sale.php";
	$modelSave = new  saveDataExchange();
	$modelSave->data_exchange($userDataExchange);
	}	
	



	
}

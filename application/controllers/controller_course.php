<?php
// Класс перенаправляет к модели в зависимости от действий пользователя
class Controller_Course extends Controller
{
// Действие по умолчанию - загрузка страницы "Курсы валют"
	function action_index() 
	{	
	$this->view->generate('view_course.php', 'view_template.php');
	}

//Направляем на проверку и на обработку введенную дату
function action_enterDate()  
{
$userDate = $_POST[Date];
 if ($userDate)
 {
 include "application/models/model_validation.php";	
	$modelValidation = new  Validation();
	$res=$modelValidation->enter_user_date($userDate);
	}
	
	if (!$res['error'])
	{
	include "application/models/model_course.php";	
	$modelDate = new  Set_Date();
	$res=$modelDate->set_user_date($res['newDate']);	
	}
	echo json_encode($res);
	}
	
//Направляем на проверку и на сохранение введенные курсы валют	
function action_enterKurs() 
	 {		
	 $userKurs = $_POST;
	 include "application/models/model_validation.php";
	 $Validation = new  Validation();
	 $res=$Validation->empty_data($userKurs);
	 if (!$res['error'])
	 {
	 $Validation1 = new  Validation();
	 $res=$Validation1->validate_Kurs($userKurs);
	  if (!$res['error'])
	   {
	    include "application/models/model_course.php";
	    $modelKurs = new Set_Course();
	    $res=$modelKurs->enter_kurs($userKurs);   
	   }
	  }
	echo json_encode($res);
	}


//При желании перейти в "Операции обмена" создаем объект класса проверяющий, возможно ли это  
function action_goToExchange() 
	 {		
	    include "application/models/model_course.php";
	    $Obj = new goToExchange();
	    $Obj->proverka();   
}	

}
   
  
 


<?php
// ����� �������������� � ������ � ����������� �� �������� ������������
class Controller_Course extends Controller
{
// �������� �� ��������� - �������� �������� "����� �����"
	function action_index() 
	{	
	$this->view->generate('view_course.php', 'view_template.php');
	}

//���������� �� �������� � �� ��������� ��������� ����
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
	
//���������� �� �������� � �� ���������� ��������� ����� �����	
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


//��� ������� ������� � "�������� ������" ������� ������ ������ �����������, �������� �� ���  
function action_goToExchange() 
	 {		
	    include "application/models/model_course.php";
	    $Obj = new goToExchange();
	    $Obj->proverka();   
}	

}
   
  
 


<?php
// ����� �������������� � ������ � ����������� �� �������� ������������
class Controller_Sale extends Controller
{

	function __construct()
	{
	$this->view = new View();
	}
// �������� �� ��������� - �������� �������� "�������� ������"	
function action_index()
	{
	 // ����� new_date() ���������� ����� �������� ������ � ������������� ������� ���� � �����
	 include "application/models/model_sale.php";
	 $modelExchange = new  saveDataExchange();
	 $data=$modelExchange->new_date();
	 $this->view->generate('view_sale.php', 'view_template.php', $data);
	}
	
	
//��������� ����� ��������, ������, ��� ������������ �� ���������	
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
	
	
// ��������� ���������� ������ ������������ �� ��������: ���� �� � �� ��� ����� �������������	
function action_enterPasport()  
	{
	$userPasport  = $_POST[pasport];
	include "application/models/model_sale.php";
	$modelExchange2 = new enterDataExchange();
	$modelExchange2->outputKor($userPasport);
	}
	
	
//��� ������ ����� ������������ �� �������� ����������	
function action_saveData()  
	{
	$userDataExchange = $_POST;
	include "application/models/model_sale.php";
	$modelSave = new  saveDataExchange();
	$modelSave->data_exchange($userDataExchange);
	}	
	



	
}

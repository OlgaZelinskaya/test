<?php
//  ласс перенаправл€ет к модели в зависимости от действий пользовател€
class Controller_Report extends Controller
{
// ƒействие по умолчанию - загрузка страницы "ќтчеты"	
function action_index()
{	
$this->view->generate('view_report.php', 'view_template.php');
}

//¬веденные данные отправл€ютс€ на проверку и н обработку
function action_validationDate()  
{
$data['date1']=$_POST[date1];
$data['date2']=$_POST[date2];

include "application/models/model_validation.php";
$Validation = new  Validation();
$res=$Validation->empty_data($data);
 
 if (!$res['error'])
 {
 $Validation1 = new  Validation();
 $res=$Validation1->enter_user_date($data['date1']);
 if ($res['newDate'])
 {$data['date1']=$res['newDate'];}

   if (!$res['error'])
   {
  
  $Validation2 = new  Validation();
  $res=$Validation2->enter_user_date($data['date2']);
  if ($res['newDate'])
  {$data['date2']=$res['newDate'];}

  if (!$res['error'])
   {
   $Validation3 = new  Validation();
   $res=$Validation3->validate_period($data['date1'],$data['date2']);
 }
 }
}
$result['date1']=$data['date1'];
$result['date2']=$data['date2'];
if ($res['error'])
{$result['error']=$res['error'];}
else
{$result['flag']=1;}
echo json_encode($result);
}


function action_doReport()
{
$data['date1']=$_POST[date1];
$data['date2']=$_POST[date2];	
include "application/models/model_report.php";
$modelReport = new  newReport();
$modelReport->dataReportOutput($data['date1'], $data['date2']); 
}



}
	


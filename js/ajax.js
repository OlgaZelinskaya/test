function setDate() { // ���������� ����, ��������� �������������, ��� ����������� ������ �� ��� ����
	
var Date = $("#Date").val();
       $.ajax({
         type: "POST",
          url: "course/enterDate",
          data: "Date="+Date,
		  dataType: "json",
		  success: function(data) {
			  if (data.error!=0)
			  {
			  $('#save').attr('disabled', true);
			  $("#result").empty(); $("#result").append(data.error);
			  $('input[type=text][id != "Date"]').val('');
			  }
			  else
			  {
				  if (data.flag==0)
				  {
				  $('#save').attr('disabled', false);
				  $('input[type=text]').attr('disabled', false);
				  $('input[type=text][id != "Date"]').val('');
				  $("#Date").val(data.newDate);
				  $("#result").empty();
				  }
				  else if (data.flag==2)
				  {
					$("#DateError").empty();
					$("#result").empty(); $("#result").append(data.inf);
					$('input[type=text][id != "Date"]').attr('disabled', true);
				    $('input[type=text][id != "Date"]').val('');
					$("#Date").val(data.newDate);
					$('#save').attr('disabled', true);
				  }
					else if (data.flag==1)
					{
					$("#Date").val(data.newDate);	
				   	$("#BuyUSD").val(data[2].Buy);
			   		$("#SaleUSD").val(data[2].Sale);
			  		$("#BuyEUR").val(data[0].Buy);
			   		$("#SaleEUR").val(data[0].Sale);
			   		$("#BuyRUB").val(data[1].Buy);
			   		$("#SaleRUB").val(data[1].Sale); 
					$('#save').attr('disabled', true);
					$("#result").empty(); $("#result").append(data.inf);
					$('input[type=text][id != "Date"]').attr('disabled', true);
					}
			  }}
     });    
};


$(function() {
    $("#Date").change(setDate);
})


function resetKurs() // ������ "����� ������" � ����� ����� ������
{ 
$('#result').empty();
$('#DateError').empty();
$('input[type=text]').attr('disabled', false);
$('#save').attr('disabled', true);
}

function resetKurs1() // ������ "����� ������" � ����� ������ �����
{ 
$('#result').empty();
$('input[type=text]').attr('disabled', false);
$('#saveSale').attr('disabled', false);
$('#selectSale').attr('disabled', false);
$('input[type=radio]').attr('disabled', false);	
}


function send_kurs() // ���������� ��������� �������������  ����� �����  
{
Kurs = $("#myform").serialize();
       $.ajax({
         type: "POST",
          url: "course/enterKurs",
          data: Kurs,
		  dataType: "json",
          success: function(data) {
               $("#result").empty();
			   $("#result").append(data.error);
			    if(data.flag==1) 
				{
				$('input[type=text]').attr('disabled', true);
				$('#save').attr('disabled', true);
				}
			  
		  }
		});
}





function sendSum() { // ���������� ��������� ������ � ����� ��������

var operSale = $("#sale").attr("checked");	
var valyuta = $('#selectSale').val();
var sum = $('#sumSale').val();
var kurs = $('#kursSale').val();	
       $.ajax({
         type: "POST",
          url: "sale/enterDataExchange",
          data: "operSale="+operSale+"&valyuta="+valyuta+"&sum="+sum+"&kurs="+kurs,
		  
		  dataType: "json",
		  success: function(data) {
			     $("#kursSale").empty();
                 $("#kursSale").val(data.kurs);
				 $("#resultSum").empty();
				 if  ($('#sumSale').val()!='')
				 {
                 $("#resultSum").val(data.sumGrn);
				 }
			     }
   });    
}

$(function() {
    $('#selectSale').change(sendSum);
})

$(function() {
    $('#sumSale').keyup(sendSum);
})

$(function() {
    $('#buy').click(sendSum);
})

$(function() {
    $('#sale').click(sendSum);
})

function outputKor() { // ���� ���������� ������

var pasport = $('#pasport').val();	
       $.ajax({
         type: "POST",
          url: "sale/enterPasport",
          data: "pasport="+pasport,
		  dataType: "json",
		  success: function(data) {
			     $("#Fam").val(data.Fam);
				 $("#Name").val(data.Name);
                 $("#Otch").val(data.Otch);
			     }
   });    
}

$(function() {
    $('#pasport').keyup(outputKor);
})


$(function () { // ��� ������, ��������� �������������  � ����� ������ �����

$("#saveSale").click(function(){
{
dataExchange = $("#formExchange").serialize();
       $.ajax({
         type: "POST",
          url: "sale/saveData",
          data: dataExchange,
		  dataType: "json",
          success: function(data) {
               $("#result").empty();
			   $("#result").append(data.error);
			    if(data.flag==1) 
				{
				$('input[type=text]').attr('disabled', true);
				$('#selectSale').attr('disabled', true);
                $('#saveSale').attr('disabled', true);
				$('input[type=radio]').attr('disabled', true);	
				}
		  }
		});
	  }
	});	
  })


$(function() {
    $('#goToExchange').click(proverka);
})
	
function proverka() //�������� �������� ������: ���� ����� �� ������� �� ����������� ���� - ��������� ���������� �� �������� �������� ������.
{       $.ajax({
          type: "POST",
          url: "course/goToExchange",
          dataType: "json",
          success: function(data) {
			    	if(data.flag==0)
          		   {alert(data.error);
					return false;}
					else
					{window.location.href = "/test/sale";}
			 }
        });

}



$(function() {
    $('#date1').change(reportDate);
})

$(function() {
    $('#date2').change(reportDate);
})



function reportDate() // �������� �� �������� ��� ���� �� ����� ������
{

var date1 = $('#date1').val();
var date2 = $('#date2').val();
       $.ajax({
          type: "POST",
          url: "report/validationDate",
		  data: "date1="+date1+"&date2="+date2, 
		 dataType: "json",
          success: function(data) {
			     $("#date1").val(data.date1);
				 $("#date2").val(data.date2);
				$("#result").empty();
          		 $("#result").append(data.error);
				 if(data.flag==1) 
				{
				$("#report").attr('disabled', false);
				}
				else
				{
				$("#report").attr('disabled', true);
				}

              }
								
        });
}

$(function() {
    $('#report').click(doReport);
})



function doReport() // �������� ���� ��� ����������� ������
{

var date1 = $('#date1').val();
var date2 = $('#date2').val();
       $.ajax({
          type: "POST",
          url: "report/doReport",
		  data: "date1="+date1+"&date2="+date2, 
          success: function(data) {
				$("#result").empty();
          		 $("#result").append(data);
				

              }
								
        });
}

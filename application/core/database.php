<?php

class DataBase
{

public static function db_connect()
{
mysql_connect("localhost", "olga", "111")
or die("<p>������ ����������� � ���� ������! " . mysql_error() . "</p>");
mysql_select_db("db")
or die("<p>������ ������ ���� ������! ". mysql_error() . "</p>");
mysql_query("SET NAMES 'utf8'");
}


}

?>



<?php

class Route
{

		static function start()
	{
		// контроллер и действие по умолчанию
		$controller_name = 'Course';
		$action_name = 'index';
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		// получаем имя контроллера
		if ( !empty($routes[2]) )
		{	
			$controller_name = $routes[2];
		}
		
		 //получаем имя экшена
		if ( !empty($routes[3]) )
		{
			$action_name = $routes[3];
		}

		// добавляем префиксы
		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		$action_name = 'action_'.$action_name;


		// подцепляем файл с классом контроллера
	    $controller_file = strtolower($controller_name).'.php';
		$controller_path = "application/controllers/".$controller_file;
		if(file_exists($controller_path))
		{
			include "application/controllers/".$controller_file;
		}

		// создаем контроллер
		$controller = new $controller_name;
		$action = $action_name;
		
		if(method_exists($controller, $action))
		{
			$controller->$action();
		}
		
	}
  
}




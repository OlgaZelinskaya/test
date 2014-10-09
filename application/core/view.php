<?php

class View
{

	function generate($view_content, $view_template, $data = null)
	{
		include 'application/views/'.$view_template;
		
	}
}

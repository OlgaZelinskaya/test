<?php

ini_set('display_errors', 1);
 
require_once 'application/core/model.php';
require_once 'application/core/view.php';
require_once 'application/core/controller.php';

require_once 'application/core/database.php';
DataBase::db_connect();

require_once 'application/core/route.php';
Route::start(); 

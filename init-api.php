<?php
	// ini-api.php
	// Init all required classes, get the data and the action from the post
	// Disabled html errors => more readable with http requester
	ini_set('html_errors', false);
	ini_set('html_warnings', false);
	
	// Allow cross access origin => can be accessible from all domains
	header("Access-Control-Allow-Origin: *");
	// Set the datatype to JSON
	// Set the encoding to utf8 => avoid problems with characters
	header('Content-Type: application/json; charset=utf-8');
	// Include config
	$dbConfig = require "config/database.php";

	// Include all mandatory classes
	require "classes/database-manager.class.php";
	require "classes/api.class.php";

	// Create the database manager
	$Db = new DatabaseManager($dbConfig);
	$Api = new Api($Db);

    // Get the data and the action
	$data = $Api->getData($_POST);
	$action = $Api->getAction($_POST);

    // 0  => Unknown action
    // 1  => Missing arguments
    // 2  => Permission denied
    // 3  => Success
    // 3+  => Custom
	$result = array("code" => 0, "data" => array());
	
    $path = array("class" => "../classes/", "root" => "../");
    
	// echo var_dump($Db->getResult("SELECT * FROM category"));
?>
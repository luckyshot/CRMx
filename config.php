<?php
/*
	,o888888o.    8 888888888o.            ,8.       ,8.          `8.`8888.      ,8' 
   8888     `88.  8 8888    `88.          ,888.     ,888.          `8.`8888.    ,8'  
,8 8888       `8. 8 8888     `88         .`8888.   .`8888.          `8.`8888.  ,8'   
88 8888           8 8888     ,88        ,8.`8888. ,8.`8888.          `8.`8888.,8'    
88 8888           8 8888.   ,88'       ,8'8.`8888,8^8.`8888.          `8.`88888'     
88 8888           8 888888888P'       ,8' `8.`8888' `8.`8888.         .88.`8888.     
88 8888           8 8888`8b          ,8'   `8.`88'   `8.`8888.       .8'`8.`8888.    
`8 8888       .8' 8 8888 `8b.       ,8'     `8.`'     `8.`8888.     .8'  `8.`8888.   
   8888     ,88'  8 8888   `8b.    ,8'       `8        `8.`8888.   .8'    `8.`8888.  
	`8888888P'    8 8888     `88. ,8'         `         `8.`8888. .8'      `8.`8888. 

Copyright (c) 2013 Xavi Esteve

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/

option('base_uri', '/'); // '/' or same as the RewriteBase in your .htaccess

date_default_timezone_set('Europe/London');

define("SITE_NAME", "CRMx"); // Default sitename when none specified in environments
define("SITE_VERSION", "0.2.6b");

define("MYSQL_SERVER", "localhost");
define("MYSQL_USER", "user");
define("MYSQL_PASS", "pass");
define("MYSQL_DATABASE", "database");

define("LANG_DEFAULT", "en_us"); // Default language

// Plugin list
$plugins = array(/*'test'*/);


// Environments
$form = array(
	'test_' => array( // table prefix
		// name (default)
		// title (default)
		array(
			'title' => 'Group',
			'name' => 'group',
			'type' => 'select',
			'list' => array( "-", "London", "Barcelona")
		),
		array(
			'title' => 'Type',
			'name' => 'type',
			'type' => 'select',
			'list' => array( "-", "Partner", "Client", "Lead")
		),
		array(
			'title' => 'Email',
			'name' => 'email',
			'type' => 'email'
		),
		array(
			'title' => 'Phone Number',
			'name' => 'phone',
			'type' => 'tel'
		),
		array(
			'title' => 'Company',
			'name' => 'company',
			'type' => 'search'
		),
		array(
			'title' => 'Address',
			'name' => 'address',
			'type' => 'search'
		)
	)
);


// Users
$users = array(
	// Environment: test_
	array(
		'name' => 'Tester',
		'pass' => 'test',
		'level' => 'rsdc',
		'dbprefix' => 'test_',
		'sitename' => 'CRMx Example'
	)
);

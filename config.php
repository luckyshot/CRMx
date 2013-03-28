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

option('base_uri', '/'); # '/' or same as the RewriteBase in your .htaccess

date_default_timezone_set('Europe/London');

define("SITE_NAME", "CRMx");
define("SITE_VERSION", "0.1.6b");

define("MYSQL_SERVER", "localhost");
define("MYSQL_USER", "user");
define("MYSQL_PASS", "pass");
define("MYSQL_DATABASE", "database");


// Environments
$form = array(
	// Type can be: text, select, color, date, datetime, datetime-local, email, month, number, range, search, tel, time, url and week
	'test_' => array( // table prefix
		// name (default)
		// title (default)
		array('name' => 'group',	'title' => 'Group',	'type' => 'select',	'list' => array( "-", "London", "Barcelona")),
		array('name' => 'type',		'title' => 'Type',	'type' => 'select',	'list' => array( "-", "Partner", "Client", "Lead")),
		array('name' => 'email',	'type' => 'email',	'title' => 'Email'),
		array('name' => 'phone',	'type' => 'tel',	'title' => 'Phone Number'),
		array('name' => 'company',	'type' => 'search',	'title' => 'Company'),
		array('name' => 'address',	'type' => 'search',	'title' => 'Address'),
	),
);


// Users
$users = array(

	// TEST_
	array(
		'name' => 'Tester',
		'pass' => 'test',
		'level' => 'rsdc',
		'dbprefix' => 'test_',
		'sitename' => 'CRMx Example'
	),

);

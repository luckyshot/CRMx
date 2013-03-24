<?php

option('base_uri', '/'); # '/' or same as the RewriteBase in your .htaccess

date_default_timezone_set('Europe/London');

define("SITE_NAME", "CRMx");
define("SITE_VERSION", "0.1.2a");

define("MYSQL_SERVER", "localhost");
define("MYSQL_USER", "user");
define("MYSQL_PASS", "pass");
define("MYSQL_DATABASE", "database");

$form = array(
	// Type can be: text, select, color, date, datetime, datetime-local, email, month, number, range, search, tel, time, url and week
	'x_' => array( // table prefix
		// name (default)
		// title (default)
		array(
			'name' => 'group',
			'title' => 'Group',
			'type' => 'select',
			'list' => array( "-", "Provider", "Client" ),
			'searchable' => 1,
		),
		array(
			'name' => 'company',
			'title' => 'Company',
		),
		array(
			'name' => 'email',
			'type' => 'email',
			'title' => 'Email',
		),
		array(
			'name' => 'phone',
			'type' => 'tel',
			'title' => 'Phone Number',
		),
	),
);

$users = array(
	array(
		'name' => 'Admin',
		'pass' => 'put_long_password_here',
		'level' => 'rsdc',
		'dbprefix' => 'x_',
		'sitename' => 'Welcome!'
	),
);

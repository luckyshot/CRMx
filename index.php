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

																	  by Xavi Esteve

*/
error_reporting(E_NONE);

require_once('limonade/limonade.php');
require_once('limonade/limonade/lemons/lemon_mysql.php');


/********************************************************
 * CONFIG
 *******************************************************/

option('debug', false);

require_once('config.php');




$c = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);



function get_vars() {
	global $form;

	if (isset($_SESSION['sitename'])) {
		set('sitename', $_SESSION['sitename'].' - CRMx');
	}else{
		set('sitename', SITE_NAME);
	}

	set('username', $_SESSION['name']);
	set('form', json_encode($form[$_SESSION['dbprefix']]));
}



/********************************************************
 * ROUTERS
 *******************************************************/

dispatch('/', 'home');
dispatch('/login/:pass', 'login');
dispatch('/logout', 'logout');
dispatch('/search/:q', 'search');
dispatch('/get/:detail', 'get');


dispatch_post('/save', 'save');
dispatch_post('/comment', 'comment');
dispatch_delete('/delete/:id', 'delete');



/********************************************************
 * MODELS
 *******************************************************/


function is_logged_in() {
	if (!isset($_SESSION['name']) OR strlen($_SESSION['name'])<1) {
		$array = array(
			'status' => 'error',
			'message' => 'Please authenticate first',
			// Uncomment the following line to generate random passwords ready to use (see README)
			//'samplepass' => generateRandomString(100),
		);
		echo json_encode($array);
		die();
	}
	return true;
}





// Gives a list of recent people
function recent() {
	if (!isset($_SESSION['level']) OR strpos($_SESSION['level'], 'r')===-1) {
		$response = array('status'=>'error','message'=>"Your user cannot read contacts");
	}else{
		global $c;
		$people = db("SELECT * FROM ".$_SESSION['dbprefix']."people ORDER BY updated DESC", $c);
		foreach ($people as &$person) {
			$person['form'] = json_decode($person['form'], true);
			$person['comments'] = json_decode($person['comments'], true);
		}
	}

	if ($people) {
		$response = json_encode($people);
	}else{
		$response = array('status'=>'error','message'=>'No results');
	}
	return $response;
}








function search($s='') {
	if (!isset($_SESSION['level']) OR strpos($_SESSION['level'], 'r')===-1) {
		$response = array('status'=>'error','message'=>"Your user cannot search contacts");
	}else{
		global $c;

		/*--- Multiword ---*/
		$w = explode(' ', $s);
		foreach ($w as &$wi) {
			$wi = "(name LIKE  '%".$c->real_escape_string($wi)."%' OR form LIKE  '%".$c->real_escape_string($wi)."%') ";
		}
		$q = "SELECT id, name, form
FROM ".$_SESSION['dbprefix']."people WHERE ". implode(' AND ', $w) ." ORDER BY updated DESC LIMIT 0, 50";

		$people = db($q, $c);

		foreach($people as &$person) {
			$person['form'] = json_decode($person['form'], true);
		}

		if ($people) {
			return json($people);
		}else{
			if ($q) {
				return json(array('status'=>'error','message'=>'No results'));
			}
		}
	}
}








function home() {
	is_logged_in();
	get_vars();
	set('people', recent());
	return html('home.html.php');
}








function login($pass) {
	global $users;

	foreach ($users as $key => $user) {
		if ($pass==$user['pass']) {
			$_SESSION['name'] = $user['name'];
			$_SESSION['level'] = $user['level'];
			$_SESSION['dbprefix'] = $user['dbprefix'];
			if (isset($user['sitename'])) {
				$_SESSION['sitename'] = $user['sitename'];
			}
			$_SESSION['id'] = $key;
			break;
		}
	}
	header("Location: ".url_for('/'));
}







function logout() {
	session_destroy();
	header("Location: ".url_for(''));
	die();
}










function save() {
	// Check if user has enough level to Save
	if (!isset($_SESSION['level']) OR strpos($_SESSION['level'], 's')===-1) {
		$response = array('status'=>'error','message'=>'Your user cannot save');

	// User can Save
	}else if (!isset($_POST['name']) OR $_POST['name']=='') {
		$response = array('status'=>'error','message'=>'Please write a name for the contact');
	}else{

		global $form, $c;
		$array = array(
			'title' => $_POST['title']
		);

		foreach ($form[$_SESSION['dbprefix']] as $field) {
			$array[$field['name']] = $_POST[$field['name']];
		}

		if ($_POST['id']) { // update details
			$q = "UPDATE ".$_SESSION['dbprefix']."people SET 
				form = '".$c->real_escape_string(json_encode($array))."',
				name =  '".$c->real_escape_string($_POST['name'])."',
				`updated` =  '".time()."' WHERE  id = ".($_POST['id']).";";
		}else{ // create new
			$q = "INSERT INTO ".$_SESSION['dbprefix']."people VALUES (
				NULL, 
				'".$c->real_escape_string($_POST['name'])."', 
				'".$c->real_escape_string(json_encode($array))."',  
				'{}',
				'".time()."',  
				'".time()."' 
			);";
		}

		$result = db($q, $c);

		if ($result) {
			if ($_POST['id']) {
				$response = array('status'=>'success','message'=>'Contact details saved');
			}else{
				// Get the ID
				$q = "SELECT id from ".$_SESSION['dbprefix']."people ORDER BY id DESC LIMIT 1";
				$id = db($q, $c);
				$response = array('id'=>$id[0]['id'],'status'=>'success','message'=>'New contact created');
			}
		}else{
			$response = array('status'=>'error','message'=>'Could not save contact details');
		}
	}
	return json($response);
}









function comment($id) {
	// Check if user has enough level to Comment
	if (!isset($_SESSION['level']) OR strpos($_SESSION['level'], 'c')===-1) {
		json(array('status'=>'error','message'=>'Your user cannot comment'));
	}else if (!isset($_POST['comment']) OR $_POST['comment']=='') {
		json(array('status'=>'error','message'=>'Please write a comment first'));
	}else{
		global $c;
		$comments = db("SELECT comments FROM ".$_SESSION['dbprefix']."people WHERE id = ".$c->real_escape_string($_POST['id'])."", $c);
		$comments = json_decode($comments[0]['comments'], true);

		array_unshift($comments, array(
			'user' => $_SESSION['name'],
			'date' => date('c', time()), // iso 8601 format
			'text' => $_POST['comment']
		));
		$q = "UPDATE ".$_SESSION['dbprefix']."people SET comments = '".$c->real_escape_string(json_encode($comments))."' WHERE id = ".$c->real_escape_string($_POST['id'])."";
		$result = db($q, $c);

		if ($result) {
			return json($comments);
		}else{
			return json(array('status'=>'error','message'=>'Could not add comment'));
		}
	}
}








function delete($id) {
	if (!isset($_SESSION['level']) OR strpos($_SESSION['level'], 'd')===-1) {
		$response = array('status'=>'error','message'=>"Your user cannot delete");
	}else{
		global $c;
		$deletion = db("DELETE FROM ".$_SESSION['dbprefix']."people WHERE id = ".$c->real_escape_string($id)."", $c);

		if ($deletion) {
			$response = array('status'=>'success','message'=>'Contact deleted');
		}else{
			$response = array('status'=>'error','message'=>'Contact could not be deleted');
		}
	}
	return json($response);
}







function get($detail) {
	if (!isset($_SESSION['level']) OR strpos($_SESSION['level'], 'r')===-1) {
		$response = array('status'=>'error','message'=>"Your user cannot read");
	}else{
		global $c;
		if (is_numeric($detail)) {
			$people = db("SELECT * FROM ".$_SESSION['dbprefix']."people WHERE id = ".$c->real_escape_string($detail)." LIMIT 1", $c);
		}else{
			$people = db("SELECT * FROM ".$_SESSION['dbprefix']."people WHERE name LIKE '%".$c->real_escape_string($detail)."%' OR form LIKE '%".$c->real_escape_string($detail)."%' ORDER BY updated DESC LIMIT 1", $c);
		}
		if ($people) {
			$people = $people[0];
			$people['form'] = json_decode($people['form'], true); // decode to later encode but no other way :( 
			$people['comments'] = json_decode($people['comments'], true); // decode to later encode but no other way :( 
		}else{
			$person = array('status'=>'error','message'=>'Your user cannot save');
		}
			$response = json($people);
	}
	return $response;
}







/********************************************************
 * HELPERS
 *******************************************************/
function generateRandomString($length = 100) {
	$characters = '-_!$0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}









// Let the party begin!
run();

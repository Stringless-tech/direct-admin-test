<?php
require '../init.php';
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
$a = explode('/',$request_uri);
array_shift($a);
switch ($a[0]) {
    	case 'home':
	case 'index.php':
		header('Location: /'); die();
	case '':
		return require '../templates/home.tpl';
	case 'users':
		switch($a[1]){
			case 'index':
				return require '../templates/index-users.tpl';
			case 'create':
				return require '../templates/add-users.tpl';
			case 'edit':
				return require '../templates/edit-users.tpl';
			case 'remove':
				return require '../templates/remove-users.tpl';
			default:
				break;
		}
    	default:
        		break;
}
return require '../templates/404.php';

<?php
session_start();


use controller\Users as UserController;


spl_autoload_register(function ($class) {
	if (str_contains($class, '.')) { // Avoid use of '../' in class name
		return;
	}
	$clean_class = trim(str_replace('\\', '/', $class), '/');

    $class_name = explode('/', $clean_class);
    $class_name = $class_name[count($class_name) - 1];
    $first_char = substr($class_name, 0, 1);

    $class = $clean_class . '.class.php';
    $interface = $clean_class . '.interface.php';
    $trait = $clean_class . '.trait.php';

    $path = 'includes/' . $class;
    if (is_file($path)) {
        require_once $path;
        return;
    }
    if ($first_char === 'I') {
        $path = 'includes/' . $interface;
        if (is_file($path)) {
            require_once $path;
            return;
        }
    }
    if ($first_char === 'T') {
        $path = 'includes/' . $trait;
        if (is_file($path)) {
            require_once $path;
            return;
        }
    }
});

use common\Parser;

$parser = new Parser($_GET, $_POST);
$userController = new UserController();

if (!empty($_POST['login']) && !empty($_POST['password'])) {

    $test = $userController->getVerification($_POST['login'], $_POST['password']);
    if ($test) {
        session_start();
        $_SESSION['login'] = $test->getLogin();
        $_SESSION['user_id'] = $test->getUserId();
        $_SESSION['type_id'] = $test->getTypeId();
        //$_SESSION['role'] = $userController->getRole($_SESSION['type_id']);

        echo "<pre>" . print_r($_SESSION, true) . "</pre>";


        echo $parser->getDisplay();
        header("Location:?view=user");

    } else {
        echo "Login ou Password incorrect";
    }
}
echo $parser->getDisplay();

//require_once "includes/header.php";

  /*  echo '
<form name="index" method="POST"  onsubmit= "return validateForm2(\'index\',\'login\', \'password\'); "  >
    Login : <input type="text" name="login" autocomplete="off" onkeypress="verifierCaracteres(event); return false;">
    Password : <input type="password" name="password" autocomplete="off" >
    <input type="submit" name="submit" value="submit">

</form>';

*/
//require_once "includes/footer.php";
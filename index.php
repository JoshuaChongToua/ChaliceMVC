<?php

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

require_once "includes/header.php";

echo $parser->getDisplay();

require_once "includes/footer.php";
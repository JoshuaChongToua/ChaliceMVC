<?php
use common\Parser;

$parser = new Parser($_GET,$_POST);

require_once "includes/header.php";

echo $parser->getDisplay();

require_once "includes/footer.php";
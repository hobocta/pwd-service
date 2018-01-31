<?php

use Hobocta\Pwd\Generator;

require_once '../src/autoload.php';

if (
    empty($_REQUEST['length'])
    || !isset($_REQUEST['number'])
    || !isset($_REQUEST['mark'])
    || !isset($_REQUEST['extra'])
) {
    echo 'Пустой или неполный запрос';
    return;
}

$generator = new Generator;

$pwd = $generator->generate(
    (int)$_REQUEST['length'],
    array(
        'number' => (bool)$_REQUEST['number'],
        'mark' => (bool)$_REQUEST['mark'],
        'extra' => (bool)$_REQUEST['extra'],
    )
);

echo json_encode(array('pwd' => $pwd));

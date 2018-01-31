<?php

use Hobocta\Pwd\Generator;

require_once '../src/autoload.php';

$result = array(
    'error' => false,
    'pwd' => '',
);

if (
    empty($_REQUEST['length'])
    || !isset($_REQUEST['number'])
    || !isset($_REQUEST['mark'])
    || !isset($_REQUEST['extra'])
) {
    $result['error'] = true;
} else {
    $generator = new Generator;

    $result['pwd'] = $generator->generate(
        (int)$_REQUEST['length'],
        array(
            'number' => (bool)$_REQUEST['number'],
            'mark' => (bool)$_REQUEST['mark'],
            'extra' => (bool)$_REQUEST['extra'],
        )
    );
}

echo json_encode($result);

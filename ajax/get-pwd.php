<?php

use Hobocta\Pwd\Generator;
use Hobocta\Pwd\Parameters;

require_once '../src/autoload.php';

$result = array(
    'error' => false,
    'pwd' => '',
);

if (
    empty($_REQUEST['length'])
    || empty($_REQUEST['number'])
    || empty($_REQUEST['mark'])
    || empty($_REQUEST['extra'])
) {
    $result['error'] = true;
} else {
    $generator = new Generator;

    $parameters = new Parameters;
    $parameters
        ->setLength(filter_var($_REQUEST['length'], FILTER_SANITIZE_NUMBER_INT))
        ->setNumber($_REQUEST['number'] === 'true')
        ->setMark($_REQUEST['mark'] === 'true')
        ->setExtra($_REQUEST['extra'] === 'true');

    $result['pwd'] = $generator->generate($parameters);
}

echo json_encode($result);

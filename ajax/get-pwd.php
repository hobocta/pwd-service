<?php

use Hobocta\Pwd\Generator;
use Hobocta\Pwd\Parameters;
use Hobocta\Pwd\Service;

require_once '../src/autoload.php';

header('Content-Type: application/json');

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
    $service = new Service(new Generator);

    $parameters = new Parameters(
        filter_var($_REQUEST['length'], FILTER_SANITIZE_NUMBER_INT),
        $_REQUEST['number'] === 'true',
        $_REQUEST['mark'] === 'true',
        $_REQUEST['extra'] === 'true'
    );

    $result['pwd'] = $service->generate($parameters);
}

echo json_encode($result);

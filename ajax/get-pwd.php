<?php

use Hobocta\Pwd;

require_once '../src/autoload.php';

header('Content-Type: application/json');

$result = array(
    'error' => false,
    'message' => '',
    'pwd' => '',
);

if (
    empty($_REQUEST['length'])
    || empty($_REQUEST['number'])
    || empty($_REQUEST['mark'])
    || empty($_REQUEST['extra'])
) {
    $result['error'] = true;
    $result['message'] = 'Missed required parameters';
} else {
    $service = new Pwd\Service(new Pwd\Generator);

    try {
        $parameters = new Pwd\Parameters(
            filter_var($_REQUEST['length'], FILTER_SANITIZE_NUMBER_INT),
            $_REQUEST['number'] === 'true',
            $_REQUEST['mark'] === 'true',
            $_REQUEST['extra'] === 'true'
        );

        $result['pwd'] = $service->generate($parameters);
    } catch (Pwd\ParametersException $e) {
        $result['error'] = true;
        $result['message'] = $e->getMessage();
    }
}

echo json_encode($result);

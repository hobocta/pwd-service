<?
use Hobocta\Pwd\Pwd;

if (!require_once('pwd/pwd.php')) {
	throw new Exception('Не удалось подгрузить класс');
}

if (
	empty($_REQUEST['length'])
	|| !isset($_REQUEST['number'])
	|| !isset($_REQUEST['mark'])
	|| !isset($_REQUEST['extra'])
) {
	throw new Exception('Пустой или неполный запрос');
}

$pwd = Pwd::get(
	(int) $_REQUEST['length'],
	array(
		'number' => (bool) $_REQUEST['number'],
		'mark'   => (bool) $_REQUEST['mark'],
		'extra'  => (bool) $_REQUEST['extra'],
	)
);

echo json_encode(array('pwd' => $pwd));

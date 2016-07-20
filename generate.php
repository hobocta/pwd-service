<?
use Hobocta\Pwd\Pwd;

if (!require_once('pwd/pwd.php')) {
	throw new Exception('Не удалось подгрузить класс');
}

if (
	empty($_REQUEST['length'])
	|| !isset($_REQUEST['num'])
	|| !isset($_REQUEST['marks'])
	|| !isset($_REQUEST['extra'])
) {
	throw new Exception('Пустой или неполный запрос');
}

echo Pwd::get(
	(int) $_REQUEST['length'],
	array(
		'number' => (bool) $_REQUEST['num'],
		'mark'   => (bool) $_REQUEST['marks'],
		'extra'  => (bool) $_REQUEST['extra'],
	)
);

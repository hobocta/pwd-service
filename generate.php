<?
if (!require_once("class/class.php") ) {
	die("Не удалось подгрузить класс");
}
if (
	empty($_REQUEST['length'])
	|| !isset($_REQUEST['num'])
	|| !isset($_REQUEST['marks'])
	|| !isset($_REQUEST['extra'])
) {
	die("Пустой или неполный запрос");
}
echo Pwd::createAndCheck(
	(int) $_REQUEST['length'],
	(bool) $_REQUEST['num'],
	(bool) $_REQUEST['marks'],
	(bool) $_REQUEST['extra']
);
?>
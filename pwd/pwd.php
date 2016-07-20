<?
namespace Hobocta\Pwd;

/**
 * Генератор паролей
 */

class Pwd
{
	/**
	 * Создаёт и проверяет пароль
	 *
	 * Метод вернёт пароль с длинной $length,
	 * если $checkForNumber == true, то в пароле обязательно будет цифра
	 * если $checkForNumber == false, то в пароле не будет цифр
	 * если $checkForMark == true, то в пароле обязательно будет знак препинания
	 * если $checkForMark == false, то в пароле обязательно не будет знаков препинания
	 * если $checkForExtra == true, то в пароле обязательно будет страшный знак препинания
	 * если $checkForExtra == false, то в пароле обязательно не будет страшных знаков препинания
	 *
	 * @param int $length
	 * @param bool $checkForNumber
	 * @param bool $checkForMark
	 * @param bool $checkForExtra
	 *
	 * @return string
	 */
	public static function get(
		$length = 12,
		$checkForNumber = true,
		$checkForMark = true,
		$checkForExtra = false
	)
	{
		$check = array(
			'number' => $checkForNumber,
			'mark'   => $checkForMark,
			'extra'  => $checkForExtra,
		);

		$symbols = self::getSymbols();

		$symbols['all'] = self::getSymbolsByParams($symbols, $check);

		$pwd = null;

		while (self::isValid($pwd, $check, $symbols)) {
			$pwd = self::generate($length, $symbols);
		}

		return $pwd;
	}

	/**
	 * Возвращает список массивов символов
	 *
	 * @return array
	 */
	private static function getSymbols()
	{
		return array(
			'letters' => array_merge(range('a', 'z'), range('A', 'Z')),
			'numbers' => range(0, 9),
			'marks'   => array('.', ',', '+', '-', '_', '!', '@'),
			'extra'   => array('(', ')', '[', ']', '{', '}', '?', '&', '^', '%', '*', '$', '/', '|', '`', '~'),
		);
	}

	/**
	 * Проверяет наличие выбранных наборов символов
	 *
	 * @param $pwd
	 * @param $symbols
	 * @param $check
	 *
	 * @return array
	 */
	private static function check($pwd, array $symbols, array $check)
	{
		$has = array(
			'number' => false,
			'mark'   => false,
			'extra'  => false,
		);

		if ($check['number']) {
			foreach ($symbols['numbers'] as $char) {
				if (strpos($pwd, (string) $char) !== false) {
					$has['number'] = true;
				}
			}
		}

		if ($check['mark']) {
			foreach ($symbols['marks'] as $char) {
				if (strpos($pwd, $char) !== false) {
					$has['mark'] = true;
				}
			}
		}

		if ($check['extra']) {
			foreach ($symbols['extra'] as $char) {
				if (strpos($pwd, $char) !== false) {
					$has['extra'] = true;
				}
			}
		}

		return $has;
	}

	/**
	 * Возвращает массив всех символов по заданным критериям
	 *
	 * @param array $symbols
	 * @param array $check
	 *
	 * @return array
	 */
	private static function getSymbolsByParams(array $symbols, array $check)
	{
		return array_merge(
			$symbols['letters'],
			$check['number'] ? $symbols['numbers'] : array(),
			$check['mark'] ? $symbols['marks'] : array(),
			$check['extra'] ? $symbols['extra'] : array()
		);
	}

	/**
	 * Проверяет пароль
	 *
	 * @param string $pwd
	 * @param array $check
	 * @param array $symbols
	 *
	 * @return bool
	 */
	private static function isValid($pwd, array $check, array $symbols)
	{
		if (is_null($pwd)) {
			return true;
		}

		$has = self::check($pwd, $symbols, $check);

		return (
			($check['number'] && (is_null($has['number']) || !$has['number']))
			|| ($check['mark'] && (is_null($has['mark']) || !$has['mark']))
			|| ($check['extra'] && (is_null($has['extra']) || !$has['extra']))
		);
	}

	/**
	 * Генерирует рандомный пароль
	 *
	 * @param int $length
	 * @param array $symbols
	 *
	 * @return string
	 */
	private static function generate($length, array $symbols)
	{
		$pwd = null;

		$countAll = count($symbols['all']) - 1;

		$countS = count($symbols['letters']) - 1;

		for ($i = 0; $i < $length; $i++) {
			if ($i == 0 || $i == $length - 1) {
				$pwd .= $symbols['letters'][rand(0, $countS)];
			} else {
				$pwd .= $symbols['all'][rand(0, $countAll)];
			}
		}

		return $pwd;
	}
}

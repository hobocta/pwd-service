<?
/**
 * Класс-генератор пароля
 */
class Pwd
{
	public static $symbols = array(
		'letters' => array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p',
			'r', 's', 't', 'u', 'v', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
			'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z',
		),
		'numbers' => array(
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
		),
		'marks' => array(
			'.', ',', '+', '-', '_', '!', '@',
		),
		'extra' => array(
			'(', ')', '[', ']', '{', '}', '?', '&', '^', '%', '*', '$', '/', '|', '`', '~'
		),
	);

	/**
	 * Метод вернёт пароль с длинной $length,
	 * если $checkForNumbers == true, то в пароле обязательно будет цифра
	 * если $checkForNumbers == false, то в пароле не будет цифр
	 * если $checkForMarks == true, то в пароле обязательно будет знак препинания
	 * если $checkForMarks == false, то в пароле обязательно не будет знаков препинания
	 * если $checkForExtra == true, то в пароле обязательно будет страшный знак препинания
	 * если $checkForExtra == false, то в пароле обязательно не будет страшных знаков препинания
	 *
	 * @param int $length
	 * @param bool $checkForNumbers
	 * @param bool $checkForMarks
	 * @param bool $checkForExtra
	 *
	 * @return string
	 */
	public static function createAndCheck(
		$length = 12,
		$checkForNumbers = true,
		$checkForMarks = true,
		$checkForExtra = false
	)
	{
		$symbols = self::$symbols;
		$symbols['all'] = array_merge(
			$symbols['letters'],
			$checkForNumbers ? $symbols['numbers'] : array(),
			$checkForMarks ? $symbols['marks'] : array(),
			$checkForExtra ? $symbols['extra'] : array()
		);

		$pwd = null;

		while (

			strlen($pwd) == 0

			// есть ли цифры
			|| ($checkForNumbers && (
					!isset($hasNumber)
					|| !$hasNumber
				)
			)

			// есть ли символы
			|| ($checkForMarks && (
					!isset($hasMark)
					|| !$hasMark
				)
			)

			// есть ли страшные символы
			|| ($checkForExtra && (
					!isset($hasExtra)
					|| !$hasExtra
				)
			)

		) {
			$hasNumber = false;
			$hasMark = false;
			$hasExtra = false;
			$pwd = self::createPassword($length, $symbols);
			if ($checkForNumbers) {
				foreach ($symbols['numbers'] as $value) {
					if (strpos($pwd, $value) !== false) {
						$hasNumber = true;
					}
				}
			}
			if ($checkForMarks) {
				foreach ($symbols['marks'] as $value) {
					if (strpos($pwd, $value) !== false) {
						$hasMark = true;
					}
				}
			}
			if ($checkForExtra) {
				foreach ($symbols['extra'] as $value) {
					if (strpos($pwd, $value) !== false) {
						$hasExtra = true;
					}
				}
			}
		}

		return $pwd;
	}

	/**
	 * Метод генерирует пароль
	 *
	 * @param int $length
	 * @param array $symbols
	 *
	 * @return string
	 */
	public static function createPassword($length, $symbols)
	{
		$pwd = null;
		$countAll = count($symbols['all']) - 1;
		$countS = count($symbols['letters']) - 1;
		for ($i = 0; $i < $length; $i++) {
			if ($i == 0) {
				$pwd .= $symbols['letters'][rand(0, $countS)];
			} else if ($i == $length - 1) {
				$pwd .= $symbols['letters'][rand(0, $countS)];
			} else {
				$pwd .= $symbols['all'][rand(0, $countAll)];
			}
		}

		return $pwd;
	}
}

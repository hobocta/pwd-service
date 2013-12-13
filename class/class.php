<?
class Pwd {

	/**
	 * Функция вернёт пароль с длинной $length,
	 * если $checkForNumbers == true, то в пароле обязательно будет цифра
	 * если $checkForNumbers == false, то в пароле не будет цифр
	 * если $checkForMarks == true, то в пароле обязательно будет знак препинания
	 * если $checkForMarks == false, то в пароле обязательно не будет знаков препинания
	 */
	function create_and_check($length, $checkForNumbers, $checkForMarks) {
		$symbols = array();
		$symbols['letters'] = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'x', 'y', 'z',
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z',
		);
		$symbols['numbers'] = array(
			'1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
		);
		$symbols['marks'] = array(
			'.', ',', '-', '!', '(', ')',
			// '[', ']', '?', '&', '^', '%', '@', '*', '$', '<', '>', '/', '|', '+', '{', '}', '`', '~'
		);
		$symbols['all'] = array_merge(
			$symbols['letters'],
			$checkForNumbers ? $symbols['numbers'] : array(),
			$checkForMarks ? $symbols['marks'] : array()
		);

		$pwd = null;

		while (
			strlen($pwd) == 0
			|| ($checkForNumbers && (
					!isset($hasNumber)
					|| !$hasNumber
				)
			) // есть ли цифры
			|| ($checkForMarks && (
					!isset($hasNumber)
					|| !$hasMark
				)
			) // есть ли символы
		) {
			$hasNumber = false;
			$hasMark = false;
			$pwd = self::create_password($length, $symbols);
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
		}
		return $pwd;
	}


	/**
	 * Функция генерирует пароль
	 */
	function create_password($length, $symbols) {
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
?>
<?php

namespace Hobocta\Pwd;

/**
 * Генератор паролей
 *
 * Class Pwd
 * @package Hobocta\Pwd
 */
class Pwd
{
    /**
     * Создаёт и проверяет пароль
     *
     * Если $check['number'] == true, то в пароле обязательно будет цифра
     * Если $check['mark'] == true, то в пароле обязательно будет знак препинания
     * Если $check['extra'] == true, то в пароле обязательно будет страшный знак препинания
     *
     * @param int $length - длина пароля
     * @param array $check
     *
     * @return string
     */
    public static function get(
        $length = 12,
        array $check = array(
            'number' => true,
            'mark' => true,
            'extra' => false,
        )
    )
    {
        $symbols = self::getSymbols($check);

        $pwd = null;

        while (self::isValid($pwd, $check, $symbols)) {
            $pwd = self::generate($length, $symbols);
        }

        return $pwd;
    }

    /**
     * Возвращает список массивов символов
     *
     * @param array $check
     *
     * @return array
     */
    private static function getSymbols(array $check)
    {
        $symbols = array(
            'letter' => array_merge(range('a', 'z'), range('A', 'Z')),
            'number' => range(0, 9),
            'mark' => array('.', ',', '+', '-', '_', '!', '@'),
            'extra' => array('(', ')', '[', ']', '{', '}', '?', '&', '^', '%', '*', '$', '/', '|', '`', '~'),
        );

        $symbols['all'] = self::getSymbolsByParams($symbols, $check);

        return $symbols;
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
        $has = array();

        foreach (array('number', 'mark', 'extra') as $key) {
            $has[$key] = self::checkSymbols($pwd, $symbols, $check, $key);
        }

        return $has;
    }

    /**
     * Проверяет наличие в пароле символа из указанного набора
     *
     * @param $pwd
     * @param array $symbols
     * @param array $check
     * @param $key
     *
     * @return bool
     */
    private static function checkSymbols($pwd, array $symbols, array $check, $key)
    {
        $has = false;

        if ($check[$key]) {
            foreach ($symbols[$key] as $char) {
                if (strpos($pwd, (string)$char) !== false) {
                    $has = true;

                    break;
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
            $symbols['letter'],
            $check['number'] ? $symbols['number'] : array(),
            $check['mark'] ? $symbols['mark'] : array(),
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

        $countS = count($symbols['letter']) - 1;

        for ($i = 0; $i < $length; $i++) {
            if ($i == 0 || $i == $length - 1) {
                $pwd .= $symbols['letter'][rand(0, $countS)];
            } else {
                $pwd .= $symbols['all'][rand(0, $countAll)];
            }
        }

        return $pwd;
    }
}

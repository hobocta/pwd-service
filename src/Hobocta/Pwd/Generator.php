<?php

namespace Hobocta\Pwd;

/**
 * Генератор паролей
 *
 * Class Generator
 * @package Hobocta\Pwd
 */
class Generator
{
    /**
     * Создаёт и проверяет пароль
     *
     * @param Parameters $parameters
     * @return string
     */
    public function generate(Parameters $parameters)
    {
        $symbols = $this->getSymbols($parameters);

        $pwd = null;

        while ($this->isValid($pwd, $parameters, $symbols)) {
            $pwd = $this->generatePwd($parameters->getLength(), $symbols);
        }

        return $pwd;
    }

    /**
     * Возвращает список массивов символов
     *
     * @param Parameters $parameters
     * @return array
     */
    private function getSymbols(Parameters $parameters)
    {
        $symbols = array(
            'letter' => array_merge(range('a', 'z'), range('A', 'Z')),
            'number' => range(0, 9),
            'mark' => array('.', ',', '+', '-', '_', '!', '@'),
            'extra' => array('(', ')', '[', ']', '{', '}', '?', '&', '^', '%', '*', '$', '/', '|', '`', '~'),
        );

        $symbols['all'] = $this->getSymbolsByParams($symbols, $parameters);

        return $symbols;
    }

    /**
     * Проверяет наличие выбранных наборов символов
     *
     * @param string $pwd
     * @param array $symbols
     * @param Parameters $parameters
     * @return array
     */
    private function check($pwd, array $symbols, Parameters $parameters)
    {
        $has = array();

        foreach (array('number', 'mark', 'extra') as $key) {
            $has[$key] = $this->checkSymbols($pwd, $symbols, $parameters, $key);
        }

        return $has;
    }

    /**
     * Проверяет наличие в пароле символа из указанного набора
     *
     * @param string $pwd
     * @param array $symbols
     * @param Parameters $parameters
     * @param $key
     *
     * @return bool
     */
    private function checkSymbols($pwd, array $symbols, Parameters $parameters, $key)
    {
        $has = false;

        if (call_user_func(array($parameters, sprintf('is%s', ucfirst($key))))) {
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
     * @param Parameters $parameters
     * @return array
     */
    private function getSymbolsByParams(array $symbols, Parameters $parameters)
    {
        return array_merge(
            $symbols['letter'],
            $parameters->isNumber() ? $symbols['number'] : array(),
            $parameters->isMark() ? $symbols['mark'] : array(),
            $parameters->isExtra() ? $symbols['extra'] : array()
        );
    }

    /**
     * Проверяет пароль
     *
     * @param string $pwd
     * @param Parameters $parameters
     * @param array $symbols
     * @return bool
     */
    private function isValid($pwd, Parameters $parameters, array $symbols)
    {
        if (is_null($pwd)) {
            return true;
        }

        $has = $this->check($pwd, $symbols, $parameters);

        return (
            ($parameters->isNumber() && (is_null($has['number']) || !$has['number']))
            || ($parameters->isMark() && (is_null($has['mark']) || !$has['mark']))
            || ($parameters->isExtra() && (is_null($has['extra']) || !$has['extra']))
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
    private function generatePwd($length, array $symbols)
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

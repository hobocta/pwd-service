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
     * @var Parameters
     */
    private $parameters;

    /**
     * Создаёт и проверяет пароль
     *
     * @param Parameters $parameters
     * @return string
     */
    public function generate(Parameters $parameters)
    {
        $this->parameters = $parameters;
        unset($parameters);

        $symbols = $this->getSymbols();

        $pwd = null;

        while ($this->isValid($pwd, $symbols)) {
            $pwd = $this->generatePwd($this->parameters->getLength(), $symbols);
        }

        return $pwd;
    }

    /**
     * Возвращает список массивов символов
     *
     * @return array
     */
    private function getSymbols()
    {
        $symbols = array(
            'letter' => array_merge(range('a', 'z'), range('A', 'Z')),
            'number' => range(0, 9),
            'mark' => array('.', ',', '+', '-', '_', '!', '@'),
            'extra' => array('(', ')', '[', ']', '{', '}', '?', '&', '^', '%', '*', '$', '/', '|', '`', '~'),
        );

        $symbols['all'] = $this->getSymbolsByParams($symbols);

        return $symbols;
    }

    /**
     * Проверяет наличие выбранных наборов символов
     *
     * @param string $pwd
     * @param array $symbols
     * @return array
     */
    private function check($pwd, array $symbols)
    {
        $has = array();

        foreach (array('number', 'mark', 'extra') as $key) {
            $has[$key] = $this->checkSymbols($pwd, $symbols, $key);
        }

        return $has;
    }

    /**
     * Проверяет наличие в пароле символа из указанного набора
     *
     * @param string $pwd
     * @param array $symbols
     * @param $key
     *
     * @return bool
     */
    private function checkSymbols($pwd, array $symbols, $key)
    {
        $has = false;

        if (call_user_func(array($this->parameters, sprintf('is%s', ucfirst($key))))) {
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
     * @return array
     */
    private function getSymbolsByParams(array $symbols)
    {
        return array_merge(
            $symbols['letter'],
            $this->parameters->isNumber() ? $symbols['number'] : array(),
            $this->parameters->isMark() ? $symbols['mark'] : array(),
            $this->parameters->isExtra() ? $symbols['extra'] : array()
        );
    }

    /**
     * Проверяет пароль
     *
     * @param string $pwd
     * @param array $symbols
     * @return bool
     */
    private function isValid($pwd, array $symbols)
    {
        if (is_null($pwd)) {
            return true;
        }

        $has = $this->check($pwd, $symbols);

        return (
            ($this->parameters->isNumber() && (is_null($has['number']) || !$has['number']))
            || ($this->parameters->isMark() && (is_null($has['mark']) || !$has['mark']))
            || ($this->parameters->isExtra() && (is_null($has['extra']) || !$has['extra']))
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

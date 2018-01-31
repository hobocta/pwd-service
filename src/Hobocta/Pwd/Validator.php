<?php

namespace Hobocta\Pwd;

/**
 * Class Validator
 * @package Hobocta\Pwd
 */
class Validator
{
    /**
     * @var Parameters
     */
    private $parameters;

    /**
     * @var array
     */
    private $symbolSet;

    /**
     * Validator constructor.
     * @param Parameters $parameters
     * @param array $symbolSet
     */
    public function __construct(Parameters $parameters, array $symbolSet)
    {
        $this->parameters = $parameters;
        $this->symbolSet = $symbolSet;
    }

    /**
     * Проверяет пароль
     *
     * @param string $pwd
     * @return bool
     */
    public function validate($pwd)
    {
        if (is_null($pwd)) {
            return true;
        }

        $has = $this->check($pwd);

        return (
            ($this->parameters->isNumber() && (is_null($has['number']) || !$has['number']))
            || ($this->parameters->isMark() && (is_null($has['mark']) || !$has['mark']))
            || ($this->parameters->isExtra() && (is_null($has['extra']) || !$has['extra']))
        );
    }

    /**
     * Проверяет наличие выбранных наборов символов
     *
     * @param string $pwd
     * @return array
     */
    private function check($pwd)
    {
        $has = array();

        foreach (array('number', 'mark', 'extra') as $key) {
            $has[$key] = $this->checkSymbols($pwd, $key);
        }

        return $has;
    }

    /**
     * Проверяет наличие в пароле символа из указанного набора
     *
     * @param string $pwd
     * @param $key
     *
     * @return bool
     */
    private function checkSymbols($pwd, $key)
    {
        $has = false;

        if (call_user_func(array($this->parameters, sprintf('is%s', ucfirst($key))))) {
            foreach ($this->symbolSet[$key] as $char) {
                if (strpos($pwd, (string)$char) !== false) {
                    $has = true;

                    break;
                }
            }
        }

        return $has;
    }
}

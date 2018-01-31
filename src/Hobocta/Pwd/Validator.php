<?php

namespace Hobocta\Pwd;

/**
 * Валидатор пароля
 *
 * Class Validator
 * @package Hobocta\Pwd
 */
class Validator
{
    /**
     * @var ParametersInterface
     */
    private $parameters;

    /**
     * @var SymbolsInterface
     */
    private $symbols;

    /**
     * Validator constructor.
     * @param ParametersInterface $parameters
     * @param SymbolsInterface $symbols
     */
    public function __construct(ParametersInterface $parameters, SymbolsInterface $symbols)
    {
        $this->parameters = $parameters;
        $this->symbols = $symbols;
    }

    /**
     * Проверяет пароль
     *
     * @param string $pwd
     * @return bool
     */
    public function isNotValid($pwd)
    {
        if (is_null($pwd)) {
            return true;
        }

        $has = $this->check($pwd);

        return (
            ($this->parameters->isNumber() && !$has['number'])
            || ($this->parameters->isMark() && !$has['mark'])
            || ($this->parameters->isExtra() && !$has['extra'])
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
        $has = array(
            'number' => $this->parameters->isNumber() && $this->checkSymbols($pwd, $this->symbols->getNumber()),
            'mark' => $this->parameters->isMark() && $this->checkSymbols($pwd, $this->symbols->getMark()),
            'extra' => $this->parameters->isExtra() && $this->checkSymbols($pwd, $this->symbols->getExtra()),
        );

        return $has;
    }

    /**
     * Проверяет наличие в пароле символа из указанного набора
     *
     * @param string $pwd
     * @param array $symbols
     * @return bool
     */
    private function checkSymbols($pwd, array $symbols)
    {
        $has = false;

        foreach ($symbols as $char) {
            if (strpos($pwd, $char) !== false) {
                $has = true;

                break;
            }
        }

        return $has;
    }
}

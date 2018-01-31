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
        $has = array();

        foreach (
            array(
                'number' => array(
                    'is' => $this->parameters->isNumber(),
                    'symbols' => $this->symbols->getNumber(),
                ),
                'mark' => array(
                    'is' => $this->parameters->isMark(),
                    'symbols' => $this->symbols->getMark(),
                ),
                'extra' => array(
                    'is' => $this->parameters->isExtra(),
                    'symbols' => $this->symbols->getExtra(),
                ),
            ) as $key => $item
        ) {
            $has[$key] = $item['is'] && $this->checkSymbols($pwd, $item['symbols']);
        }

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

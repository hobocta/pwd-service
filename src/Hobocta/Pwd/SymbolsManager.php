<?php

namespace Hobocta\Pwd;

/**
 * Класс для получения наборов символов для генерации пароля в зависимости от настроек
 *
 * Class SymbolsManager
 * @package Hobocta\Pwd
 */
class SymbolsManager
{
    /**
     * @var ParametersInterface
     */
    private $parameters;

    /**
     * SymbolsManager constructor.
     * @param ParametersInterface $parameters
     */
    public function __construct(ParametersInterface $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Возвращает список массивов символов
     *
     * @return SymbolsInterface
     */
    public function getSymbols()
    {
        $symbols = new Symbols;

        $symbols->setAll(
            array_merge(
                $symbols->getLetter(),
                $this->parameters->isNumber() ? $symbols->getNumber() : array(),
                $this->parameters->isMark() ? $symbols->getMark() : array(),
                $this->parameters->isExtra() ? $symbols->getExtra() : array()
            )
        );

        return $symbols;
    }
}

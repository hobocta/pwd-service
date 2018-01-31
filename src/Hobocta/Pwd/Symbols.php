<?php

namespace Hobocta\Pwd;


class Symbols
{
    /**
     * @var Parameters
     */
    private $parameters;

    /**
     * Symbols constructor.
     * @param Parameters $parameters
     */
    public function __construct(Parameters $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Возвращает список массивов символов
     *
     * @return array
     */
    public function getSymbols()
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
}

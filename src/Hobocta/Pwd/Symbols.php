<?php

namespace Hobocta\Pwd;

/**
 * Class Symbols
 * @package Hobocta\Pwd
 */
class Symbols implements SymbolsInterface
{
    private $letter = array();
    private $number = array();
    private $mark = array();
    private $extra = array();
    private $all = array();

    public function __construct()
    {
        $this->letter = array_merge(range('a', 'z'), range('A', 'Z'));
        $this->number = range(0, 9);
        $this->mark = array('.', ',', '+', '-', '_', '!', '@');
        $this->extra = array('(', ')', '[', ']', '{', '}', '?', '&', '^', '%', '*', '$', '/', '|', '`', '~');
    }

    /**
     * @return array
     */
    public function getLetter()
    {
        return $this->letter;
    }

    /**
     * @return array
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return array
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->all;
    }

    /**
     * @param array $all
     */
    public function setAll(array $all)
    {
        $this->all = $all;
    }
}

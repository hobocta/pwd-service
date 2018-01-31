<?php

namespace Hobocta\Pwd;

/**
 * Interface SymbolsInterface
 * @package Hobocta\Pwd
 */
interface SymbolsInterface
{
    public function getLetter();

    public function getNumber();

    public function getMark();

    public function getExtra();

    public function getAll();

    public function setAll(array $all);
}

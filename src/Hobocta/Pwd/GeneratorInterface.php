<?php

namespace Hobocta\Pwd;

/**
 * Interface GeneratorInterface
 * @package Hobocta\Pwd
 */
interface GeneratorInterface
{
    public function generate($length, SymbolsInterface $symbols);
}

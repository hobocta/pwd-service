<?php

namespace Hobocta\Pwd;

/**
 * Interface ParametersInterface
 * @package Hobocta\Pwd
 */
interface ParametersInterface
{
    public function getLength();

    public function isNumber();

    public function isMark();

    public function isExtra();
}

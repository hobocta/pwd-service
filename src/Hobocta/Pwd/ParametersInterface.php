<?php

namespace Hobocta\Pwd;

/**
 * Interface ParametersInterface
 * @package Hobocta\Pwd
 */
interface ParametersInterface
{
    public function setLength($length);

    public function setNumber($number);

    public function setMark($mark);

    public function setExtra($extra);

    public function getLength();

    public function isNumber();

    public function isMark();

    public function isExtra();
}

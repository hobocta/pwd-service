<?php

namespace Hobocta\Pwd;

/**
 * Параметры пароля
 *
 * Class Parameters
 * @package Hobocta\Pwd
 */
class Parameters implements ParametersInterface
{
    /**
     * Длина пароля
     * @var int
     */
    private $length = 12;

    /**
     * В пароле обязательно должна быть цифра
     * @var bool
     */
    private $number = true;

    /**
     * В пароле обязательно должен быть знак препинания
     * @var bool
     */
    private $mark = true;

    /**
     * В пароле обязательно должен быть страшный знак препинания
     * @var bool
     */
    private $extra = false;

    /**
     * @param int $length
     * @return Parameters
     */
    public function setLength($length)
    {
        $this->length = (int)$length;
        return $this;
    }

    /**
     * @param bool $number
     * @return Parameters
     */
    public function setNumber($number)
    {
        $this->number = (bool)$number;
        return $this;
    }

    /**
     * @param bool $mark
     * @return Parameters
     */
    public function setMark($mark)
    {
        $this->mark = (bool)$mark;
        return $this;
    }

    /**
     * @param bool $extra
     * @return Parameters
     */
    public function setExtra($extra)
    {
        $this->extra = (bool)$extra;
        return $this;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return bool
     */
    public function isNumber()
    {
        return $this->number;
    }

    /**
     * @return bool
     */
    public function isMark()
    {
        return $this->mark;
    }

    /**
     * @return bool
     */
    public function isExtra()
    {
        return $this->extra;
    }
}

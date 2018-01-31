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
    private $length;

    /**
     * В пароле обязательно должна быть цифра
     * @var bool
     */
    private $number;

    /**
     * В пароле обязательно должен быть знак препинания
     * @var bool
     */
    private $mark;

    /**
     * В пароле обязательно должен быть страшный знак препинания
     * @var bool
     */
    private $extra;

    /**
     * Parameters constructor.
     * @param int $length
     * @param bool $number
     * @param bool $mark
     * @param bool $extra
     * @throws \Exception
     */
    public function __construct($length = 12, $number = true, $mark = true, $extra = false)
    {
        $this->length = (int)$length;
        $this->number = (bool)$number;
        $this->mark = (bool)$mark;
        $this->extra = (bool)$extra;

        $minLength = $this->getMinLength();

        if ($this->length < $minLength) {
            throw new ParametersException(
                sprintf('Unable to set length=%s, minLength=%s', $this->length, $minLength)
            );
        }
    }

    /**
     * Определяет минимальную длину пароля
     *
     * @return int
     */
    private function getMinLength()
    {
        return 2 + (int)$this->number + (int)$this->mark + (int)$this->extra;
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

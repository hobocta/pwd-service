<?php

namespace Hobocta\Pwd;

/**
 * Генератор паролей
 *
 * Class Generator
 * @package Hobocta\Pwd
 */
class Generator implements GeneratorInterface
{
    /**
     * Генерирует пароль
     *
     * @param int $length
     * @param array $symbols
     * @return string
     */
    public function generate($length, array $symbols)
    {
        $pwd = null;

        $countAll = count($symbols['all']) - 1;

        $countS = count($symbols['letter']) - 1;

        for ($i = 0; $i < $length; $i++) {
            if ($i == 0 || $i == $length - 1) {
                $pwd .= $symbols['letter'][rand(0, $countS)];
            } else {
                $pwd .= $symbols['all'][rand(0, $countAll)];
            }
        }

        return $pwd;
    }
}

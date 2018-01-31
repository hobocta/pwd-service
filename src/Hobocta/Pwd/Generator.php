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
     * @param SymbolsInterface $symbols
     * @return string
     */
    public function generate($length, SymbolsInterface $symbols)
    {
        $pwd = null;

        $all = $symbols->getAll();
        $letter = $symbols->getLetter();

        $countAll = count($all) - 1;
        $count = count($letter) - 1;

        for ($i = 0; $i < $length; $i++) {
            if ($i == 0 || $i == $length - 1) {
                $pwd .= $letter[mt_rand(0, $count)];
            } else {
                $pwd .= $all[mt_rand(0, $countAll)];
            }
        }

        return $pwd;
    }
}

<?php

namespace Hobocta\Pwd;

/**
 * Сервис генерации паролей
 *
 * Class Service
 * @package Hobocta\Pwd
 */
class Service
{
    /**
     * @var Generator
     */
    private $generator;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * Service constructor.
     * @param Generator $generator
     * @param Validator $validator
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Создаёт и проверяет пароль
     *
     * @param Parameters $parameters
     * @return null
     */
    public function generate(Parameters $parameters)
    {
        $symbols = new Symbols($parameters);

        $symbolSet = $symbols->getSymbols();

        $this->validator = new Validator($parameters, $symbolSet);

        $pwd = null;

        while ($this->validator->validate($pwd)) {
            $pwd = $this->generator->generate($parameters->getLength(), $symbolSet);
        }

        return $pwd;
    }
}

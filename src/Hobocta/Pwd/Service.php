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
     * @var GeneratorInterface
     */
    private $generator;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * Service constructor.
     * @param GeneratorInterface $generator
     */
    public function __construct(GeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Создаёт и проверяет пароль
     *
     * @param ParametersInterface $parameters
     * @return null
     */
    public function generate(ParametersInterface $parameters)
    {
        $symbolsManager = new SymbolsManager($parameters);

        $symbols = $symbolsManager->getSymbols();

        $this->validator = new Validator($parameters, $symbols);

        $pwd = null;

        while ($this->validator->isNotValid($pwd)) {
            $pwd = $this->generator->generate($parameters->getLength(), $symbols);
        }

        return $pwd;
    }
}

<?php

use Hobocta\Pwd;

require_once 'src/autoload.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online генератор паролей</title>
    <?php foreach (['css/styles.css'] as $file): ?>
        <link rel="stylesheet" href="<?= $file ?>?<?= filemtime(__DIR__ . '/' . $file) ?>">
    <?php endforeach; ?>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
</head>
<body>
    <div class="wrap">
        <p class="note">Кликни, чтобы скопировать</p>

        <?php foreach (array(12, 14, 16) as $length): ?>
            <h3><?= $length ?></h3>

            <?php $service = new Pwd\Service(new Pwd\Generator); ?>

            <?php try {
                foreach (
                    array(
                        new Pwd\Parameters($length, true, false, false),
                        new Pwd\Parameters($length, true, true, false),
                        new Pwd\Parameters($length, true, true, true),
                    ) as $parameters
                ): ?>
                    <p>
                        <?php $pwd = $service->generate($parameters); ?>

                        <button
                            data-length="<?= $length ?>"
                            data-number="<?= json_encode($parameters->isNumber()) ?>"
                            data-mark="<?= json_encode($parameters->isMark()) ?>"
                            data-extra="<?= json_encode($parameters->isExtra()) ?>"
                            class="pwd js-clipboard"><?= $pwd ?></button>
                    </p>
                <?php endforeach;
            } catch (Pwd\ParametersException $e) {
                die(sprintf('Exception message: %s (%s:%s)', $e->getMessage(), $e->getFile(), $e->getLine()));
            } ?>
        <?php endforeach; ?>
    </div>

    <script src="dist/app.js"></script>

    <?php $include = 'more/include.php'; ?>
    <?php if (file_exists($include)): ?>
        <?php
        /** @noinspection PhpIncludeInspection */
        include $include;
        ?>
    <?php endif; ?>
</body>
</html>

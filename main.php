<?php

use Hobocta\Pwd;

require_once 'src/autoload.php';

$assetsDir = '/dist';
$assetsFiles = scandir(__DIR__ . $assetsDir);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password generator online</title>
    <?php foreach ($assetsFiles as $file): ?>
        <?php if (!preg_match( '~\.css$~', $file)) continue; ?>
        <link rel="stylesheet" href="<?= $assetsDir . '/' . $file ?>">
    <?php endforeach; ?>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
</head>
<body>
    <div class="wrap">
        <p class="note">Click to copy</p>

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

    <?php foreach (array('dist/app.js') as $file): ?>

    <?php endforeach; ?>
    <?php foreach ($assetsFiles as $file): ?>
        <?php if (!preg_match( '~\.js$~', $file)) continue; ?>
        <script src="<?= $assetsDir . '/' . $file ?>"></script>
    <?php endforeach; ?>
    <?php $include = 'more/include.php'; ?>
    <?php if (file_exists($include)): ?>
        <?php
        /** @noinspection PhpIncludeInspection */
        include $include;
        ?>
    <?php endif; ?>
</body>
</html>

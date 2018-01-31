<?php

use Hobocta\Pwd\Generator;

require_once 'src/autoload.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online генератор паролей</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
</head>
<body>
    <div class="wrap">
        <p class="note">Кликни, чтобы скопировать</p>
        <?php foreach (array(8, 12, 16) as $length): ?>
            <h3><?= $length ?></h3>
            <?php $generator = new Generator; ?>
            <?php foreach (
                array(
                    array('number' => true, 'mark' => false, 'extra' => false),
                    array('number' => true, 'mark' => true, 'extra' => false),
                    array('number' => true, 'mark' => true, 'extra' => true),
                ) as $check): ?>
                <p>
                    <?php $pwd = $generator->generate($length, $check); ?>
                    <span
                        class="pwd js-clipboard"
                        data-length="<?= $length ?>"
                        data-number="<?= (int)$check['number'] ?>"
                        data-mark="<?= (int)$check['mark'] ?>"
                        data-extra="<?= (int)$check['extra'] ?>"><?=$pwd ?></span>
                </p>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>window.jQuery || document.write("<script src='js/vendor/jquery.1.10.1.min.js'><\/script>")</script>
    <script src="js/vendor/modernizr.2.7.1.min.js"></script>
    <script src="js/vendor/jquery-migrate-1.2.1.min.js"></script>
    <script src="js/vendor/jquery.noty.packaged.min.js"></script>
    <script src="js/vendor/clipboard.min.js"></script>
    <script src="js/scripts.js"></script>
    <?php $include = 'more/include.php'; ?>
    <?php if (file_exists($include)): ?>
        <?php
        /** @noinspection PhpIncludeInspection */
        include($include);
        ?>
    <?php endif; ?>
</body>
</html>

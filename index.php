<?php

use Hobocta\Pwd\Generator;

require_once 'src/autoload.php';
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js no-shockwave-flash lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js no-shockwave-flash lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js no-shockwave-flash lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js no-shockwave-flash"> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online генератор паролей</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>
    <div class="wrap">
        <p class="note">Кликни, чтобы скопировать пароль</p>
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
                    <?= sprintf(
                        '<span class="pwd" data-length="%s" data-number="%s" data-mark="%s" data-extra="%s">%s</span>',
                        $length,
                        (int)$check['number'],
                        (int)$check['mark'],
                        (int)$check['extra'],
                        $generator->generate($length, $check)
                    ) ?>
                </p>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>window.jQuery || document.write("<script src='js/vendor/jquery.1.10.1.min.js'><\/script>")</script>
    <script src="js/vendor/modernizr.2.7.1.min.js"></script>
    <script src="js/vendor/jquery-migrate-1.2.1.min.js"></script>
    <script>
        ($.browser.msie && $.browser.version < 9)
        || document.write("<script src='js/vendor/jquery.zclip.1.1.1/jquery.zclip.min.js'><\/script>")
    </script>
    <script src="js/vendor/jquery.noty.packaged.min.js"></script>
    <script src="js/vendor/flash_detect_min.js"></script>
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

<?php

define('QUERY', $_REQUEST['q']);
define('DIR', (isset($_REQUEST['l'])) ? $_REQUEST['l'] . '/' : 'files/');

$articles = array_filter(scandir(DIR), function($a) {
    return preg_match('/' . QUERY . '/ui', file_get_contents(DIR . $a)) && $a[0] != '.';
});

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>
            Поиск <?= QUERY ?>
        </title>
    </head>
    <body>
        <form action="" method="post">
            <input type="text" name="q" value="<?= QUERY ?>">
            <select name="l">
                <option value="files">Файлы 1</option>
                <option value="files2">Файлы 2</option>
            </select>
            <button type="submit">Искать</button>
        </form>
        <?php if(QUERY && $articles) : ?>
            <?php foreach($articles as $article) : ?>
                <section style="margin-bottom: 20px;">
                    <h2><a href="<?= DIR . $article ?>"><?= preg_replace('/\.\w+$/', '', $article) ?></a></h2>
                    <div><?php
                        $content = file_get_contents(DIR . $article);
                        $content = preg_replace('/(' . QUERY . ')/ui', '<strong>$1</strong>', $content);
                        echo $content;
                    ?></div>
                </section>
            <?php endforeach; ?>
        <?php elseif(QUERY) : ?>
            <h1>Ничего не найдено</h1>
        <?php endif; ?>
    </body>
</html>

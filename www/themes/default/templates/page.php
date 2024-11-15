<?php View::render('header', []); ?>

    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title><?= escape($page->meta_title ?: $page->title) ?></title>
        <?php if (!empty($page->meta_description)): ?>
            <meta name="description" content="<?= escape($page->meta_description) ?>">
        <?php endif; ?>
        <!-- Остальные теги -->
    </head>
<body>

    <h1><?= escape($page->title) ?></h1>
    <div>
        <?= $page->content ?>
    </div>

<?php View::render('footer', []); ?>
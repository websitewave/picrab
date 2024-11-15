<?php View::render('header', []); ?>

    <h2><?= $menu ? 'Редактировать меню' : 'Создать новое меню' ?></h2>

    <form method="post" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Название меню</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= escape($menu->name ?? '') ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

<?php View::render('footer', []); ?>
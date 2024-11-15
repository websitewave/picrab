<?php View::render('header', []); ?>

    <h2>Редактировать пользователя</h2>

    <form method="post" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Имя пользователя</label>
            <input type="text" name="username" id="username" class="form-control" value="<?= escape($user->username) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Электронная почта</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= escape($user->email) ?>" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Статус</label>
            <select name="status" id="status" class="form-select">
                <option value="active" <?= $user->status == 'active' ? 'selected' : '' ?>>Активен</option>
                <option value="inactive" <?= $user->status == 'inactive' ? 'selected' : '' ?>>Неактивен</option>
                <option value="banned" <?= $user->status == 'banned' ? 'selected' : '' ?>>Забанен</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Новый пароль (если нужно изменить)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

<?php View::render('footer', []); ?>
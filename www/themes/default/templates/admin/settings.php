<?php View::render('header', []); ?>

    <h2>Настройки сайта</h2>

    <form method="post" action="<?= base_url('admin/settings/update') ?>">
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="logging_enabled" id="logging_enabled" <?= isset($settings['logging_enabled']) && $settings['logging_enabled'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="logging_enabled">
                Включить логирование
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить настройки</button>
    </form>

<?php View::render('footer', []); ?>
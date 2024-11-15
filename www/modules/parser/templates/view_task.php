<?php View::render('header', []); ?>

    <h2>Задача парсинга #<?= $task->id ?></h2>

    <p>Статус: <span id="task-status"><?= escape($task->status) ?></span></p>

    <div id="logs" style="height: 300px; overflow-y: scroll; background-color: #f8f9fa; padding: 10px; border: 1px solid #dee2e6;">
        <!-- Логи будут загружаться здесь -->
    </div>

<?php if ($task->status == 'completed'): ?>
    <a href="<?= base_url('admin/modules/parser/tasks/download/' . $task->id) ?>" class="btn btn-success mt-3">Скачать JSON</a>
<?php endif; ?>

    <script>
        function fetchTaskStatus() {
            fetch('<?= base_url('admin/modules/parser/tasks/status/' . $task->id) ?>')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('task-status').innerText = data.status;
                    const logsDiv = document.getElementById('logs');
                    logsDiv.innerHTML = '';
                    data.logs.forEach(log => {
                        const p = document.createElement('p');
                        p.textContent = '[' + log.created_at + '] ' + log.message;
                        logsDiv.appendChild(p);
                    });
                    if (data.status !== 'completed' && data.status !== 'failed') {
                        setTimeout(fetchTaskStatus, 5000);
                    }
                });
        }
        fetchTaskStatus();
    </script>

<?php View::render('footer', []); ?>
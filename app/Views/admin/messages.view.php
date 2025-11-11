<style>
    .messages-page { max-width: 1200px; margin: 0 auto; }
    .messages-page h2 { margin-bottom: 2rem; }
    .messages-table { width: 100%; border-collapse: collapse; }
    .messages-table th, .messages-table td {
        border: 1px solid #333;
        padding: 12px;
        text-align: left;
    }
    .messages-table th { background-color: #1a1a1a; }
    .message-content { max-width: 400px; }
    .status-new { font-weight: bold; color: #28a745; }
    .action-button {
        border: 1px solid #fff; padding: 5px 10px; font-size: 0.8rem;
        display: inline-block; text-decoration: none;
    }
</style>

<div class="messages-page">
    <h2>Mensagens de Contato</h2>

    <?php if (empty($messages)): ?>
        <p>Nenhuma mensagem recebida ainda.</p>
    <?php else: ?>
        <table class="messages-table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th class="message-content">Mensagem</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?php echo date('d/m/Y H:i', strtotime($message['created_at'])); ?></td>
                        <td><?php echo htmlspecialchars($message['name']); ?></td>
                        <td><a href="mailto:<?php echo htmlspecialchars($message['email']); ?>"><?php echo htmlspecialchars($message['email']); ?></a></td>
                        <td class="message-content"><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                        <td>
                            <?php if (!$message['is_read']): ?>
                                <span class="status-new">Nova</span>
                            <?php else: ?>
                                <span>Lida</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$message['is_read']): ?>
                                <a href="<?php echo base_path('/admin/messages/mark_read/' . $message['id']); ?>" class="action-button">Marcar como lida</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
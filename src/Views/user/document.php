<div class="document-item" data-id="<?= $document['id'] ?>" data-name="<?= htmlspecialchars($document['nombre_reporte']) ?>">
    <div class="document-icon-wrapper">
        <?php echo Icon::get('csv'); ?>
    </div>

    <div class="document-information">
        <span class="document-name">
            <?= htmlspecialchars($document['nombre_reporte']) ?>
        </span>
        <span class="document-created">
            Created: <?= htmlspecialchars($document['fecha_creacion']) ?>
        </span>
    </div>

    <div class="document-actions">
        <button class="menu-trigger" type="button" aria-label="Opciones">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="1"></circle>
                <circle cx="19" cy="12" r="1"></circle>
                <circle cx="5" cy="12" r="1"></circle>
            </svg>
        </button>

        <?php include ROOT_PATH . '/src/views/user/document_menu.php' ?>
    </div>
</div>
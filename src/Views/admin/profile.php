<div class="profile-container">
    <div class="profile-card">

        <div class="profile-header">
            <div class="profile-avatar">
                <?php echo Icon::get('avatar'); ?>
            </div>

            <h1 class="profile-name"><?= htmlspecialchars($user_data['name']) ?></h1>

            <span class="profile-role">
                <?php
                echo ($user_data['role'] == 'Administrador') ? 'Administrator' : 'Scientist';
                ?>
            </span>

            <p style="color: var(--color-gray-text); margin-top: 8px; font-size: 0.95rem;">
                <?= htmlspecialchars($user_data['email']) ?>
            </p>
        </div>

        <hr class="profile-divider">

        <div class="profile-details">

            <div class="detail-item">
                <div class="detail-icon">
                    <?php echo Icon::get('detail'); ?>
                </div>
                <div class="detail-content">
                    <span class="detail-label">Institution</span>
                    <span class="detail-value">
                        <?= htmlspecialchars($user_data['institution'] ?? 'Not specified') ?>
                    </span>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-icon">
                    <?php echo Icon::get('calendar'); ?>
                </div>
                <div class="detail-content">
                    <span class="detail-label">Member since</span>
                    <span class="detail-value">
                        <?php
                        try {
                            $date = new DateTime($user_data['joined_at']);
                            echo $date->format('d F, Y');
                        } catch (Exception $e) {
                            echo htmlspecialchars($user_data['joined_at']);
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once ROOT_PATH . '/src/Controllers/AdminController.php';

$stats = getDashboardStats();
?>

<div class="admin-dashboard">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Summary</h1>
            <p class="dashboard-subtitle">Welcome, Admin. Here is the current system status.</p>
        </div>
        <div class="date-badge">
            <?php echo date('d F, Y'); ?>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon users-bg">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-value"><?php echo $stats['total_users']; ?></span>
                <span class="stat-label">Total Users</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon search-bg">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-value"><?php echo $stats['total_searches']; ?></span>
                <span class="stat-label">Searches Performed</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon new-bg">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-value"><?php echo $stats['new_users_today']; ?></span>
                <span class="stat-label">New Users Today</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon server-bg">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                    <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                    <line x1="6" y1="6" x2="6.01" y2="6"></line>
                    <line x1="6" y1="18" x2="6.01" y2="18"></line>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-value success-text"><?php echo $stats['server_status']; ?></span>
                <span class="stat-label">Server Status</span>
            </div>
        </div>
    </div>

    <div class="dashboard-content-split">
        <div class="chart-section">
            <div class="section-header">
                <h3>Recent Activity</h3>
            </div>
            <div class="chart-container" style="display:flex; justify-content:center; align-items:center; height: 200px; background: #f8fafc; border-radius: 8px;">
                <p style="color: #94a3b8;">Activity chart (Coming soon)</p>
            </div>
        </div>

        <div class="users-section">
            <div class="section-header">
                <h3>Recent Users</h3>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($stats['recent_users'])): ?>
                            <tr>
                                <td colspan="3" style="text-align:center;">No recent users found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($stats['recent_users'] as $user): ?>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-avatar"><?php echo strtoupper(substr($user['nombre_completo'], 0, 1)); ?></div>
                                            <div class="user-details">
                                                <span class="name"><?php echo htmlspecialchars($user['nombre_completo']); ?></span>
                                                <span class="email"><?php echo htmlspecialchars($user['email']); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo ($user['rol'] == 'Administrador') ? 'researcher' : 'student'; ?>">
                                            <?php
                                            echo ($user['rol'] == 'Administrador') ? 'Administrator' : htmlspecialchars($user['rol']);
                                            ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($user['activo']): ?>
                                            <span class="status-dot active"></span> Active
                                        <?php else: ?>
                                            <span class="status-dot inactive"></span> Inactive
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
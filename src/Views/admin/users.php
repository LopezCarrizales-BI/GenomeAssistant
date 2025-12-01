<div class="users-container">

    <div class="users-header">
        <div>
            <h1 class="page-title">User Management</h1>
            <p class="page-subtitle">Manage system access and user roles</p>
        </div>
        <button class="btn-add-user" onclick="openModal('create')">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add New User
        </button>
    </div>

    <div class="filters-bar">
        <div class="search-wrapper">
            <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" class="search-input" placeholder="Search users by name or email...">
        </div>
        <div class="filter-group">
            <select class="filter-select">
                <option>All Roles</option>
            </select>
            <select class="filter-select">
                <option>All Status</option>
            </select>
        </div>
    </div>

    <div class="table-card">
        <table class="users-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Institution</th>
                    <th>Status</th>
                    <th>Joined Date</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($users) && !empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="avatar-circle">
                                        <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                    </div>
                                    <div class="user-text">
                                        <span class="user-name"><?php echo htmlspecialchars($user['name']); ?></span>
                                        <span class="user-email"><?php echo htmlspecialchars($user['email']); ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="role-badge role-<?php echo $user['role']; ?>">
                                    <?php echo ucfirst($user['role']); ?>
                                </span>
                            </td>
                            <td class="text-secondary">
                                <?php echo htmlspecialchars($user['institution'] ?? 'N/A'); ?>
                            </td>
                            <td>
                                <span class="status-indicator status-<?php echo $user['status'] ?? 'active'; ?>">
                                    <span class="dot"></span>
                                    <?php echo ucfirst($user['status'] ?? 'active'); ?>
                                </span>
                            </td>
                            <td class="text-secondary">
                                <?php echo date('M d, Y', strtotime($user['created_at'] ?? 'now')); ?>
                            </td>
                            <td class="actions-cell">
                                <button class="action-btn edit"
                                    title="Edit User"
                                    onclick="openModal('edit', <?php echo htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8'); ?>)">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </button>

                                <button class="action-btn delete"
                                    title="Delete User"
                                    onclick="confirmDelete(<?php echo $user['id']; ?>)">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center; padding:2rem;">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="userModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">New User</h2>
            <button class="close-btn" onclick="closeModal('userModal')">&times;</button>
        </div>

        <form id="userForm" method="POST" action="">
            <input type="hidden" name="user_id" id="userId">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" id="userName" required class="form-input">
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" id="userEmail" required class="form-input">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" id="userRole" class="form-input">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="userStatus" class="form-input">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Institution</label>
                <input type="text" name="institution" id="userInstitution" class="form-input">
            </div>

            <div class="form-group">
                <label id="passwordLabel">Password</label>
                <input type="password" name="password" id="userPassword" class="form-input" placeholder="Enter password">
                <small class="hint" id="passwordHint" style="display:none;">Leave blank to keep current password</small>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('userModal')">Cancel</button>
                <button type="submit" class="btn-save">Save User</button>
            </div>
        </form>
    </div>
</div>

<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal-content small-modal">
        <div class="modal-header">
            <h2>Confirm Deletion</h2>
            <button class="close-btn" onclick="closeModal('deleteModal')">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this user? This action cannot be undone.</p>
        </div>
        <form method="POST" action="<?php echo asset('/admin/users/delete'); ?>">
            <input type="hidden" name="user_id" id="deleteUserId">
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('deleteModal')">Cancel</button>
                <button type="submit" class="btn-delete-confirm">Delete Permanently</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Estilos corregidos */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        width: 90%;
        max-width: 500px;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .small-modal {
        max-width: 400px;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-row {
        display: flex;
        gap: 15px;
    }

    .form-row .form-group {
        flex: 1;
    }

    .form-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        /* Color agregado */
        border-radius: 6px;
        font-size: 14px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        fontWeight: 500;
        fontSize: 14px;
        color: #333;
        /* Color agregado */
    }

    .hint {
        fontSize: 12px;
        color: #666;
        /* Color agregado */
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-cancel {
        background: #f3f4f6;
        /* Color agregado */
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-save {
        background: #2563eb;
        /* Color agregado */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-delete-confirm {
        background: #dc2626;
        /* Color agregado */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
    }
</style>

<script>
    function openModal(mode, data = null) {
        const modal = document.getElementById('userModal');
        const form = document.getElementById('userForm');
        const title = document.getElementById('modalTitle');

        const createUrl = "<?php echo asset('/admin/users/create'); ?>";
        const updateUrl = "<?php echo asset('/admin/users/update'); ?>";

        if (mode === 'create') {
            title.innerText = 'New User';
            form.action = createUrl;
            form.reset();
            document.getElementById('passwordLabel').innerText = 'Password';
            document.getElementById('userPassword').required = true;
            document.getElementById('passwordHint').style.display = 'none';

        } else if (mode === 'edit') {
            title.innerText = 'Edit User';
            form.action = updateUrl;

            document.getElementById('userId').value = data.id;
            document.getElementById('userName').value = data.name;
            document.getElementById('userEmail').value = data.email;
            document.getElementById('userRole').value = data.role;
            document.getElementById('userStatus').value = data.status || 'active';
            document.getElementById('userInstitution').value = data.institution || '';

            document.getElementById('passwordLabel').innerText = 'Change Password';
            document.getElementById('userPassword').value = '';
            document.getElementById('userPassword').required = false;
            document.getElementById('passwordHint').style.display = 'block';
        }

        modal.style.display = 'flex';
    }

    function confirmDelete(id) {
        const modal = document.getElementById('deleteModal');
        document.getElementById('deleteUserId').value = id;
        modal.style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target.className === 'modal-overlay') {
            event.target.style.display = 'none';
        }
    }
</script>
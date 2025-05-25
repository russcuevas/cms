<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside id="leftsidebar" class="sidebar">
    <div class="menu">
        <ul class="list">
            <li class="header" style="font-size: 12px">
                WELCOME <br>
                RUSSEL VINCENT CUEVAS <br>
                ADMINISTRATOR
            </li>
            <li class="<?= ($currentPage == 'index.php') ? 'active' : '' ?>">
                <a href="index.php">
                    <i class="material-icons">home</i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?= ($currentPage == 'manage_admin.php') ? 'active' : '' ?>">
                <a href="manage_admin.php">
                    <i class="material-icons">admin_panel_settings</i>
                    <span>Manage Admin</span>
                </a>
            </li>
            <li class="<?= ($currentPage == 'manage_staff.php') ? 'active' : '' ?>">
                <a href="manage_staff.php">
                    <i class="material-icons">badge</i>
                    <span>Manage Staff</span>
                </a>
            </li>
            <li class="<?= in_array($currentPage, ['all_clients.php', 'vip_clients.php', 'non_vip_clients.php', 'edit_client_information.php', 'view_client_notes.php', 'view_remarks.php', 'add_remarks.php', 'add_customer.php', 'view_client_notes.php']) ? 'active' : '' ?>">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">person</i>
                    <span>Clients</span>
                </a>
                <ul class="ml-menu">
                    <li class="<?= ($currentPage == 'all_clients.php') ? 'active' : '' ?>">
                        <a href="all_clients.php">All Clients</a>
                    </li>
                    <li class="<?= ($currentPage == 'vip_clients.php') ? 'active' : '' ?>">
                        <a href="vip_clients.php">VIP Clients</a>
                    </li>
                    <li class="<?= ($currentPage == 'non_vip_clients.php') ? 'active' : '' ?>">
                        <a href="non_vip_clients.php">Non VIP Clients</a>
                    </li>
                </ul>
            </li>
            <li class="<?= ($currentPage == 'typography.html') ? 'active' : '' ?>">
                <a href="admin_logout.php">
                    <i class="material-icons">logout</i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
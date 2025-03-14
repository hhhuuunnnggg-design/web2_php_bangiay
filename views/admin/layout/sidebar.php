<?php 
require_once __DIR__ . '/../../../core/Auth.php';
$auth = new Auth();
$user = $auth->getCurrentUser();
?>

<div class="nav">
    <?php if ($auth->checkPermission(1, 'view')): ?>
        <a class="nav-link" href="/shoeimportsystem/public/index.php?controller=category&action=index">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
            Quản lý danh mục
        </a>
    <?php endif; ?>

    <?php if ($auth->checkPermission(2, 'view')): ?>
        <a class="nav-link" href="/shoeimportsystem/public/index.php?controller=color&action=index">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-palette"></i></div>
            Quản lý màu sắc
        </a>
    <?php endif; ?>

    <?php if ($auth->checkPermission(3, 'view')): ?>
        <a class="nav-link" href="/shoeimportsystem/public/index.php?controller=size&action=index">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-maximize"></i></div>
            Quản lý kích thước
        </a>
    <?php endif; ?>

    <?php if ($auth->checkPermission(4, 'view')): ?>
        <a class="nav-link" href="/shoeimportsystem/public/index.php?controller=supplier&action=index">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-building"></i></div>
            Quản lý nhà cung cấp
        </a>
    <?php endif; ?>

    <?php if ($auth->checkPermission(5, 'view')): ?>
        <a class="nav-link" href="/shoeimportsystem/public/index.php?controller=employee&action=index">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
            Quản lý nhân viên
        </a>
    <?php endif; ?>

    <?php if ($auth->checkPermission(6, 'view')): ?>
        <a class="nav-link" href="/shoeimportsystem/public/index.php?controller=role&action=index">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-key"></i></div>
            Quản lý quyền
        </a>
        
    <?php endif; ?>



    <?php if ($auth->checkPermission(7, 'view')): ?>
        <a class="nav-link" href="/shoeimportsystem/public/index.php?controller=role_detail&action=index">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-key"></i></div>
            Quản lý chi tiết quyền
        </a>
    <?php endif; ?>

    <?php if ($auth->checkPermission(8, 'view')): ?>
        <a class="nav-link" href="/shoeimportsystem/public/index.php?controller=function&action=index">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-cogs"></i></div>
            Quản lý danh mục chức năng
        </a>
    <?php endif; ?>

    <?php if ($auth->checkPermission(9, 'view')): ?>
        <a class="nav-link" href="/shoeimportsystem/public/index.php?controller=promotion&action=index">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-gift"></i></div>
            Quản lý khuyến mãi
        </a>
    <?php endif; ?>

    <?php if ($auth->checkPermission(10, 'view')): ?>
        <a class="nav-link" href="/shoeimportsystem/public/index.php?controller=product&action=index">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-box"></i></div>
            Quản lý sản phẩm
        </a>
        <a class="nav-link" href="/shoeimportsystem/public/index.php?controller=product_detail&action=index">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-box-open"></i></div>
            Quản lý chi tiết sản phẩm
        </a>
    <?php endif; ?>

    

    

    

    <?php if ($user): ?>
        <a class="nav-link" href="/shoeimportsystem/public/index.php?controller=auth&action=logout">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-sign-out-alt"></i></div>
            Đăng xuất
        </a>
    <?php endif; ?>
</div>

<style>
    .nav-link { text-decoration: none; color: inherit; transition: color 0.3s ease; }
    .nav-link:hover { text-decoration: none; color: #007bff; }
    .sb-nav-link-icon { margin-right: 8px; }
</style>
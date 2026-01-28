<?php

$halaman = $_GET['halaman'] ?? 'beranda';

switch ($halaman) {

    case 'beranda':
        include "page/dashboard.php";
        break;

    case 'controller':
        include "page/controller/index.php";
        break;

    case 'tambah_controller':
        include "page/controller/add.php";
        break;

    case 'edit_controller':
    include "page/controller/edit.php";
        break;

    case 'update_controller':
    include "page/controller/update.php";
        break;

    case 'hapus_controller':
    include "page/controller/delete.php";
        break;

    //User Management
    case 'user':
        include "page/user/index.php";
        break;
    
    case 'tambah_user':
        include "page/user/add.php";
        break;

    case 'edit_user':
        include "page/user/edit.php";
        break;
        
    case 'hapus_user':
        include "page/user/delete.php";
        break;

    case 'profile':
        include "page/user/profile.php";
        break;

    case 'change_password':
        include "page/user/change_password.php";
        break;
    case 'update_profile':
        include "page/user/update_profile.php";
        break;

    case 'logout':
        include "page/logout.php";
        break;

    default:
        include "page/error.php";
        break;
}

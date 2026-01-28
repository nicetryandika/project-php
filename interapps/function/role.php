<?php
function roleCheck($roles = []) {
    if (!in_array($_SESSION['role'], $roles)) {
        echo "ACCESS DENIED";
        exit;
    }
}

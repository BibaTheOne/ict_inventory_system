<?php
session_start();

function is_logged_in()
{
    return isset($_SESSION['admin']);
}

function is_ict()
{
    return $_SESSION['role'] === 'ICT';
}

function is_hod()
{
    return $_SESSION['role'] === 'HOD';
}

function require_role($role)
{
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        header("Location: unauthorized.php");
        exit;
    }
}

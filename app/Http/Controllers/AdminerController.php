<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminerController extends Controller
{
    public function index(Request $request)
    {
        // Suppress minor deprecations for smooth rendering in PHP 8.3+
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $dbPath = str_replace('\\', '/', database_path('database.sqlite'));

        // Pre-configure auto-login and session for SQLite
        $_SESSION['pwds']['sqlite'][''][''] = '';
        $_SESSION['db']['sqlite'][''][''] = $dbPath;

        // If no specific driver/db query params are passed, auto-select our SQLite db
        if (! isset($_GET['sqlite']) && ! isset($_GET['file'])) {
            $_GET['sqlite'] = '';
            $_GET['username'] = '';
            $_GET['db'] = $dbPath;
        }

        if (! function_exists('adminer_object')) {
            function adminer_object()
            {
                class AdminerCustomization extends \Adminer
                {
                    public function name()
                    {
                        return '<span style="color:#6366f1;font-weight:700;">Task Manager</span> <span style="color:#64748b;font-size:12px;">(SQLite DB)</span>';
                    }

                    public function credentials()
                    {
                        return ['', '', ''];
                    }

                    public function database()
                    {
                        return str_replace('\\', '/', database_path('database.sqlite'));
                    }

                    public function login($login, $password)
                    {
                        return true;
                    }

                    public function navigation($missing)
                    {
                        parent::navigation($missing);
                        echo '<div style="margin-top:20px;padding:12px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;line-height:1.6;">';
                        echo '<strong style="color:#334155;display:block;margin-bottom:4px;">SQLite Connected</strong>';
                        echo '<a href="'.url('/tasks').'" style="display:inline-block;color:#6366f1;font-weight:600;text-decoration:none;">&larr; Back to Tasks App</a><br>';
                        echo '<a href="'.url('/').'" style="display:inline-block;color:#64748b;font-size:12px;text-decoration:none;margin-top:4px;">Homepage</a>';
                        echo '</div>';
                    }
                }

                return new AdminerCustomization;
            }
        }

        require_once base_path('resources/adminer/adminer.php');
        exit;
    }
}

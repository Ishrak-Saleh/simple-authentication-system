<?php
namespace app\Controllers;

use app\Core\Controller;
use app\Core\Session;

class DashboardController extends Controller {
    public function index() {
        $user = Session::get('user');
        if (!$user) {
            header('Location: /login');
            exit;
        }
        
        header('Location: /feed');
        exit;
    }
}
<?php
namespace App\Controller;

class WebController extends Controller
{
    public function auth()
    {
        $this->view('auth.php');
    }
    public function default(array $data)
    {
        $this->view('default.php', $data);
    }
}
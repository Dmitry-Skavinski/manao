<?php
namespace App\Controller;

class Controller
{
    protected function json(array $data)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    protected function view(string $name, array $data = [])
    {
        include_once $GLOBALS['basePath'] . '/App/view/' . $name;
    }
}
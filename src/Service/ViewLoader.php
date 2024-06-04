<?php

namespace Service;

class ViewLoader
{
    public function loadView($viewName, $data)
    {
        extract($data);
        require __DIR__ . '/../View/' . $viewName . '.php';
    }
}

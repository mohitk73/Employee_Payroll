<?php
namespace App\Core;

class Controller
{
    public function model($model)
    {
        $modelPath = __DIR__ . "/../Models/{$model}.php";

        if (!file_exists($modelPath)) {
            die("Model '{$model}' not found in Models folder.");
        }

        require_once $modelPath;

        $class = "App\\Models\\{$model}";
        return new $class;
    }


    public function view($view, $data = [], $useLayout = true)
    {
        if (!empty($data)) {
            extract($data);
        }

        $viewFile = __DIR__ . "/../views/{$view}.php";

        if (!file_exists($viewFile)) {
            die("View '{$view}' not found at path: {$viewFile}");
        }

        if ($useLayout) {
            $header = __DIR__ . "/../views/layout/header.php";
            if (file_exists($header)) {
                include $header;
            }
            include $viewFile;
        } else {
            include $viewFile;
        }
    }
    public function render($view, $data = [])
    {
        extract($data);
        ob_start();
        include APPROOT . "/views/" . $view . ".php";
        return ob_get_clean();
    }
}

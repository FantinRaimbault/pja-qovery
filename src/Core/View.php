<?php

namespace App\Core;

class View
{
    private string $htmlMain = "main.php";
    private string $xmlMain = "Sitemap.php";


    private string $controllerName;
    private array $templates;
    private string $view;
    private array $data = [];
    private bool $isTemplatesIncludeView;

    public function __construct($view, $templates = [], $isTemplatesIncludeView = true)
    {
        $this->setControllerName((debug_backtrace(2, 3)[0]['file']));
        $this->setTemplate($templates);
        $this->setView($view);
        $this->isTemplatesIncludeView = $isTemplatesIncludeView;
    }


    public function setTemplate(?array $templates)
    {
        foreach ($templates as $template) {
            if ($template) {
                // first check inside current module folder
                $path = __DIR__ . "/../Modules/Controllers/" . $this->controllerName . "/Views/Templates/" . $template . "_tpl.php";
                if (file_exists($path)) {
                    $this->templates[] = $path;
                } else {
                    // second check in parent module
                    $path = __DIR__ . "/../Modules/Views/Templates/" . $template . "_tpl.php";
                    if (file_exists($path)) {
                        $this->templates[] = $path;
                    } else {
                        die("Le template n'existe pas");
                    }
                }
            } else {
                $this->templates = [];
            }
        }
    }

    public function setView(?string $view)
    {
        if ($view) {
            $path = __DIR__ . "/../Modules/Controllers/" . $this->controllerName . "/Views/" . $view . "_view.php";
            if (file_exists($path)) {
                $this->view = $path;
            } else {
                $path = __DIR__ . "/../Modules/Views/" . $view . "_view.php";
                if (file_exists($path)) {
                    $this->templates[] = $path;
                } else {
                    die("La vue n'existe pas");
                }
                //$this->view = __DIR__ . "/../Modules/Controllers/Auth/Views/404_view.php";
            }
        } else {
            $this->view = "";
        }
    }

    public function setControllerName(string $path)
    {
        $controllerName = explode("/", trim($path, '/'))[5];
        $this->controllerName = $controllerName;
    }

    public function assign($key, $value): void
    {
        $this->data[$key] = $value;
    }


    public function show()
    {
        extract($this->data);
        include $this->htmlMain;
    }

    public function showSitemap()
    {
        extract($this->data);
        include $this->xmlMain;
    }
}

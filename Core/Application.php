<?php


namespace Core;


class Application
{
    const FRONTEND_FOLDER = 'templates';

    public function loadTemplate($templateName, $data = null)
    {
        include self::FRONTEND_FOLDER
            . '/'
            . $templateName
            . '.php';
    }

}
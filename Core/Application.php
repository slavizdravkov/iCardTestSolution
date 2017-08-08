<?php


namespace Core;


class Application
{
    const FRONTEND_FOLDER = 'templates';

    public function loadTemplate($templateName, $templateData = null, $childData = null)
    {
        include self::FRONTEND_FOLDER
            . '/'
            . $templateName
            . '.php';
    }

}
<?php

namespace Joc4enRatlla\Services;

/**
 * Clase para servicios auxiliares en el juego
 */
class Service
{

    /**
     * Carga y muestra una vista.
     * 
     * @param string $view Nombre de la vista
     * @param array $data Datos a pasar a la vista
     */
    public static function loadView($view, $data = [])
    {
        $viewPath = str_replace('.', '/', $view);
        extract($data);

        include  $_SERVER['DOCUMENT_ROOT'] . "/../Views/$viewPath.view.php";
    }
}

<?php

class AjaxStorage
{

    public static function init()
    {
        switch (strtoupper($_REQUEST['action'])) {
            case 'SAVE':
                $content = $_POST['content'];
                self::result(array());
                break;
            case 'LOAD':
                $id = $_POST['id'];
                self::result(array());
                break;
            default:
                self::result(
                    array(
                        "result" => [],
                        "info" => "Acción No Definida"
                    )
                );
        }
    }

    public static function save()
    {
    }

    public static function load()
    {
    }

    public static function result($result = array())
    {
        echo json_encode($result);
    }
}

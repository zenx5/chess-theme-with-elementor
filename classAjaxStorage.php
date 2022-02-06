<?php

class AjaxStorage
{

    public static function init()
    {
        switch (strtoupper($_REQUEST['action'])) {
            case 'SAVE':
                $register = array(
                    "id_board"  => $_POST['id_board'],
                    "move"      => $_POST['move']
                );

                self::result($register);
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

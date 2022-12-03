<?php

function validationData(array $data): array
{

    $error = array();

    foreach ($data as $value) {
        switch ($value[2]) {
            case 'str':
                if (empty($value[0])) {
                    $error[$value[1]] = "Is empty";
                } else {
                    if (!is_string($value[0])) $error[$value[1]] = "Is not string";
                    else if ($value[0] === "true" || $value[0] === "false" || $value[0] === true || $value[0] === false) {
                        $error[$value[1]] = "Is not string";
                    }
                }
                break;

            case 'int':
                if (empty($value[0])) {
                    $error[$value[1]] = "Is empty";
                } else {
                    if (!intval($value[0])) $error[$value[1]] = "Is not number";
                }
                break;

            case 'bool':
                if ($value[0] !== "true" && $value[0] !== "false" && $value[0] !== true && $value[0] !== false) {
                    $error[$value[1]] = "Is not boolean";
                }
                break;

            case 'arr':
                if (empty($value[0])) {
                    $error[$value[1]] = "Is empty";
                } else {
                    if (!is_array($value[0])) {
                        // exit(var_dump($value[1]));
                        $error[$value[1]] = "Is not array";
                    }
                }
                break;

            case 'img':
                if (empty($value[0])) {
                    $error[$value[1]] = "Is empty";
                } else {
                    if ($value[0] != null) {
                        $ext_img = $value[0]->getClientExtension();
                        if (empty($ext_img)) {
                            $error[$value[1]] = "File does not exist";
                        } else if ($ext_img !== "png" && $ext_img !== "jpg" && $ext_img !== "jpeg") {
                            $error[$value[1]] = "File extension not allowed";
                        }
                    } else {
                        $error[$value[1]] = "File is empty";
                    }
                }
                break;

            case 'opt':
                if (!empty($value[0])) {
                    if (validationData([[$value[0], $value[1], $value[3]]])) {
                        $error[$value[1]] = "Is not {$value[3]}";
                    }
                }
                break;

            default:
                $error[$value[1]] = "type is not  defined";
                break;
        }
    }

    return $error;
}
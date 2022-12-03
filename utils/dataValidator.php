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
                    if (!is_numeric($value[0])) $error[$value[1]] = "Is not number";
                }
                break;

            case 'bool':
                if ($value[0] !== "true" && $value[0] !== "false" && $value[0] !== true && $value[0] !== false) {
                    $error[$value[1]] = "Is not boolean";
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
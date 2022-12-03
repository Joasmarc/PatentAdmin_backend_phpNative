<?php
// imports
require_once '../models/Person.model.php';
require_once "../utils/utils.php";
require_once "../utils/dataValidator.php";

// config http
header("Content-type: appiclation/json");
$request_method = $_SERVER['REQUEST_METHOD'];

// responses
if ($request_method === 'GET'){

    if(isset($_GET['request'])){
        switch ($_GET['request']) {

            case 'findAll':

                // execute consult
                $persons = Person::selectAll();

                // prepare and response
                if ($persons){
                    $response = array();
                    foreach ($persons as $value) {
                        $response[] = [
                            'id' => $value['value_id'],
                            'name'=> $value['name'],
                            'last_name'=> $value['last_name'],
                            'sex'=> $value['sex'],
                            'type_id'=> $value['type_id'],
                        ];
                    }
                    http_response_code(200);
                    exit(json_encode(['data' => $response]));
                } else {
                    http_response_code(404);
                    exit(json_encode(['data' => null]));
                }
                
                break;
            
            case 'findId':

                if(isset($_GET['id'])){

                    // execute consult
                    $persons = Person::selectById($_GET['id']);

                    // prepare and response
                    if($persons){
                        $response[] = [
                            'id' => $persons['value_id'],
                            'name'=> $persons['name'],
                            'last_name'=> $persons['last_name'],
                            'sex'=> $persons['sex'],
                            'type_id'=> $persons['type_id'],
                        ];
                        http_response_code(200);
                        exit(json_encode(['data' => $response]));
                    } else {
                        http_response_code(404);
                        exit(json_encode(['data' => null]));
                    }
                } else {
                    http_response_code(400);
                    exit(json_encode(['warning' => 'parameter `id` empty']));
                }
                break;

            case 'delete':
                if(isset($_GET['id'])){

                    // execute and response
                    if(empty($error = Person::deleteById($_GET['id']))){
                        http_response_code(200);
                        exit(json_encode(['data' => true]));
                    } else {
                        http_response_code(400);
                        exit(json_encode(['error' => $error]));
                    }
                    exit(var_dump($result));
                } else {
                    http_response_code(400);
                    exit(json_encode(['warning' => 'parameter `id` empty']));
                }
                break;
            
            default:
                http_response_code(400);
                exit(json_encode(['error' => 'bad request']));
                break;
        }
    }

} else if ($request_method === 'POST'){
    if (isset($_GET['request'])){
        switch ($_GET['request']) {
    
            case 'create':
    
                $request = requestJSON();
                
                // validate request
                $validation = array();
                $validation[] = [$request['id'],        "id",        "str"];
                $validation[] = [$request['type_id'],   "type_id",   "int"];
                $validation[] = [$request['name'],      "name",      "str"];
                $validation[] = [$request['last_name'], "last_name", "str"];
                $validation[] = [$request['sex'],       "sex",       "int"];

                if (!empty($error = validationData($validation))) {
                    exit(json_encode(['error' => $error]));
                }
    
                // prepare for database
                $person_data = [
                    'value_id' => $request['id'],
                    'type_id' => $request['type_id'],
                    'name' => $request['name'],
                    'last_name' => $request['last_name'],
                    'sex' => $request['sex'],
                ];
    
                // execute and response
                if(empty($error = Person::insertPerson($person_data))){
                    http_response_code(200);
                    exit(json_encode(['data' => true]));
                } else {
                    http_response_code(400);
                    exit(json_encode(['error' => $error]));
                }
    
                break;
            
            case 'update':
                $request = requestJSON();

                // validate request
                $validation = array();
                $validation[] = [$request['id'],        "id",        "str"];
                $validation[] = [$request['name'],      "name",      "str"];
                $validation[] = [$request['last_name'], "last_name", "str"];
                $validation[] = [$request['sex'],       "sex",       "int"];

                if (!empty($error = validationData($validation))) {
                    exit(json_encode(['error' => $error]));
                }

                // prepare for database
                $person_data = [
                    'value_id' => $request['id'],
                    'name' => $request['name'],
                    'last_name' => $request['last_name'],
                    'sex' => $request['sex'],
                ];

                // execute and response
                if(empty($error = Person::updatePerson($person_data))){
                    http_response_code(200);
                    exit(json_encode(['data' => true]));
                } else {
                    http_response_code(400);
                    exit(json_encode(['error' => $error]));
                }

                break;
            
            default:
                http_response_code(400);
                exit(json_encode(['error' => 'bad request']));
                break;
        }
    }
}

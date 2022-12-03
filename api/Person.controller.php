<?php
// imports
require_once '../models/Person.model.php';
require_once "../utils/utils.php";

// config http
header("Content-type: appiclation/json");
$request_method = $_SERVER['REQUEST_METHOD'];

// responses
if ($request_method === 'GET'){

    if(isset($_GET['request'])){
        switch ($_GET['request']) {

            case 'findAll':

                $persons = Person::selectAll();

                if ($persons){
                    // prepare
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
                    // execute
                    http_response_code(200);
                    exit(json_encode(['data' => $response]));
                } else {
                    http_response_code(404);
                    exit(json_encode(['data' => null]));
                }
                
                break;
            
            case 'findId':
                if(isset($_GET['id'])){

                    $persons = Person::selectById($_GET['id']);

                    //validate query result
                    if($persons){
                        // prepare
                        $response[] = [
                            'id' => $persons['value_id'],
                            'name'=> $persons['name'],
                            'last_name'=> $persons['last_name'],
                            'sex'=> $persons['sex'],
                            'type_id'=> $persons['type_id'],
                        ];
                        // execute
                        http_response_code(200);
                        exit(json_encode(['data' => $response]));
                    } else {
                        http_response_code(404);
                        exit(json_encode(['data' => null]));
                    }
                } else {
                    http_response_code(400);
                    exit(json_encode(['msg' => 'parameter `id` empty']));
                }
                break;
            
            default:
                http_response_code(400);
                exit(json_encode(['msg' => 'bad request']));
                break;
        }
    }

} else if ($request_method === 'POST'){
    switch ($_GET['request']) {
        case 'create':
            $request = requestJSON();
            //validate

            exit(json_encode(['data' => $request    ]));
            break;
        
        default:
            # code...
            break;
    }
}

// echo json_encode(Person::selectAll());
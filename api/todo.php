<?php
try {
    require_once("todo.controller.php");
    
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = explode( '/', $uri);
    $requestType = $_SERVER['REQUEST_METHOD'];
    $body = file_get_contents('php://input');
    $pathCount = count($path);

    $controller = new TodoController();
    
    switch($requestType) {
        case 'GET':
            if ($path[$pathCount - 2] == 'todo' && isset($path[$pathCount - 1]) && strlen($path[$pathCount - 1])) {
                $id = $path[$pathCount - 1];
                $todo = $controller->load($id);
                if ($todo) {
                    http_response_code(200);
                    die(json_encode($todo));
                }
                http_response_code(404);
                die();
            } else {
                http_response_code(200);
                die(json_encode($controller->loadAll()));
            }
            break;              
        case 'POST':
            //implement your code here
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = array(
                array(
                'id' => 'NgoVlyDhTS',
                'title' => 'Make Bed',
                'description' => 'Use the good linen this time please',
                'done' => true
                ),
                array(
                    'id' => 'skHMaKsqOb',
                    'title' => 'Pack Dishwasher',
                    'description' => '',
                    'done' => false
                ),
                array(
                    'id' => 'YgnovUnGmB',
                    'title' => 'Wash Dishes',
                    'description' => 'Hand wash the Royal Albert tea set',
                    'done' => false
                ),
                );
                if(!empty($_POST['title']) && !empty($_POST['id'])) {// New Data Input
                    $newdata = array(
                    'id' => $_POST['id'],
                    'title' => $_POST['name'],
                    'description' => $_POST['description'],
                    'done' => $_POST['done']
                    );// Add Data
                    $data[] = $newdata;// New Data
                    foreach($data as $d) {
                    $result['todo'][] = array(
                    'id' => $d['id'],
                    'title' => $d['title'],
                    'description' => $d['description'],
                    'done' => $d['done'],
                    );
                    }$result['status'] = 'success';
                    } else {
                    foreach($data as $d) {
                    $result['todo'][] = array(
                    'id' => $d['id'],
                    'title' => $d['title'],
                    'description' => $d['description'],
                    'done' => $d['done'],
                    );
                    }$result['status'] = 'success';}
                    http_response_code(200);
                    echo json_encode($result);


                    
            break;
        case 'PUT':
            //implement your code here
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: PUT");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = array(
                array(
                    'id' => 'NgoVlyDhTS',
                    'title' => 'Make Bed',
                    'description' => 'Use the good linen this time please',
                    'done' => true
                    ),
                    array(
                        'id' => 'skHMaKsqOb',
                        'title' => 'Pack Dishwasher',
                        'description' => '',
                        'done' => false
                    ),
                    array(
                        'id' => 'YgnovUnGmB',
                        'title' => 'Wash Dishes',
                        'description' => 'Hand wash the Royal Albert tea set',
                        'done' => false
                    ),
                );
                $method = $_SERVER['REQUEST_METHOD'];
                if ('PUT' === $method) {
                parse_str(file_get_contents('php://input'), $_PUT);
                }// Function Edit Data
                if(!empty($_PUT['id']) && !empty($_PUT['title']) && !empty($_PUT['description'])) {
                foreach($data as & $value){
                if($value['id'] === $_PUT['id']){
                $value['title'] = $_PUT['title'];
                break; // Stop the loop after we've found the item
                }
                }// New Data
                foreach($data as $d) {
                $result['todo'][] = array(
                'id' => $d['id'],
                'name' => $d['name'],
                'description' => $d['description'],
                );
                }
                $result['status'] = 'success';
                } else {
                foreach($data as $d) {
                $result['todo'][] = array(
                'id' => $d['id'],
                'title' => $d['title'],
                'description' => $d['description'],
                );
                }
                $result['status'] = 'success';
                }
                http_response_code(200);
                echo json_encode($result);
            break;
        case 'DELETE':
            //implement your code here
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: DELETE");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = array(
                array(
                    'id' => 'NgoVlyDhTS',
                    'title' => 'Make Bed',
                    'description' => 'Use the good linen this time please',
                    'done' => true
                    ),
                    array(
                        'id' => 'skHMaKsqOb',
                        'title' => 'Pack Dishwasher',
                        'description' => '',
                        'done' => false
                    ),
                    array(
                        'id' => 'YgnovUnGmB',
                        'title' => 'Wash Dishes',
                        'description' => 'Hand wash the Royal Albert tea set',
                        'done' => false
                    ),
                );
                $method = $_SERVER['REQUEST_METHOD'];
                if ('DELETE' === $method) {
                parse_str(file_get_contents('php://input'), $_DELETE);
                }// Function Edit Data
                if(!empty($_DELETE['id'])) {// New Data
                foreach($data as $d) {
                if($d['id'] != $_DELETE['id']) {
                $result['todo'][] = array(
                'id' => $d['id'],
                'description' => $d['description'],
                );
                }
                }
                $result['status'] = 'success';
                } else {
                foreach($data as $d) {
                $result['todo'][] = array(
                'id' => $d['id'],
                'description' => $d['description'],
                );
                }
                $result['status'] = 'success';
                }
            break;
        default:
            http_response_code(501);
            die();
            break;
    }
} catch(Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    die();
}

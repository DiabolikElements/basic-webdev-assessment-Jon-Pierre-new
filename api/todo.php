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
            header("Access-Control-Allow-Methods: GET");
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
                if(!empty($_GET['search'])) {
                    $key = array_search($_GET['search'], array_column($data, 'title'),true);
                    $id = $data[$key]['id'];
                    $title = $data[$key]['title'];
                    $description = $data[$key]['description'];
                    $done = $data[$key]['done'];
                    $result = array(
                    'id' => $id,
                    'title' => $title,
                    'description' => $description,
                    'done' => $done
                    'status' => 'success'
                    );
                    } else {
                    foreach($data as $d) {
                    $result['todo'][] = array(
                    'id' => $d['id'],
                    'title' => $d['title'],
                    'description' => $d['description'],
                    'done' => $d['done'],
                    );
                    }
                    $result['status'][] = 'success';
                    }
                    http_response_code(200);
                    echo json_encode($result);


            break;
        case 'PUT':
            //implement your code here
            break;
        case 'DELETE':
            //implement your code here
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

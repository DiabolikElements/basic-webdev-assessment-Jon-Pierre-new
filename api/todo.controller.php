<?php
require_once("todo.class.php");

class TodoController {
    private const PATH = __DIR__."/todo.json";
    private array $todos = [];

    public function __construct() {
        $content = file_get_contents(self::PATH);
        if ($content === false) {
            throw new Exception(self::PATH . " does not exist");
        }  
        $dataArray = json_decode($content);
        if (!json_last_error()) {
            foreach($dataArray as $data) {
                if (isset($data->id) && isset($data->title))
                $this->todos[] = new Todo($data->id, $data->title, $data->description, $data->done);
            }
        }
    }

    public function loadAll() : array {
        return $this->todos;
    }

    public function load(string $id) : Todo | bool {
        foreach($this->todos as $todo) {
            if ($todo->id == $id) {
                return $todo;
            }
        }
        return false;
    }

    public function create(Todo $todo) : bool {
        // implement your code here
        if(!empty($newData)){
            $todo['id'] = $id;
            $jsonData = file_get_contents($this->jsonFile); 
            $data = json_decode($jsonData, true);
            $data = !empty($data)?array_filter($data):$data;
            if(!empty($data)){
                array_push($data, $newData);
            }else{
                $data[] = $newData;
            }
            $create= file_put_contents($this->jsonFile, json_encode($data));
            return $create?$id:false;
        }else{

        return false;
    }
}

    public function update(string $id, Todo $todo) : bool {
        // implement your code here
        foreach($this->todos as $todo => $id){
            if($todo['id'] == $id){ 
               $this->todos[$todo][$id] = $value;
            }
         }
         $this->storeData();
        return true;
    }

    public function delete(string $id) : bool {
        // implement your code here
        $todo = Task::findOrFail($id);
        $todo->delete();
        return $this->setSuccessResponse([], 204);
        return true;
    }



    // add any additional functions you need below
}
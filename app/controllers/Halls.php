<?php
require_once "../app/controllers/headers.php";

class Halls extends Controller
{
    public $response;
    public $hallModel;

    public function __construct()
    {
        $this->hallModel = $this->model("Hall");
    }

    public function index()
    {
        $this->response = [];
        $result = $this->hallModel->getHalls();

        if ($result) {
            $this->response += ["Halls" => $result];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Halls not found"];
            http_response_code(404);
            echo json_encode($this->response);
            exit;
        }
    }

    public function createHalls()
    {
        $this->response = [];
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->name) && !empty($data->capacity)) {
            $this->hallModel->name = $data->name;
            $this->hallModel->capacity = $data->capacity;
            $result = $this->hallModel->createHall();
            if ($result) {
                $this->response += ["message" => "Hall created successfully"];
                http_response_code(201);
                echo json_encode($this->response);
                exit;
            } else {
                $this->response += ["message" => "Failed to create hall"];
                http_response_code(503);
                echo json_encode($this->response);
                exit;
            }
        }
    }

    public function deleteHalls($id)
    {
        $this->response = [];
        $result = $this->hallModel->deleteHall($id);

        if ($result) {
            $this->response += ["message" => "Hall deleted successfully"];
            http_response_code(202);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Failed to delete hall"];
            http_response_code(503);
            echo json_encode($this->response);
            exit;
        }
    }

    public function getHallsCount()
    {
        $this->response = [];
        $result = $this->hallModel->getHallsCount();

        if ($result) {
            $this->response += ["Halls" => $result];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Failed to get halls count"];
            http_response_code(503);
            echo json_encode($this->response);
            exit;
        }
    }
}

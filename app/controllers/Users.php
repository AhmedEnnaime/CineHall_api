<?php

class Users extends Controller
{
    public $response;
    public $userModel;

    public function __construct()
    {
        $this->userModel = $this->model("User");
    }

    public function index()
    {
        $this->response = [];
        $result = $this->userModel->getClients();

        if ($result) {
            $this->response += ["Users" => $result];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Users not found"];
            http_response_code(404);
            echo json_encode($this->response);
            exit;
        }
    }
}

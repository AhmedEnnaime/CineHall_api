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

    public function update($id)
    {
        $this->response = [];
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->fname) && !empty($data->lname) && !empty($data->email)) {
            $this->userModel->fname = $data->fname;
            $this->userModel->lname = $data->lname;
            $this->userModel->email = $data->email;

            $result = $this->userModel->update($id);

            if ($result) {
                $this->response += ["message" => "Profile updated successfully"];
                http_response_code(200);
                echo json_encode($this->response);
                exit;
            } else {
                $this->response += ["message" => "Failed to update profile"];
                http_response_code(503);
                echo json_encode($this->response);
                exit;
            }
        }
    }
}

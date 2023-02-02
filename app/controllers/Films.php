<?php
require_once "../app/controllers/headers.php";

class Films extends Controller
{
    public $response;
    public $filmModel;

    public function __construct()
    {
        $this->filmModel = $this->model("Film");
    }

    public function index()
    {
        $this->response = [];
        $result = $this->filmModel->getFilms();

        if ($result) {
            $this->response += ["Films" => $result];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Films not found"];
            http_response_code(404);
            echo json_encode($this->response);
            exit;
        }
    }

    public function addFilms()
    {
        $this->response = [];
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->date) && !empty($data->time)) {
            $this->filmModel->date = $data->date;
            $this->filmModel->time = $data->time;
            $this->filmModel->hall_id = $data->hall_id;
            $this->filmModel->title = $data->title;
            $result = $this->filmModel->addFilm();
            if (!$result) {
                $this->response += ["message" => "Not empty"];
                http_response_code(406);
                echo json_encode($this->response);
                exit;
            } else if ($result) {
                $this->response += ["message" => "Film added successfully"];
                http_response_code(201);
                echo json_encode($this->response);
                exit;
            } else {
                $this->response += ["message" => "Failed to add film"];
                http_response_code(503);
                echo json_encode($this->response);
                exit;
            }
        }
    }

    public function deleteFilms($id)
    {
        $this->response = [];
        $result = $this->filmModel->deleteFilm($id);

        if ($result) {
            $this->response += ["message" => "Film deleted successfully"];
            http_response_code(202);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Failed to delete film"];
            http_response_code(503);
            echo json_encode($this->response);
            exit;
        }
    }

    public function getFilmsCount()
    {
        $this->response = [];
        $result = $this->filmModel->getFilmsCount();

        if ($result) {
            $this->response += ["Films" => $result];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Failed to get films count"];
            http_response_code(503);
            echo json_encode($this->response);
            exit;
        }
    }

    public function getFilmById($id)
    {
        $this->response = [];
        $result = $this->filmModel->getFilmById($id);

        if ($result) {
            $this->response += ["Film" => $result];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Film not found"];
            http_response_code(404);
            echo json_encode($this->response);
            exit;
        }
    }
}

<?php
ini_set('display_errors', 1);
require_once "../app/controllers/headers.php";

class Reservations extends Controller
{

    public $response;
    public $reservationModel;

    public function __construct()
    {
        $this->reservationModel = $this->model("Reservation");
    }

    public function index()
    {
    }

    public function takeReservation()
    {
    }

    public function getReservations()
    {
        $this->response = [];
        $result = $this->reservationModel->getReservations();

        if ($result) {
            $this->response += ["Reservations" => $result];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Reservations not found"];
            http_response_code(404);
            echo json_encode($this->response);
            exit;
        }
    }
}

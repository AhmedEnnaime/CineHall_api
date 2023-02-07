<?php
ini_set('display_errors', 1);
require_once "../app/controllers/headers.php";

class Reservations extends Controller
{

    public $response;
    public $reservationModel;
    public $userModel;

    public function __construct()
    {
        $this->reservationModel = $this->model("Reservation");
        $this->userModel = $this->model("User");
    }

    public function index()
    {
        $this->response = [];
        $result = $this->reservationModel->getAllReservations();

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

    public function takeReservation($film_id)
    {
        $this->response = [];
        $data = json_decode(file_get_contents("php://input"));
        $uniqueKey = strtoupper(substr(sha1(microtime()), rand(0, 5), 20));
        $uniqueKey  = implode("-", str_split($uniqueKey, 5));
        $this->reservationModel->num = $data->num;
        $info = [
            "fname" => $data->fname,
            "lname" => $data->lname,
            "email" => $data->email,
            "key" => $uniqueKey,
            "role" => 1,
        ];
        $result = $this->reservationModel->add($info, $film_id);

        if ($result) {
            $to = $data->email;
            $subject = "Authentication key";
            $headers = "From: CineHall@gmail.com";
            mail($to, $subject, $uniqueKey, $headers);
            $this->response += ["message" => "Reservation taken successfully"];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Seat already taken"];
            http_response_code(404);
            echo json_encode($this->response);
            exit;
        }
    }

    public function getReservationsCount()
    {
        $this->response = [];
        $result = $this->reservationModel->getReservationsCount();

        if ($result) {
            $this->response += ["Reservations" => $result];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Failed to get reservations count"];
            http_response_code(503);
            echo json_encode($this->response);
            exit;
        }
    }

    public function getReservationById($id)
    {
        $this->response = [];
        $result = $this->reservationModel->getReservationById($id);
        if ($result) {
            $this->response += ["Reservation" => $result];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Reservation not found"];
            http_response_code(404);
            echo json_encode($this->response);
            exit;
        }
    }

    public function cancelReservation($id)
    {
        $this->response = [];
        $result = $this->reservationModel->deleteReservation($id);
        if ($result) {
            $this->response += ["message" => "Reservation deleted successfully"];
            http_response_code(202);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Reservation not found"];
            http_response_code(404);
            echo json_encode($this->response);
            exit;
        }
    }
}

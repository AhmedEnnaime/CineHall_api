<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Content-Type: application/json");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, UPDATE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Credentials, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

require_once "../app/generate_jwt.php";
require_once 'vendor/autoload.php';

class Authenticate extends Controller
{

    private $userId;
    public $jwt;
    public $token;
    public $userModel;
    public $response;

    public function __construct()
    {
        $this->userModel = $this->model("User");
    }

    public function index()
    {
        $data = json_decode(file_get_contents("php://input"));
        if ($data) {
            if ($this->login()) {
                if ($this->token) {
                    // setCookie($name="token", $value=$this->token, $httponly=true);
                    $cookie = setcookie("jwt", $this->token, 0, '/', '', false, true);
                    //die(print_r($_COOKIE["jwt"]));
                    // header("Set-Cookie: samesite-test=1; expires=0; path=/; samesite=Strict");
                    if ($cookie) {
                        echo json_encode(["message" => "Access allowed", "userID" => $this->userId, "token" => $this->token, "cookie state" => $cookie]);
                    } else {
                        echo json_encode(["message" => "Failed to set cookie"]);
                    }
                }
            } else {
                echo json_encode(["message" => "Invalid credentials"]);
            }
        } else {
            echo json_encode("Failed to receive login credentials");
        }
    }


    public function login()
    {
        $this->response = [];
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->email) && !empty($data->password) && empty($data->reservation_key)) {
            $this->userModel->email = $data->email;
            $this->userModel->password = $data->password;
            $loggedInAdmin = $this->userModel->login();
            if ($loggedInAdmin) {
                $this->userId = $loggedInAdmin->id;
                if (isset($_COOKIE["jwt"])) {
                    $this->response += ["message" => "Already signed in"];
                    echo json_encode($this->response);
                    exit;
                }
                $this->jwt = new JWTGenerate();
                $this->token = $this->jwt->generate($loggedInAdmin->id);
                return true;
            } else {
                return false;
            }
        } else {
            $this->userModel->reservation_key = $data->reservation_key;
            $loggedInUser = $this->userModel->userLogin();
            if ($loggedInUser) {
                $this->response += ["message" => "Login successful", "logged user" => $loggedInUser];
                echo json_encode($this->response);
                exit;
            }
        }
    }


    public function validate_jwt()
    {
        $this->response = [];
        if (JWTGenerate::validate()) {
            $this->response += ["message" => "Successfully authenticated"];
            echo json_encode($this->response);
            return true;
        } else {
            $this->response += ["message" => "Failed authentication"];
            echo json_encode($this->response);
            return false;
        }
    }

    public function logout()
    {
        if (isset($_COOKIE["jwt"])) {
            setcookie("jwt", $this->token, time() - 3600, '/', '', false, true);
            unset($_COOKIE["jwt"]);
            unset($_COOKIE);
            echo json_encode("logged out successfully");
            exit;
        } else {
            echo json_encode("Failed to logout");
            exit;
        }
    }
}

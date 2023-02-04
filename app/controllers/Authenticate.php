<?php

require_once "../app/controllers/headers.php";

require_once "../app/generate_jwt.php";
require_once 'vendor/autoload.php';

class Authenticate extends Controller
{

    private $userKey;
    private $adminId;
    public $jwt;
    public $token;
    public $key;
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
                    $cookie = setcookie("jwt", $this->token, 0, '/', '', false, true);
                    //die(print_r($_COOKIE["jwt"]));
                    if ($cookie) {
                        echo json_encode(["message" => "Access allowed", "token" => $this->token, "adminId" => $this->adminId, "cookie state" => $cookie]);
                    } else {
                        echo json_encode(["message" => "Failed to set cookie"]);
                    }
                } else if ($this->key) {
                    $cookie = setcookie("key", $this->key, 0, '/', '', false, true);

                    if ($cookie) {
                        echo json_encode(["message" => "Access allowed", "userKey" => $this->key, "cookie state" => $cookie]);
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

        if (isset($data->email) && isset($data->password)) {
            $this->userModel->email = $data->email;
            $this->userModel->password = $data->password;
            $loggedInAdmin = $this->userModel->login();
            if ($loggedInAdmin) {
                $this->adminId = $loggedInAdmin->id;
                if (isset($_COOKIE["jwt"]) || isset($_COOKIE["key"])) {
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
            $this->userModel->key = $data->key;
            $loggedInUser = $this->userModel->userLogin();
            if ($loggedInUser) {
                $this->userKey = $loggedInUser->key;
                if (isset($_COOKIE["key"]) || isset($_COOKIE["jwt"])) {
                    $this->response += ["message" => "Already signed in"];
                    echo json_encode($this->response);
                    exit;
                }
                $this->jwt = new JWTGenerate();
                $this->key = $this->jwt->generate($loggedInUser->key);
                return true;
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
        if (isset($_COOKIE["jwt"]) || isset($_COOKIE["key"])) {
            setcookie("jwt", $this->token, time() - 3600, '/', '', false, true);
            setcookie("key", $this->token, time() - 3600, '/', '', false, true);
            unset($_COOKIE["jwt"]);
            unset($_COOKIE["key"]);
            unset($_COOKIE);
            echo json_encode("logged out successfully");
            exit;
        } else {
            echo json_encode("Failed to logout");
            exit;
        }
    }
}

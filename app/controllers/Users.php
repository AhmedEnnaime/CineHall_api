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
    }
}

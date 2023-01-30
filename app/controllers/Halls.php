<?php

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
    }
}

<?php

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
    }
}

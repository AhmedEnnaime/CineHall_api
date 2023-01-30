<?php
class Pages extends Controller
{
  public function __construct()
  {
  }

  public function index()
  {

    $this->view('pages/index');
  }

  public function home()
  {

    $this->view('home');
  }

  public function about()
  {
    $data = [
      'title' => 'About Us'
    ];

    $this->view('pages/about', $data);
  }
}

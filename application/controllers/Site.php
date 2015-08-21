<?php
  class Site extends CI_Controller
  {
    function __construct()
    {
      parent::__construct();
    }

    function index()
    {
      $data["main_content"] = "main_pages/login";
      $this->load->view("common_views/base",$data);
    }

    function login()
    {
      echo "Log in";

    }

    function register()
    {
      echo "Register";
    }
  }
?>

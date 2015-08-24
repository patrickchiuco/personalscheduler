<?php
  class Site extends CI_Controller
  {
    function __construct()
    {
      parent::__construct();
      $this->load->model("User","user");
    }

    function index()
    {
      $data["main_content"] = "main_pages/login";
      $this->load->view("common_views/base",$data);
    }

    function login()
    {
      $data["page_title"] = "Log in Page";
      $this->form_validation->set_rules("email","email: ","required|valid_email|trim");
      $this->form_validation->set_rules("password","password: ","required|trim|min_length[8]");
      if($this->form_validation->run())
      {
          $input["email"] = $this->input->post("email");
          $input["password"] = $this->input->post("password");
          $auth_result = $this->user->authenticate($input);
          if($auth_result["is_authenticated"])
          {
            $user_data = array(
              "email" => $input["email"],
              "first_name" => $auth_result["fname"],
              "middle_name" => $auth_result["mname"],
              "last_name" => $auth_result["lname"],
              "email_notif" => $auth_result["email_notif"],
            );
            $this->session->set_userdata($user_data);
            redirect("site/user_page");
          }
          else
          {
            $data["main_content"] = "main_pages/login";
            $data["errors"] = $auth_result["message"];
            $this->load->view("common_views/base",$data);
          }
      }
      else
      {
        $data["main_content"] = "main_pages/login";
        $this->load->view("common_views/base",$data);
      }
    }
    function user_page()
    {
      $user_data = array(
        "fname" => $this->session->first_name,
        "mname" => $this->session->middle_name,
        "lname" => $this->session->last_name,
        "email" => $this->session->email,
        "email_notif" => $this->session->email_notif,
      );
    }
    function register()
    {

    }
  }
?>

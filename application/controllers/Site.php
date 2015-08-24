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
      $data["page_title"] = "Login Page";
      $this->load->view("common_views/base",$data);
    }

    function login()
    {
      $data["page_title"] = "Log in Page";
      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
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
      else
      {
        $data["main_content"] = "main_pages/login";
        $this->load->view("common_views/base",$data);
      }

    }
    function user_page()
    {
      $data = array(
        "fname" => $this->session->first_name,
        "mname" => $this->session->middle_name,
        "lname" => $this->session->last_name,
        "email" => $this->session->email,
        "email_notif" => $this->session->email_notif,
        "main_content" => "main_pages/dashboard",
      );

      load_view($data);
    }
    /*
      TODO: Transfer more computation to models
    */
    function register()
    {
      $data["page_title"] = "Registration Page";
      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
        $this->form_validation->set_rules("email","email:","required|valid_email|trim");
        $this->form_validation->set_rules("password","password: ","required|min_length[8]|trim");
        $this->form_validation->set_rules("fname","first name: ","required|trim");
        $this->form_validation->set_rules("mname","middle name: ","required|trim");
        $this->form_validation->set_rules("lname", "last name: ","required|trim");
        $this->form_validation->set_rules("email_notif", "email notification: ","required");
        if($this->form_validation->run())
        {
          $email = $this->input->post("email");
          $rows = $this->db->select("email, password")->where("email",$email)->get("Scheduler_User");
          if($rows->num_rows() > 0)
          {
            $data["errors"] = "User already exists.";
            $data['main_content'] = "main_pages/register";
            load_view($data);
          }
          else
          {
            $user_data = array(
                "email" => $this->input->post('email'),
                "password" => md5($this->input->post('password')),
                "fname" => $this->input->post('fname'),
                "mname" => $this->input->post('mname'),
                "lname" => $this->input->post('lname'),
                "email_notif" => ($this->input->post('email_notif') == "Yes") ? 1: 0,
            );
            $result = $this->user->create_user($user_data);
            if($result)
            {
              $this->session->set_userdata("email",$user_data["email"]);
              $this->session->set_userdata("fname",$user_data["fname"]);
              $this->session->set_userdata("mname",$user_data["mname"]);
              $this->session->set_userdata("lname",$user_data["lname"]);
              $this->session->set_userdata("email_notif",$user_data["email_notif"]);
              redirect(base_url().'index.php/site/user_page');
            }
            else
            {
            }
          }
        }
        else
        {
          $data["main_content"] = "main_pages/register";
          load_view($data);
        }
      }
      else
      {
        $data["main_content"] = "main_pages/register";
        load_view($data);
      }
    }
  }
?>

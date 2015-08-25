<?php
  class Site extends CI_Controller
  {
    private $template;
    private $today;
    function __construct()
    {
      parent::__construct();
      $this->load->model("User","user");
      $this->load->model("Event","event");
      $this->today = new DateTime();
      $this->template = '{table_open}<table border="0" cellpadding="0" cellspacing="0" class="table table-bordered">{/table_open}

        {heading_row_start}<tr>{/heading_row_start}

        {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

        {heading_row_end}</tr>{/heading_row_end}

        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td>{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}

        {cal_row_start}<tr>{/cal_row_start}
        {cal_cell_start}<td>{/cal_cell_start}
        {cal_cell_start_today}<td>{/cal_cell_start_today}
        {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}

        {cal_cell_content}
        <div>{day}</div>
        <div>{content}</div>
        {/cal_cell_content}
        {cal_cell_content_today}
          <div class="highlight">
          <div>{day}</div>
          <div>{content}</div>
          </div>
          {/cal_cell_content_today}

        {cal_cell_no_content}{day}{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

        {cal_cell_blank}&nbsp;{/cal_cell_blank}

        {cal_cell_other}{day}{cal_cel_other}

        {cal_cell_end}</td>{/cal_cell_end}
        {cal_cell_end_today}</td>{/cal_cell_end_today}
        {cal_cell_end_other}</td>{/cal_cell_end_other}
        {cal_row_end}</tr>{/cal_row_end}

        {table_close}</table>{/table_close}';
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
      $prefs = array(
        "show_next_prev" => TRUE,
        "next_prev_url" => site_url()."/site/user_page",
        "template" => $this->template,
      );
      $this->load->library("calendar", $prefs);
      $rows = $this->create_content($this->today->format("Y-m"));
      $data = array(
        "fname" => $this->session->first_name,
        "mname" => $this->session->middle_name,
        "lname" => $this->session->last_name,
        "email" => $this->session->email,
        "email_notif" => $this->session->email_notif,
        "main_content" => "main_pages/dashboard",
        "page_title" => "User Dashboard",
        "events" => $rows["events"],
      );


      load_view($data);
    }


    function create_content($date)
    {
      if(!isset($date))
      {
        $date = $this->today->format("Y-m");
      }
      $events = $this->event->get_event_by_month($date);
      return $events;
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
          $exists = $this->user->user_exists($email);
          if($exists)
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

<?php
  class Site extends CI_Controller
  {
    private $template;
    private $today;
    var $cal_prefs;
    function __construct()
    {
      parent::__construct();

      $this->load->model("User","user");
      $this->load->model("Event","event");

      date_default_timezone_set("Asia/Manila");
      $this->today = new DateTime();

      $this->template = '{table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar table-responsive">{/table_open}

        {heading_row_start}<tr class="heading-row-start">{/heading_row_start}

        {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th class="text-center" colspan="{colspan}">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th class="text-right"><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

        {heading_row_end}</tr>{/heading_row_end}

        {week_row_start}<tr class="week-row-start">{/week_row_start}
        {week_day_cell}<td class="text-center">{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}

        {cal_row_start}<tr class="cal-row-start">{/cal_row_start}
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
        $this->cal_prefs = array(
          "show_next_prev" => TRUE,
          "next_prev_url" => site_url()."/site/user_page",
          "template" => $this->template,
          "day_type" => "long",
        );
    }

    function index()
    {
      if($this->session->logged_in)
      {
        redirect(site_url()."/site/user_page");
      }
      else
      {
        $data["main_content"] = "main_pages/login";
        $data["page_title"] = "Login Page";
        load_view($data);
      }
    }

    function login()
    {
      $data["page_title"] = "Log in Page";
      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
        $this->form_validation->set_rules("email", "email ", "required|valid_email|trim");
        $this->form_validation->set_rules("password", "password ", "required|trim|min_length[8]");
        $data["main_content"] = "main_pages/login";
        if($this->form_validation->run())
        {
            $email = $this->input->post("email");
            $password = $this->input->post("password");
            $result = $this->user->authenticate($email, $password);
            if($result["authenticated"])
            {
              $user_data = array(
                "email" => $email,
                "first_name" => $result["fname"],
                "last_name" => $result["lname"],
                "email_notif" => $result["email_notif"],
                "logged_in" => 1,
              );
              $this->session->set_userdata($user_data);
              redirect("site/user_page");
            }
            else
            {
              $data["err_src"] = $auth_result["err_src"];
              load_view($data);
              return;
            }
        }
        else
        {
          load_view($data);
          return;
        }
      }
      else
      {
        load_view($data);
        return;
      }
    }

    function user_page()
    {
      if($this->session->logged_in)
      {

        $this->load->library("calendar", $this->cal_prefs);
        if($this->uri->segment(3) !== NULL)
        {
            $date_received = $this->uri->segment(3)."-".$this->uri->segment(4);
        }
        else
        {
            $date_received = $this->today->format("Y-m");
        }

        $rows = $this->create_content($date_received);
        $data = array(
          "fname" => $this->session->first_name,
          "mname" => $this->session->middle_name,
          "lname" => $this->session->last_name,
          "email" => $this->session->email,
          "email_notif" => $this->session->email_notif,
          "main_content" => "main_pages/dashboard",
          "page_title" => "Chronos - User Dashboard",
          "events" => $rows["events"],
        );
        //print_r($rows);
        //die();
        load_view($data);
      }
      else
      {
        redirect(site_url()."/site/restricted");
      }
    }

    function restricted()
    {
      $data["main_content"] = "common_views/restricted_access";
      $data["page_title"] = "Restricted Access";
      load_view($data);
    }

    function create_content($date)
    {
      if(!isset($date))
      {
        $date = $this->today->format("Y-m");
      }
      $events = $this->event->get_event_by_month($this->session->email,$date);
      return $events;
    }
    /*
      TODO: Transfer more computation to models
    */
    function register()
    {
      $data["page_title"] = "Registration Page";
      $data["wants_email"] = 1;
      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
        $this->form_validation->set_rules("email","email","required|valid_email|trim|is_unique[Scheduler_User.email]",array("is_unique" => "This %s already exists."));
        $this->form_validation->set_rules("password","password ","required|min_length[8]|trim");
        $this->form_validation->set_rules("fname","first name ","required|trim");
        $this->form_validation->set_rules("lname", "last name ","required|trim");
        $this->form_validation->set_rules("email_notif", "email notification ","required");
        $this->form_validation->set_rules("con_password", "confirm password","required|matches[password]|trim");
        $data["wants_email"] = ($this->input->post("email_notif") == "Yes") ? 1 : 0;
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
                "lname" => $this->input->post('lname'),
                "email_notif" => ($this->input->post('email_notif') == "Yes") ? 1: 0,
                "verified" => 0,
                "verification_code" => md5($this->input->post('email')),
            );
            $has_created = $this->user->create_user($user_data);
            $has_sent = $this->user->send_verification_email($user_data["email"],$user_data["verification_code"],FALSE);
            if($has_sent)
            {
              if($has_created)
              {
                $this->session->set_userdata("email",$user_data["email"]);
                $this->session->set_userdata("fname",$user_data["fname"]);
                $this->session->set_userdata("lname",$user_data["lname"]);
                $this->session->set_userdata("email_notif",$user_data["email_notif"]);
                $this->session->set_userdata("logged_in",1);
                redirect(base_url().'index.php/site/user_page');
              }
              else
              {
                $data["main_content"] = "confirmation_pages/registration";
                $data["message"] = "User was not created. Contact admin.";
                load_view($data);
              }
            }
            else
            {
              $data["main_content"] = "confirmation_pages/registration";
              $data["message"] = "Verification email not sent; user was not created. Contact admin.";
              load_view($data);
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


    function verify($verification_text = NULL)
    {
      $has_verfied = $this->user->verify_email_address($verification_text);
      $data["logged_in"] = $this->session->logged_in;
      if($has_verfied)
      {
        $data["verified"] = TRUE;
      }
      else
      {
        $data["verified"] = FALSE;
      }
      $data["main_content"] = "confirmation_pages/verification";
      load_view($data);
    }

    function send_verification_email($email, $verification_text, $resent)
    {
      $has_sent = $this->user->send_verification_email($email,$verification_text);
      $data["main_content"] = "confirmation_pages/verification";
      $data["resent"] = $resent;
      if($has_sent)
      {
        $data["sent"] = TRUE;
      }
      else
      {
        $data["sent"] = FALSE;
      }
      load_view($data);
    }

    function logout()
    {
      session_destroy();
      redirect(site_url()."/site");
    }

    function user_profile()
    {
      if($this->session->logged_in)
      {
        $data["page_title"] = "User Profile";
        $data["main_content"] = "main_pages/settings_views/user_profile";
        if($_SERVER["REQUEST_METHOD"] === "POST")
        {

        }
        else
        {
          $user_profile_values = $this->user->get_user_details()[0];
          $data["fname"] = $user_profile_values->fname;
          $data["lname"] = $user_profile_values->lname;
          $data["email"] = $user_profile_values->email;
          $data["verified"] = $user_profile_values->verified;
          $data["email_notif"] = intval($user_profile_values->email_notif);
          load_view($data);
          return;
        }
      }
      else
      {
          redirect(site_url()."/site/restricted");
      }
    }

    function user_profile_edit()
    {
      if($this->session->logged_in)
      {
        $data["page_title"] = "User Profile";
        $data["main_content"] = "main_pages/settings_views/user_profile_edit";
        $data["db_accessed"] = FALSE;
        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
          $this->form_validation->set_rules("email","email","required|valid_email|trim|callback_is_valid_update",array("is_unique" => "This %s already exists."));
          $this->form_validation->set_rules("fname","first name ","required|trim");
          $this->form_validation->set_rules("lname", "last name ","required|trim");
          $this->form_validation->set_rules("email_notif", "email notification ","required");
          if($this->form_validation->run())
          {
            $updates = array(
              "email" => $this->input->post("email"),
              "fname" => $this->input->post("fname"),
              "lname" => $this->input->post("lname"),
              "email_notif" => $this->input->post("email_notif"),
            );

            $profile_updated = $this->user->update_user_profile($updates);
            $data["db_accessed"] = TRUE;
            if($profile_updated)
            {
              $data["updated"] = TRUE;
            }
            else
            {
              $data["updated"] = FALSE;
            }
            load_view($data);
            return;
          }
          else
          {
            $data["email_notif"] = $this->input->post("email_notif");
            load_view($data);
            return;
          }
        }
        else
        {
          $user_profile_values = $this->user->get_user_details()[0];
          $data["fname"] = $user_profile_values->fname;
          $data["lname"] = $user_profile_values->lname;
          $data["email"] = $user_profile_values->email;
          $data["email_notif"] = $user_profile_values->email_notif;
          load_view($data);
          return;
        }
      }
      else
      {
          redirect(site_url()."/site/restricted");
      }
    }

    function forgot_password()
    {
      $data["main_content"] = "main_pages/forgot_password_view";
      $data["page_title"] = "Forgot Password";
      $data["validated"] = FALSE;
      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
        $this->form_validation->set_rules("forgot-password-email","email", array('required', 'trim', 'valid_email',array('exists_callable',array($this->user, 'user_exists'))));
        $this->form_validation->set_message('exists_callable','The email you entered is not in our database.');
        if($this->form_validation->run())
        {
          $data["validated"] = TRUE;
          $sent = $this->user->send_forgot_password_email($this->input->post('forgot-password-email'));
          if($sent)
          {
            $data["sent"] = TRUE;
          }
          else
          {
            $data["sent"] = FALSE;
          }
          load_view($data);
        }
        else
        {
          load_view($data);
          return;
        }
      }
      else
      {
          load_view($data);
          return;
      }
    }

    function forgot_password_confirm($code)
    {
      $is_verified = $this->user->verify_code($code);
      $data["page_title"] = "Reset Password";
      $data["main_content"] = "main_pages/forgot_password_confirm_view";
      if($is_verified["verified"])
      {
        $this->form_validation->set_rules("fpassword","password","required|trim|min_length[8]");
        $this->form_validation->set_rules("fpassword_conf","confirm password","required|trim|matches[fpassword]");
        if($this->form_validation->run())
        {
          $password = $this->input->post("fpassword");
          $updated = $this->user->update_password($is_verified["email"],$password);
          $data["main_content"] = "main_pages/reset_password_confirm_view";
          $data["page_title"] = "Reset Password";
          if($updated)
          {
            $data["updated"] = TRUE;
          }
          else
          {
            $data["updated"] =  FALSE;
          }
          load_view($data);
          return;
        }
        else
        {
            $data["valid_code"] = TRUE;
            $data["code"] = $code;
            load_view($data);
        }
      }
      else
      {
        $data["valid_code"] = FALSE;
        load_view($data);
        return;
      }
    }

    function is_valid_update($new_email)
    {
      if($new_email === $this->session->email)
      {
        return TRUE;
      }
      else
      {
        $exists = $this->user->user_exists($new_email);
        if(!$exists)
        {
          return TRUE;
        }
        else
        {
          $this->form_validation->set_message("is_valid_update","A user with that email already exists");
          return FALSE;
        }
      }
    }

    function resend_verification()
    {
      $verification_text = md5($this->session->email);
      $this->send_verification_email($this->session->email,$verification_text,TRUE);
    }
  }
?>

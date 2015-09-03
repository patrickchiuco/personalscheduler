<?php
  class User extends CI_Model
  {
    private $now;
    function __construct()
    {
      parent::__construct();
      $this->load->library('email');
      $this->email->set_newline("\r\n");
      $this->email->from("admin@personalscheduler.com","Jacob");
      date_default_timezone_set("Asia/Manila");
      $this->now = new DateTime();
    }

    function update_user_profile($updates)
    {
      $updated = $this->db->where("email",$this->session->email)->update("Scheduler_User",$updates);
      return $updated;
    }

    function get_user_details()
    {
      $user_details = $this->db->select("*")->where("email",$this->session->email)->get("Scheduler_User");
      if($user_details->num_rows() > 0)
      {
        return $user_details->result();
      }
      else
      {
        return NULL;
      }
    }

    function user_exists($email)
    {
      $result = $this->db->select("*")->where("email",$email)->get("Scheduler_User");
      if($result->num_rows())
      {
        return TRUE;
      }
      else
      {
        return FALSE;
      }
    }

    function authenticate($email,$password)
    {
      $result = array();
      $row = $this->db->select(" * ")->where("email", $email)->get("Scheduler_User");
      if($row->num_rows() > 0)
      {
        $md5_input_password = md5($password);
        $user_data = $row->result()[0];
        $md5_db_password = $user_data->password;
        if($md5_input_password == $md5_db_password)
        {
          $result = array(
            "authenticated" => TRUE,
            "fname" => $user_data->fname,
            "lname" => $user_data->lname,
            "email_notif" => $user_data->email_notif,
          );
        }
        else
        {
          $result["err_src"] = 'em';
          $result["authenticated"] = FALSE;
        }
      }
      else
      {
        $result["err_src"] = 'e';
        $result["authenticated"] = FALSE;
      }
      return $result;
    }

    function create_user($data)
    {
      $result = $this->db->insert("Scheduler_User",$data);
      return $result;
    }

    function send_verification_email($email,$verification_text)
    {
      $verification_link = site_url()."/site/verify/".$verification_text;
      $this->email->to($email);
      $this->email->subject("Email Verification");
      $this->email->message("Please click the following URL to verify:\n\n".$verification_link);
      $this->db->where("email",$email)->update("Scheduler_User",array("verification_code" => $verification_text));
      if($this->email->send())
      {
        return TRUE;
      }
      else
      {
        return FALSE;
      }
    }

    function verify_email_address($verification_code)
    {
      $result = $this->db->where("verification_code",$verification_code)->update("Scheduler_User",array("verified" => 1));
      return $result;
    }

    function send_forgot_password_email($email)
    {
      $link = "/site/forgot_password_confirm/".md5($email);
      $this->email->to($email);
      $this->email->subject('Reset Password');
      $this->email->message("Please click on the following link to reset your password:\n\n".site_url().$link."\n\n This email is valid for one day only.\n\n Cheers, Jacob");
      if($this->email->send())
      {
        $updates = array('change_password_date' => $this->now->format("Y-m-d H:i:s"),
          'forgot_password_code' => md5($email),
        );
        $updated = $this->db->where("email",$email)->update('Scheduler_User',$updates);
        if($updated)
        {
          return TRUE;
        }
        else
        {
            log_message('error','Change password date was not set');
            return FALSE;
        }
      }
      else
      {
        return FALSE;
      }
    }

    function update_password($email, $password)
    {
      $updated = $this->db->where("email",$email)->update("Scheduler_User",array("password" => md5($password)));
      if($updated)
      {
        return TRUE;
      }
      else
      {
        return FALSE;
      }

    }

    function verify_code($code)
    {
      $changed_date = $this->db->select("email, change_password_date")->where("forgot_password_code", $code)->get("Scheduler_User")->result()[0];
      $changed_on = new DateTime($changed_date->change_password_date);
      $delta = $changed_on->diff($this->now);
      $result = array();
      if($delta->d >= 1)
      {
          $result["verified"] = FALSE;
          return $result;
      }
      else
      {
        $result["email"] = $changed_date->email;
        $result["verified"] = TRUE;
        return $result;
      }
    }
  }
?>

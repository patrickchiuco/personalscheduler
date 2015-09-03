<?php
  class User extends CI_Model
  {
    function __construct()
    {
      parent::__construct();

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

    function authenticate($data)
    {
      $result = array();
      $row = $this->db->select("*")->where("email",$data["email"])->get("Scheduler_User");
      if($row->num_rows() > 0)
      {
        $md5_input_password = md5($data["password"]);
        $user_data = $row->result()[0];
        $md5_db_password = $user_data->password;
        if($md5_input_password == $md5_db_password)
        {
          $result = array(
            "message" => "Authetication succeeded",
            "is_authenticated" => TRUE,
            "fname" => $user_data->fname,
            //"mname" => $user_data->mname,
            "lname" => $user_data->lname,
            "email_notif" => $user_data->email_notif,
          );

        }
        else
        {
          $result["message"] = "Username/password did not match.";
          $result["err_src"] = 'em';
          $result["is_authenticated"] = FALSE;
        }
      }
      else
      {
        $result["message"] = "User not found.";
        $result["err_src"] = 'e';
        $result["is_authenticated"] = FALSE;
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
      $this->load->library('email');
      $this->email->set_newline("\r\n");
      $this->email->from("admin@personalscheduler.com","Jacob");
      $this->email->to($email);
      $this->email->subject("Email Verification");
      $this->email->message("Please click the following URL to verify:\n\n".$verification_link);

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
  }
?>

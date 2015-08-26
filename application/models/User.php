<?php
  class User extends CI_Model
  {
    function __construct()
    {
      parent::__construct();

    }

    function get_user_details()
    {

    }

    function user_exists($email)
    {
      $result = $this->db->select("email, password")->where("email",$email)->get("Scheduler_User");
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
            "mname" => $user_data->mname,
            "lname" => $user_data->lname,
            "email_notif" => $user_data->email_notif,
          );

        }
        else
        {
          $result["message"] = "Username/password did not match.";
          $result["is_authenticated"] = FALSE;
        }
      }
      else
      {
        $result["message"] = "User not found.";
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
      $this->db->where("verification_code",$verification_text)->update("Scheduler_User",array("user_status" => "U"));

      $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'patrick.chiuco',
        'smtp_pass' => 'Habea$.091190',
      );


      $verification_link = site_url()."/site/verify/".$verification_text;


      $this->load->library('email');
      $this->email->initialize($config);
      $this->email->set_newline("\r\n");
      $this->email->from("admin@personalscheduler.com","Jacob");
      $this->email->to($email);
      $this->email->subject("Email Verification");
      $this->email->message('Please click the following URL to verify:\n\n'.$verification_link);




      if($this->email->send())
      {
        return TRUE;
      }
      else
      {
        show_error($this->email->print_debugger());
        die();
        return FALSE;
      }
    }

    function verify_email_address($verification_code)
    {
      $result = $this->db->where("verification_code",$verification_code)->update("Scheduler_User",array("user_status" => "V"));
      return $result;
    }
  }
?>

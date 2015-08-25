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
  }
?>

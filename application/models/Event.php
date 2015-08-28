<?php
  class Event extends CI_Model
  {
    //gamitan ng algo sa susunod
    // wag gawin ng basta basta. keep the algo simple and easy to maintain and read
    // plan return values and formats before doing dev and architecture (implementation)
    // tagalugin na parang UP
    /*
      Ilagay ang table names sa mga variables para madaling ibahin
      I check kung tama ang database
    */
    private $table_name = "Scheduler_Event";
    function __construct()
    {
      parent::__construct();
      $this->load->library('email');
    }

    function get_event_by_month($email,$date)
    {
      $result = $this->db->distinct()->like('date',$date)->get_where($this->table_name,array("email" => $email));

      //die();
      $events = array();

      if($result->num_rows() > 0)
      {
        foreach($result->result() as $row)
        {
          //$events_by_day = $this->db->select("eid, name")->where("date",$row->date)->get($this->table_name,array("email"=>$email));
          $key = intval(substr($row->date,8,2));
          $events[$key] = '<ul class="event-list">';
          //$key = $day."";
        }
        foreach($result->result() as $row)
        {
          //$events_by_day = $this->db->select("eid, name")->where("date",$row->date)->get($this->table_name,array("email"=>$email));
          $events[$key] = $events[$key]."<li><a href='".site_url()."/events/view_event/".$row->eid."'>".$row->name."</a></li>";
          //$key = $day."";
        }
        foreach($result->result() as $row)
        {
          //$events_by_day = $this->db->select("eid, name")->where("date",$row->date)->get($this->table_name,array("email"=>$email));
          $events[$key] = $events[$key]."</ul>";
          //$key = $day."";
        }

        $output["events"] = $events;
        $output["success"] = TRUE;
      }
      else
      {
        $output["events"] = NULL;
        $output["success"] = FALSE;
      }
      return $output;
    }


    /*
      Get users with events today
    */
    function get_users_with_events($date)
    {
      $users_with_events = $this->db->select("email")->distinct("email")->where("date",$date)->get($this->table_name);
      if($users_with_events->num_rows() > 0)
      {
        return $users_with_events->result();
      }
      else
      {
        return NULL;
      }
    }

    /*
      Get events by user on given date $params = array ("email" and "date")
    */
    function get_user_events_on($email, $date)
    {
      $params = array(
        "email" => $email,
        "date" => $date,
      );
      $user_events = $this->db->select("name")->get_where($this->table_name,$params);

      if($user_events->num_rows() > 0)
      {

        return $user_events->result();
      }
      else
      {
        return NULL;
      }
    }

    function get_event($id)
    {
      $result = $this->db->select("eid, name, description, date")->where("eid",$id)->get($this->table_name);
      if($result->num_rows())
      {
        return $result->result();
      }
      else
      {
        return NULL;
      }
    }

    function add_event_to_db($data)
    {
      $added = $this->db->insert($this->table_name,$data);
      if($added)
      {
        return $this->db->insert_id();
      }
      else
      {
        return NULL;
      }
    }


    function edit_event_details($id, $updated_details)
    {
          $result = $this->db->where("eid",$id)->update($this->table_name,$updated_details);
          return $result;
    }

    function delete_event($id)
    {
      $this->load->helper("file");
      $files = $this->db->select("file_id")->get_where("Scheduler_Event_Has", array("eid" => $id));
      $deleted_assoc = $this->db->where("eid", $id)->delete("Scheduler_Event_Has");
      $output = array();
      if($deleted_assoc)
      {
        $deleted_events = $this->db->where("eid",$id)->delete($this->table_name);
        if($deleted_events)
        {
          foreach($files->result() as $file)
          {
            $curr_file = $this->db->select("*")->get_where("Scheduler_File",array("file_id" => $file->file_id))->result();
            $orig_file = $this->config->item("UPLOADS")."/".$curr_file[0]->file_name;
            $thumb = $this->config->item("UPLOADS")."/".$curr_file[0]->thumb_name;

            if(unlink($orig_file))
            {
              if(unlink($thumb))
              {
                $deleted_file = $this->db->where("file_id", $file->file_id)->delete("Scheduler_File");
                if($deleted_file)
                {
                  $output["message"] = "Deletion successful";
                  $output["success"] = TRUE;
                }
                else
                {
                  $output["message"] = "File not deleted";
                  $output["success"] = FALSE;
                  return $output;
                }

              }
              else
              {
                $output["message"] = "Thumbnail was not deleted";
                $output["success"] = FALSE;
                return $output;
              }
            }
            else
            {
              $output["message"] = "Original file was not deleted";
              $output["success"] = FALSE;
              return $output;
            }
          }
        }
        else
        {
          $output["message"] = "Event not deleted";
          $output["success"] = FALSE;
          return $ouput;
        }
      }
      else
      {
        $output["message"] = "Assocs not deleted";
        $output["success"] = FALSE;
        return $output;
      }

    }

    function search_event($term)
    {
      $match = array(
        "date" => $term,
        "description" => $term,
        "name" => $term,
      );
      //$date_matches = $this->db->distinct("eid")->or_like($match)->get($this->table_name);

      $date_matches = $this->db->like("date",$term)->get($this->table_name);
      $desc_matches = $this->db->like("description",$term)->get($this->table_name);
      $name_matches = $this->db->like("name",$term)->get($this->table_name);
      $result = array();
      if($date_matches->num_rows() > 0)
      {
        $result["date"] = $date_matches->result();
      }
      else if($desc_matches->num_rows() > 0)
      {
        $result["desc"] = $desc_matches->result();
      }
      else if($name_matches->num_rows() > 0)
      {
        $result["name"] = $name_matches->result();
      }
      if(empty($result))
      {
        return NULL;
      }
      else {
        return $result;
      }
    }

    function add_file($file_info)
    {
      $values = array(
        "file_name" => $file_info["file_name"],
        "thumb_name" => $file_info["raw_name"]."_thumb".$file_info["file_ext"],
      );
      $insert_success = $this->db->insert("Scheduler_File", $values);
      if($insert_success)
      {
        return $this->db->insert_id();
      }
      else
      {
        return NULL;
      }
    }


    function insert_to_event_has($eid, $file_id)
    {
      $values = array(
        "eid" => $eid,
        "file_id" => $file_id,
      );
      $insert_success = $this->db->insert("scheduler_Event_Has", $values);
      return $insert_success;
    }
  }
?>

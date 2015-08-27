<?php
  class Event extends CI_Model
  {
    //gamitan ng algo sa susunod
    // wag gawin ng basta basta. keep the algo simple and easy to maintain and read
    // plan return values and formats before doing dev and architecture (implementation)
    private $table_name = "Scheduler_Event";
    function __construct()
    {
      parent::__construct();
      $this->load->library('email');
    }

    function get_event_by_month($date,$email)
    {
      $result = $this->db->distinct('date')->like('date',$date)->get_where($this->table_name,array("email" => $email));
      $events = array();
      foreach($result->result() as $row)
      {
        $events_by_day = $this->db->select("eid, name")->where("date",$row->date)->get($this->table_name,array("email"=>$email));
        $key = substr($row->date,8,2);
        $events[$key] = '<ul class="event-list">';
        foreach($events_by_day->result() as $event)
        {
          $events[$key] = $events[$key]."<li><a href='".site_url()."/events/view_event/".$event->eid."'>".$event->name."</a></li>";
        }
        $events[$key] = $events[$key]."</ul>";
      }
      if($result->num_rows() > 0)
      {
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
      $result = $this->db->insert($this->table_name,$data);
      return $result;
    }


    function edit_event_details($id, $updated_details)
    {
      if(isset($updated_details))
      {
          $this->db->where("eid",$id)->update($this->table_name,$updated_details);
          return TRUE;
      }
      else
      {
        return FALSE;
      }
    }

    function delete_event($id)
    {
      $result = $this->db->delete($this->table_name,array("eid" => $id));
      return $result;
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
  }
?>

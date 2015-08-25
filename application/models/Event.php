<?php
  class Event extends CI_Model
  {
    private $table_name = "Scheduler_Event";
    function __construct()
    {
      parent::__construct();
    }

    function get_event_by_month($date)
    {
      $result = $this->db->distinct('date')->like('date',$date)->get($this->table_name);
      $events = array();
      foreach($result->result() as $row)
      {
        $events_by_day = $this->db->select("eid, name")->where("date",$row->date)->get($this->table_name);
        $key = substr($row->date,8,2);
        $events[$key] = '<ul class="event-list">';
        //$events[$key] = '<ul>';
        foreach($events_by_day->result() as $event)
        {
          $events[$key] = $events[$key]."<li><a href='".site_url()."/events/view_event/".$event->eid."'>".$event->name."</a></li>";
        //  $events[$key] = $events[$key].$event->name."<br/>";
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

    function add_event($data)
    {
      $result = $this->db->insert($this->table_name,$data);
      return $result;
    }


    function edit_event_details($id, $updated_details)
    {
      //$this->db->
      if(isset($updated_details))
      {
          $this->db->where("id",$id)->update($this->table_name,$updated_details);
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
  }
?>

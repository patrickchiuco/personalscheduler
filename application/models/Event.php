<?php
  class Event extends CI_Model
  {
    $table_name = "Scheduler_Event";
    function __construct()
    {
      parent::__construct();
    }

    function get_event_details()
    {
      //$this->db->select("*")->from("")
    }

    function add_event($event_details)
    {
      if(isset($event_details))
      {
          $this->db->insert($table_name,$event_details);
          return TRUE;
      }
      else
      {
          return FALSE;
      }
    }


    function edit_event_details($id, $updated_details)
    {
      //$this->db->
      if(isset($updated_details))
      {
          $this->db->where("id",$id)->update($table_name,$updated_details);
          return TRUE;
      }
      else
      {
        return FALSE;
      }
    }

    function delete_event()
    {

    }
  }
?>

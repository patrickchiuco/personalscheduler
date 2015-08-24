<?php
  class Event extends CI_Model
  {
    private $table_name = "Scheduler_Event";
    function __construct()
    {
      parent::__construct();
    }

    function get_event_details()
    {
      //$this->db->select("*")->from("")
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

    function delete_event()
    {

    }
  }
?>

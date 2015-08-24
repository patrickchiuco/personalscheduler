<?php
  class Events extends CI_Controller
  {
    function __construct()
    {
      parent::__construct();
      $this->load->model("event");
    }
    function index()
    {
      echo "Hello";

    }

    function add_event()
    {
      $data["page_title"] = "Add Event";
      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
        $this->form_validation->set_rules("event_name","event name","required|trim");
        $this->form_validation->set_rules("event_desc","event description","required|trim");
        //TODO: Add event date
        if($this->form_validation->run())
        {
          $today = new DateTime();
          $user_data = array(
              "name" => $this->input->post("event_name"),
              "description" => $this->input->post("event_desc"),
              "date" => $today->format("Y-m-d"),
              "email" => "mmitchell@gmail.com",
          );
          $succeeded = $this->event->add_event($user_data);
          $data["page_title"] = "User Dashboard";
          $data["main_content"] = "main_pages/dashboard";
          if($succeeded)
          {
            $data["message"] = "Event Successfully Added";
          }
          else
          {
            $data["message"] = "Message added unsuccessfully";
          }
          load_view($data);
        }
        else
        {
          $data["main_content"] = "main_pages/event_pages/add_event";
          load_view($data);
        }
      }
      else
      {
        $data["main_content"] = "main_pages/event_pages/add_event";
        load_view($data);
      }

    }

  }
?>

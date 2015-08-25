<?php
  //wag magbilang na parang rhythm sa cs or dev or kahit anong sciences econ, ie, math, business
  // mag bilang na parang math and cs
  class Events extends CI_Controller
  {
    private $today;
    function __construct()
    {
      parent::__construct();
      $this->load->model("event");
      $this->load->library("calendar");
      $this->today = new DateTime();
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
          $now = new DateTime();
          $user_data = array(
              "name" => $this->input->post("event_name"),
              "description" => $this->input->post("event_desc"),
              "date" => $now->format("Y-m-d"),
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


    function view_event($id = NULL)
    {
      $data = array(
        "page_title" => "Event Details",
        "main_content" => "main_pages/event_pages/view_event"
      );
      if($id)
      {
        $event = $this->event->get_event($id)[0];
        $data["eid"] = $event->eid;
        $data["event_name"] = $event->name;
        $data["event_desc"] = $event->description;
        $data["event_date"] = $event->date;
        load_view($data);
      }
      else
      {
        $data["errors"] = "Something went wrong. Contact administrator.";
        load_view($data);
      }
    }

    function delete_event($id , $confirm = 0)
    {
      $data["main_content"] = "main_pages/event_pages/delete_event";
      $data["confirm"] = $confirm;
      $data["page_title"] = "Confirm delete";
      if($confirm)
      {
        $success = $this->event->delete_event($id);
        if($success)
        {
          $data["message"] = "Delete successful";
        }
        else
        {
          $data["message"] = "Delete unsuccessful";

        }
        load_view($data);
      }
      else
      {
        $data["eid"] = $id;
        load_view($data);
      }
    }

    function edit_event()
    {

    }

    function search_event()
    {

    }

    function upload_file()
    {
    }
  }
?>

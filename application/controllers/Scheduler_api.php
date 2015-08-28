<?php
  require(APPPATH."/libraries/REST_Controller.php");
  /*
    Plan things to get from API.
    Format etc.
    Never alisin ang mga tinuro/inaaral sa CS and Math kahit sabihin kong walang logic yung sinasabi ng iba or walang sense
    Wag tanggalin.
    Gawing reusable
  */
  class Scheduler_api extends REST_Controller
  {
    function __construct()
    {
      parent::__construct();
      $this->load->model("Event","event");
    }
    function index()
    {
      echo "Scheduler_api";
    }

    function event_get()
    {
      //fetch item
      /*
        Do error checking.
      */
      if((!$this->get("date")) || (!$this->get("email")) || ($this->get("month") === NULL))
      {
        $this->response(NULL, 400);
      }
        $email = urldecode($this->get("email"));
        $date = urldecode($this->get("date"));
        $month = urldecode($this->get("month"));

        if($month)
        {
          $user = $this->event->get_event_by_month($email,$date);
        }
        else
        {
            $user = $this->event->get_user_events_on($email,$date);
        }

      if($user)
      {
        $this->response($user,200);
      }
      else
      {
        $this->response(NULL,404);
      }
    }

    function event_post()
    {
      //update item and inform success
      if($this->post("eid") != NULL)
      {
        $eid = $this->post("eid");
        $updates = array(
          "name" => $this->post("event_name"),
          "description" => $this->post("event_desc"),
          "date" => $this->post("event_date"),
          "email" => $this->post("email")
        );
        $result = $this->event->edit_event_details($eid,$updates);
        if($result)
        {
          $this->response(array("status" => "success"), 200);
        }
        else
        {
          $this->response(array("status"=>"failed"),304);
        }
      }
      else
      {
        $this->response(NULL, 400);
      }
    }

    function users_get()
    {
      $users = $this->user_model->get_all();

      if($users)
      {
        $this->response($users, 200);
      }
      else
      {
        $this->response(NULL, 404);
      }
    }

    function event_put()
    {

    }
    function item_put()
    {
      //create new item and inform success
      $this->data = array("result" => $this->put("id"));
      $this->response($data);
    }

    function item_delete()
    {
      //delete an item and inform success
      $this->data = array("result" => $this->delete("id"));
      $this->response($data);
    }


  }
?>

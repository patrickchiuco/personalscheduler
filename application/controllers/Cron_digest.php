<?php
  /*
    Note: Wag lang paganahin. May cases, dapat malinis.
    Wag lang paganahin. Sumunod sa standards.
  */
  class Cron_digest extends CI_Controller
  {
    function __construct()
    {
      parent::__construct();
      $this->load->model("Event","event");
    }

    public function index()
    {
    }

    public function send_digest($date)
    {
      if($this->input->is_cli_request())
      {

        $users_with_events = $this->event->get_users_with_events($date);
        if($users_with_events != NULL)
        {
          foreach($users_with_events as $user)
          {

            $user_events = $this->event->get_user_events_on($user->email, $date);
            //get user's events for given date

            $event_text = "\n";
            foreach($user_events as $event)
            {
              $event_text = $event_text." - ".$event->name."\n";
            }

            $this->email->set_newline("\r\n");
            $this->email->from("admin@personalscheduler.com","Jacob");
            $this->email->to($user->email);
            $this->email->subject("Daily Digest");
            $this->email->message("Here are your events for the day:\n\n".$event_text);

            if($this->email->send())
            {
              $message = "Digest sent.".PHP_EOL;
            }
            else
            {
              $message = "Digest failed to be sent.".PHP_EOL;
            }
            echo $message;
          }
        }
        else
        {
          echo "There are no users with events today.".PHP_EOL;
        }
      }
      else
      {
        echo "Accessible only in the command line.";
      }
    }
  }

?>

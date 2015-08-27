<?php
  /*
    Note: Wag lang paganahin. May cases, dapat malinis.
    Wag lang paganahin. Sumunod sa standards.
  */
  class Cron_digest extends CI_Controller
  {
    private $today;
    function __construct()
    {
      parent::__construct();
      $this->load->model("Event","event");
      date_default_timezone_set("Asia/Manila");
      $this->today = new DateTime();
    }

    public function index()
    {
      $this->send_digest($this->today->format("Y-m-d"));
    }
    public function send_digest($date)
    {

      if($this->input->is_cli_request())
      {
        //$date = $this->today->format("Y-m-d");
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
            return;
          }
        }
        else
        {
          echo "There are no users with events today.".PHP_EOL;
          return;
        }
      }
      else
      {
        echo "Accessible only in the command line.";
      }
    }
  }

?>

<?php
  //wag magbilang na parang rhythm sa cs or dev or kahit anong sciences econ, ie, math, business
  // mag bilang na parang math and cs
  //never gumawa na basta basta lang
  class Events extends CI_Controller
  {
    private $today;
    private $cal_prefs;
    private $template;
    function __construct()
    {
      parent::__construct();
      $this->load->model("event");
      $this->template = '{table_open}<table border="0" cellpadding="0" cellspacing="0" class="table table-bordered">{/table_open}

        {heading_row_start}<tr>{/heading_row_start}

        {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

        {heading_row_end}</tr>{/heading_row_end}

        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td>{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}

        {cal_row_start}<tr>{/cal_row_start}
        {cal_cell_start}<td>{/cal_cell_start}
        {cal_cell_start_today}<td>{/cal_cell_start_today}
        {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}

        {cal_cell_content}
        <div>{day}</div>
        <div>{content}</div>
        {/cal_cell_content}
        {cal_cell_content_today}
          <div class="highlight">
          <div>{day}</div>
          <div>{content}</div>
          </div>
          {/cal_cell_content_today}

        {cal_cell_no_content}{day}{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

        {cal_cell_blank}&nbsp;{/cal_cell_blank}

        {cal_cell_other}{day}{cal_cel_other}

        {cal_cell_end}</td>{/cal_cell_end}
        {cal_cell_end_today}</td>{/cal_cell_end_today}
        {cal_cell_end_other}</td>{/cal_cell_end_other}
        {cal_row_end}</tr>{/cal_row_end}

        {table_close}</table>{/table_close}';
      $this->cal_prefs = array(
        "show_next_prev" => TRUE,
        "next_prev_url" => site_url()."/site/user_page",
        "template" => $this->template,
      );
      $this->load->library("calendar",$this->cal_prefs);
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
        $this->form_validation->set_rules("event_date", "event date","required|trim|regex_match[/\d{4}\-\d{2}\-\d{2}/]");
        //TODO: Add event date
        if($this->form_validation->run())
        {
          $now = new DateTime();
          $user_data = array(
              "name" => $this->input->post("event_name"),
              "description" => $this->input->post("event_desc"),
              "date" => $this->input->post("event_date"),
              "email" => $this->session->email,
          );
          $succeeded = $this->event->add_event_to_db($user_data);
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
          $data["events"] = $this->event->get_event_by_month($now->format("Y-m"),$this->session->email);
          load_view($data);
        }
        else
        {
          $data["main_content"] = "main_pages/event_pages/add_event";
          $data["hidden"] = array("user_email" => $this->session->email);
          load_view($data);
        }
      }
      else
      {
        $data["main_content"] = "main_pages/event_pages/add_event";
        $data["hidden"] = array("user_email" => $this->session->email);
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

    function edit_event($id)
    {
      $data = array(
        "page_title" => "Edit Event",
        "main_content" => "main_pages/event_pages/edit_event",
        "update_done" => FALSE,
        "eid" => $id,
      );
      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
        $this->form_validation->set_rules("ename","event name","required|trim");
        $this->form_validation->set_rules("edesc","event description","required|trim");
        $this->form_validation->set_rules("edate","event date","required|trim|regex_match[/\d{4}\-\d{2}\-\d{2}/]");
        if($this->form_validation->run())
        {
          $data["update_done"] = TRUE;
          $user_data = array(
            "name" => $this->input->post("ename"),
            "description" => $this->input->post("edesc"),
            "date" => $this->input->post("edate"),
          );
          $result = $this->event->edit_event_details($id,$user_data);
          if($result)
          {
            $data["message"] = "Updated successfully.";
          }
          else
          {
            $data["message"] = "Update failed.";
          }
          load_view($data);
        }
        else
        {
          $data["eid"] = $id;
          $data["ename"] = $this->input->post("ename");
          $data["edesc"] = $this->input->post("edesc");
          $data["edate"] = $this->input->post("edate");
          load_view($data);
        }
      }
      else
      {
        $event = $this->event->get_event($id);
        $data["eid"] = $event[0]->eid;
        $data["ename"] = $event[0]->name;
        $data["edesc"] = $event[0]->description;
        $data["edate"] = $event[0]->date;
        load_view($data);
      }
    }

    function search()
    {
      /*
        TODO: Transfer ang formatting sa model
      */
      $term = trim($this->input->post("search-term"));
      $data["main_content"] = "main_pages/event_pages/search_event";
      $data["page_title"] = "Search Event";
      if(strlen($term) > 0)
      {
        $data["result"] = array(
          "name" => "",
          "desc" => "",
          "date" => "",
        );
        $result = $this->event->search_event($term);
        foreach($result as $key => $value)
        {
          $data["result"][$key] = $data["result"][$key]."<dl>";
          foreach($value as $event)
          {
            $data["result"][$key] = $data["result"][$key]."<div style='margin-top:2%;'><dt>Name: </dt>"."<dd>".$event->name."</dd><dt>Date: </dt>".
            "<dd>".$event->date."</dd><dt>Description: </dt><dd>".$event->description."</dd></div>";
          }
          $data["result"][$key] = $data["result"][$key]."</dl>";
        }
        load_view($data);
      }
      else
      {
        $data["message"] = "Please enter a search term.";
        load_view($data);
      }
    }

    function upload_file()
    {
    }

    
  }
?>

<?php
  //wag magbilang na parang rhythm sa cs or dev or kahit anong sciences econ, ie, math, business
  // mag bilang na parang math and cs
  //never gumawa na basta basta lang
  //wag gawin ng basta basta
  /*
    wag baliktarin ang sarili para hindi mabwisit
    tanggalin ang abnormal kaguluhan
    ayusin sobrang gulo (2x). linisin sobrang dumi.
  */
  class Events extends CI_Controller
  {
    private $today;
    private $cal_prefs;
    private $template;
    private $upload_config;
    function __construct()
    {
      parent::__construct();
      date_default_timezone_set("Asia/Manila");
      $this->upload_config = array(
        'upload_path' => './uploads/',
        'allowed_types' => 'gif|jpg|jpeg|png',
        'max_size' => '10000',
        'max_width' => '5000',
        'max_height' => '3000',
      );
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
        "day_type" => "long",
      );
      $this->load->library("calendar",$this->cal_prefs);
      $this->today = new DateTime();

    }
    function index()
    {
      $data["main_content"] = "upload_view";
      $data["page_title"] = "Upload Test";
      load_view($data);
    }

    function hello()
    {

    }

    function add_event()
    {
      $data["page_title"] = "Add Event";
      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
        $this->form_validation->set_rules("event_name","event name","required|trim");
        $this->form_validation->set_rules("event_desc","event description","required|trim");
        $this->form_validation->set_rules("event_date", "event date","required|trim|regex_match[/\d{4}\-\d{2}\-\d{2}/]");
        if($this->form_validation->run())
        {
          $user_data = array(
              "name" => $this->input->post("event_name"),
              "description" => $this->input->post("event_desc"),
              "date" => $this->input->post("event_date"),
              "email" => $this->session->email,
          );
          $upload_successful = $this->upload_file();
          if($upload_successful["successful"])
          {
            $result = $this->event->add_event_to_db($user_data);
            $data["page_title"] = "User Dashboard";
            $data["main_content"] = "main_pages/dashboard";
            if($result !== NULL)
            {
              //add to scheduler_event_has
              $now = new DateTime();
              $added = $this->event->insert_to_event_has($result,$upload_successful["file_id"]);
              if($added)
              {
                $data["message"] = "Event Successfully Added";
                $user_monthly_events = $this->event->get_event_by_month($this->session->email,$now->format("Y-m"));
                $data["events"] = $user_monthly_events["events"];
                $data['email'] = $this->session->email;
              }
              else
              {
                $data["message"] = "Adding event failed.";
              }
              load_view($data);
            }
            else
            {
              $data["message"] = "Event not added to db";
              $data["main_content"] = "main_pages/event_pages/add_event";
              $data["hidden"] = array("user_email" => $this->session->email);
              load_view($data);
            }
          }
          else
          {
            $data["message"] = "File failed to uplaod";
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
      $data["has_results"] = 0;
      if(strlen($term) > 0)
      {
        $data["result"] = array(
          "name" => "",
          "desc" => "",
          "date" => "",
        );
        $result = $this->event->search_event($term);
        if($result != NULL)
        {
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
          $data["has_results"] = 1;
        }
        else
        {
          $data["result"] = "No events matched the query";
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
      $this->load->library("upload",$this->upload_config);
      $output = array();
      if($this->upload->do_upload())
      {
        $fInfo = $this->upload->data();
        $has_resized = $this->_create_thumbnail($fInfo['file_name']);
        if($has_resized)
        {
          $result = $this->event->add_file($fInfo);
          if($result !== NULL)
          {
            $output["message"] = "Upload and thumbnail success. File added to DB.";
            $output["raw_name"] = $fInfo["raw_name"];
            $output["file_path"] = $fInfo["file_path"];
            $output["full_path"] = $fInfo["full_path"];
            $output["file_id"] = $result;
            $output["successful"] = TRUE;
            //add to scheduler_event_has
          }
          else
          {
            $output["message"] = "Upload and thumbnail success. File not added to DB.";
            $output["successful"] = FALSE;
          }
          return $output;
        }
        else
        {
          $output["message"] = "Upload successful, thumbnail unsuccessful";
          $output["successful"] = FALSE;
        }
        return $output;
        //$data['uploadInfo'] = $fInfo;
        //$data['thumbnail_name'] = $fInfo['raw_name'].'_thumb'.$fInfo['file_ext'];
        //$data["main_content"] = 'upload_success';
        //load_view($data);
      }else{
        $output["message"] = "Failed to upload file";
        $output["successful"] = FALSE;
        return $output;
        //echo $this->upload->display_errors();
      }
    }

    function _create_thumbnail($fileName)
    {
      $config['image_library'] = 'gd2';
      $config['source_image'] = 'uploads/'.$fileName;
      $config['create_thumb'] = TRUE;
      $config['maintain_ratio'] = TRUE;
      $config['width'] = 75;
      $config['height'] = 75;

      $this->load->library('image_lib', $config);

      //Check if thumbnail was created successfully. If not display errors.
      if($this->image_lib->resize())
      {
        return TRUE;
      }
      else
      {
        return FALSE;
        //$this->image_lib->display_errors();
      }
    }
  }
?>

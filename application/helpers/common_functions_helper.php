<?php
  function load_view($data)
  {
    $CI =& get_instance();
    $CI->load->view("common_views/base",$data);
  }

  function is_gregorian_date($date)
  {

      $year = substr($date,0,4);
      $month = substr($date,5,2);
      $day = substr($date,8,2);
      return checkdate($month,$day,$year);

  }

  function print_array($array)
  {
    echo "<pre>";
    print_r($array);
    echo "</pre>";
  }

?>

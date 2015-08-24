<?php
  function load_view($data)
  {
    $CI =& get_instance();
    $CI->load->view("common_views/base",$data);
  }
?>

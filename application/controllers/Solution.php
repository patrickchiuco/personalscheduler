<?php
  class Solution extends CI_Controller
  {
    var $student_num;
    var $queries;
    var $candies;
    var $students;

    function __construct()
    {
      parent::__construct();
      $this->student_num = 7;
      $this->queries = 9;
      $this->candies = "0 5 10 100 50 0 2";
      $this->students = $this->create_student_array($this->candies);
    }

    function create_student_array($string)
    {
      $buffer = "";
      $result = array();
      for($y = 0; $y < strlen($string); $y++)
      {
        if($string[$y] == " ")
        {
          array_push($result,intval($buffer));
          $buffer = "";
          continue;
        }
        else if($y == (strlen($string) - 1))
        {
          $buffer = $buffer.$string[$y];
          array_push($result, intval($buffer));
        }
        else
        {
          $buffer = $buffer.$string[$y];
        }
      }
      return $result;
    }

    function give($candies, $y, &$array, $student_num)
    {
      if($y == ($student_num-1))
      {
        $array[$y] = $array[$y] + $candies;
        return $array;
      }
      else if($candies == 1)
      {
        $array[$y] = $array[$y] + 1;
        //$array[$y+1] = $array[$y+1] + 1;
        //$array[$y+2] = $array[$y+2] + 1;
        return $array;
      }
      else if($candies % 2 == 0)
      {
        $taken = $candies/2;
        $array[$y] = $array[$y] + $taken;
        //print_array($array);
        //die();
        $remaining = $candies - $taken;
        return $this->give($remaining, $y+1,$array,$student_num);
      }
      else if ($candies % 2 == 1)
      {
        $taken = intval($candies/2) + 1;
        $array[$y] = $array[$y] + $taken;
        $remaining = $candies - $taken;
        return $this->give($remaining, $y+1, $array, $student_num);
      }
    }

    function look($index,$array,$student_num)
    {
      $sum = 0;
      for($x = $index; $x < $student_num; $x = $x + 1)
      {
        $sum = $sum + $array[$x];
      }
      return $sum;
    }

    function show_output()
    {
      $data["result"] = array();
      $data["page_title"] = "Solution Page";
      $data["main_content"] = "solution.php";
      $data["candies"] = $this->students;
      array_push($data["result"],$this->look(4,$this->students,$this->student_num));
      array_push($data["result"],$this->look(7,$this->students,$this->student_num));
      array_push($data["result"],$this->look(2,$this->students,$this->student_num));
      $given1 = $this->give(1,4,$this->students,$this->student_num);
      array_push($data["result"],$this->look(2,$given1,$this->student_num));
      $given2 = $this->give(10,1,$given1,$this->student_num);
      array_push($data["result"],$this->look(2,$given2,$this->student_num));
      $given3 = $this->give(10,5,$given2,$this->student_num);
      array_push($data["result"],$this->look(6,$given3,$this->student_num));
      load_view($data);

    }





        //print_array($given);
        //print_array($students);
        //echo intval(5/2);
        //echo look(2,$students,$student_num);


  }

?>

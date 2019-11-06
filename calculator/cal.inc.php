<?php
ob_start();
include_once "database.php";
$conn = new mysqli(HOST, UNMAE, PASS, DB);
        if ($conn->connect_error) {
            die("connection failed: ".$conn->connect_error);
        } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>age calculator</title>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
 
 
  <style>
      body {
        font-family: 'Times New Roman', Times, serif;
        
      }
      .abt {
      width: 100% !important;
      font-size: 19px;
      
      border-radius:20px;
  }
  .btn1{
      width:30%;
      margin: 0px auto !important;
      
  }
  .btn2 {
    font-size: 17px;
    width:100%;
    border-radius:10px;  
  } 
  .f{
    font-size:19px;
  }

  </style>
</head>
<body>

<?php
function getIp()
{
  if (!empty($_SERVER["REMOTE_ADDR"])) {
    $ip = $_SERVER["REMOTE_ADDR"];
  } else if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
    $ip = $_SERVER["HTTP_CLIENT_IP"];
  } else {
    $ip = $_SERVER["HTTP_X_FORWORDED_FOR"];
  }
  return $ip;
}
$ip = getIp();
?>

<?php
 
        //please check date and month.
        
$dderr=$mmerr=$yyerr= "";
$age = "";
$err = false;

if (isset($_POST["check"])) {
    $dd = $_POST["dd"];
    $mm = $_POST["mm"];
    $yy = $_POST["yy"];

    if ($dd == "Month") {
     $err = true;
     $dderr = "<i>[-] please select your birth month. </i>";
    }
    if ($mm == "Date") {
      $err = true;
      $mmerr = "<i>[-] please select your birth date. </i>";
    }
    if ($yy == "Year") {
      $err = true;
      $yyerr = "<i>[-] please select your birth Year. </i>";
    }

    $dob = $dd."/".$mm."/".$yy;

    $dob_arr = explode("/", $dob);

    $dobT = strtotime($dob);

    $today = strtotime("today");


    $agedays = floor(($today - $dobT) / 86400);
    $ageyear = floor($agedays / 365);
    $agemonths = floor(($agedays-($ageyear * 365)) / 30);

    if (!$err) {
      $age = "


      <div class='alert alert-warning alert-dismissible fade show' role='alert'>
      You are aprox $ageyear years and $agemonths months old.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>
      ";

      $sql = "INSERT INTO DOB(dev_IP, birth_month, birth_date, birth_year)
      VALUES('$ip','$dd', '$mm', '$yy')
      ";
      if ($conn->query($sql) === FALSE) {
       echo "error: ".$conn->error;
      }


    }



}

?>
   

<div class="container mt-5 p-5">

  <form method="POST" class="form">

  <div class="row">

  <div class="col col-md-4 col-sm-4 col-lg-4 col-xs-4">
  <select class="form-control" id="sel1" name="dd">
  <option value="Month">Month</option>

    <?php
    for ($i=1; $i <= 12 ; $i++) { 
       echo "<option value='$i'>$i</option>";
    }
    ?>
  </select>
  <span class="text-danger"><?php echo $dderr;   ?></span>
  </div> 

  <div class="col col-md-4 col-sm-4 col-lg-4 col-xs-4">
  <select class="form-control" id="sel1" name="mm">
  <option value="Date">Date</option>

    <?php
    for ($i=1; $i <= 31 ; $i++) { 
       echo "<option value='$i'>$i</option>";
    }
    ?>
  </select>
  <span class="text-danger"><?php echo $mmerr;   ?></span>

  </div>

  <div class="col col-md-4 col-sm-4 col-lg-4 col-xs-4">
  <select class="form-control" id="sel1" name="yy">
  <option value="Year">Year</option>

    <?php
    for ($i=1900; $i <= 2019 ; $i++) { 
       echo "<option value='$i'>$i</option>";
    }
    ?>
  </select>
  <span class="text-danger"><?php echo $yyerr;   ?></span>

  </div>


  </div><br>
    <div class="btn1"> 
    <button class="btn btn2  btn-success" name="check">Check</button>
    </div>
    </form>

    </div>
    <div class="container text-center">
  
    <?php
    echo $age;
    ?>

    </div>  
</body>
</html>

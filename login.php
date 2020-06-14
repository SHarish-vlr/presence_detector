<?php

include('server.php');

if(isset($_SESSION["type"]))
{
 header("location: index.php");
}
$message = '';

if(isset($_POST["login"]))
{
  if(empty($_POST["user_email"]) || empty($_POST["user_password"]))
  {
    $message = "<label>Both Fields are required</label>";
  }
  else
  {
    $query = "SELECT * FROM user_details WHERE user_email = :user_email";
    $statement = $connect->prepare($query);
    $statement->execute(
      array(
        'user_email' => $_POST["user_email"]
      )
    );
  
  $count = $statement->rowCount();
  if($count > 0)
  {
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
      if(password_verify($_POST["user_password"], $row["user_password"]))
      {
        $insert_query = "INSERT INTO login_details (user_id, last_activity) VALUES (:user_id, :last_activity)";
        $statement = $connect->prepare($insert_query);
        $statement->execute(
          array(
            'user_id'  => $row["user_id"],
            'last_activity' => date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')))
          )
        );

        $login_id = $connect->lastInsertId();
        if(!empty($login_id))
        {
          $_SESSION["type"] = $row["user_type"];
          $_SESSION["login_id"] = $login_id;
          header("location: index.php");
        }
      }
      else
      {
        $message = "<label>Wrong Password</label>";
      }
    }
  }
  else
  {
   $message = "<label>Wrong Email Address</labe>";
  }
 }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Presence service application</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,600">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body id="body" class="background">
          <div class="container">
              <div class="row justify-content-center align-items-center">
                  <div class="col-10 col-md-11 col-lg-6 mt-5 pt-5">
                      <h2>Login</h2>
                      <form class="form-example" method="post">
                          <?php echo $message; ?>
                          <div class="form-group">
                              <label for="username">User Email</label>
                              <input type="text" name="user_email" class="form-control username" />
                          </div>
                          <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="user_password" class="form-control password" />
                          </div>
                          <button type="submit" name="login" value="Login" class="btn btn-info">Submit</button>
                          <p class="description">Not a registered member? <a href="register.php">Register</a></p>
                      </form>
                  </div>
              </div>
          </div>
    </body>
</html>


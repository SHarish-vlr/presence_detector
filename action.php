<?php
include('server.php');
date_default_timezone_set("Asia/Kolkata");
if(isset($_POST["action"]))
{
 if($_POST["action"] == "update_time")
 {
  $query = "UPDATE login_details SET last_activity = :last_activity WHERE login_details_id = :login_details_id";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    'last_activity'  => date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa'))),
    'login_details_id' => $_SESSION["login_id"]
   )
  );
 }
 if($_POST["action"] == "fetch_data")
 {
  $output = '';
  $query = "SELECT login_details.user_id, user_details.user_name, user_details.user_email, user_details.user_image 
  FROM login_details INNER JOIN user_details 
  ON user_details.user_id = login_details.user_id 
  WHERE last_activity > DATE_SUB(NOW(), INTERVAL 5 SECOND) AND user_details.user_type = 'user'";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $count = $statement->rowCount();
  $output .= '<div class="">
                <div class="user_online">
                  <span class="highlight">'.$count.'</span> 
                  Users Online
                </div>
              </div>';
  $i = 0;
  foreach($result as $row)
  {
   $i = $i + 1;
   if($i==1){
    $output .= '
   <div class="vertical-first"> 
    <div class="popup"><span class="popuptext"><b>User ID:</b> '.$row["user_id"].'</br><b>Name:</b> '.$row["user_name"].'</br><b>Email: </b>'.$row["user_email"].'</span><img src="images/icons/'.$row["user_image"].'" class="dp" width="100" height="100"/></div>
   </div>
   ';
   }
   else
   {
    $output .= '
    <div class="vertical"> 
     <div class="popup"><span class="popuptext"><b>User ID:</b> '.$row["user_id"].'</br><b>Name:</b>'.$row["user_name"].'</br><b>Email: </b>'.$row["user_email"].'</span><img src="images/icons/'.$row["user_image"].'" class="dp" width="100" height="100"/></div>
    </div>
    ';
   }
   
  }
  $output .= '</div></div>';
  echo $output;
 }
 ?>
 <div class="mt-5">
 <h3>Page Visit History:</h3>
 <table class="table table-bordered table-striped white">
    <tr>
     <th class="white">No.</th>
     <th class="white">User ID</th>
     <th class="white">Last Activitiy</th>
    </tr>
 
 <?php 
 
 $query_1 = "SELECT * FROM login_details";
 $result_1 = $db->query($query_1);
 while($row_1 = $result_1 -> fetch_assoc()){
   echo "<tr><td>".$row_1["login_details_id"]."</td><td>".$row_1["user_id"]."</td><td>".$row_1["last_activity"]."</td></tr>"; 
 }
 ?>
 </table>
 </div>
 <?php
}

?>
<?php 
    ob_start();
    session_start();

    $PageTitle='Members';

    if (isset($_SESSION['Username'])) { 

    	include 'init.php';

    	$action = isset($_GET['action']) ? $_GET['action'] : 'Manage';
    //start manage page

   $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

    if($action == 'Manage'){

        
?>

 	       <div class="container home-stats text-center">
             <h1>My Questions</h1>
              <div class="row">
                <div class="col-md-6">
                    <div class="stat st-members"><span><a href="myquestion.php?action=pending&userid=<?php echo $userid ?>">answerd</a></span> Questions </div>
                </div>
                <div class="col-md-6">
                    <div class="stat st-pendings" ><span><a  href="myquestion.php?action=quest&userid=<?php echo $userid ?>">Pendings</a></span> Questions </div>
             </div>
             
               
            </div>
           </div>

<?php

  }

elseif ($action=='quest') {

        $query='';

        /*if(isset($_GET['page']) && $_GET['page'] == 'pending') {

            $query='AND answer != null';
        }*/

        
        $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

        $stmt= $con->prepare("SELECT * FROM ques WHERE user_a =? ");

        $stmt  -> execute(array($userid));

        $rows=$stmt->fetchAll();

    ?>
    <h1 class="text-center">My Questions</h1>
    <div class="container">
               <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td class="col-lg-2">#ID</td>
                        <td class="col-lg-4">question</td>
                        <td class="col-lg-2">WhoAsk</td>
                        <td class="col-lg-4">answer</td>
                        <td class="col-lg-2">Control</td>


                   <?php      

                   foreach ($rows as $row) {
                   
                   echo "<tr>";
                     
                     echo "<td>".$row['com_id']."</td>";
                     echo "<td>".$row['question']."</td>";

                     if ($row['boolean']==1){

                        $one=$row['user_q'];

                     $stmt2=$con->prepare("SELECT Username FROM users WHERE UserID=?");

                     
                     $stmt2  -> execute(array($one));

                     $col=$stmt2->fetch();
                     
                     echo "<td>".$col['Username']."</td>";



                 } else
                 {
                    echo "<td>anonymously</td>";
                 }


                     if(!empty($row['answer'])){
                        echo "<td>".$row['answer']."</td>";
                        echo "<td>
                            
                            <a href='myquestion.php?action=delete&comid=".$row['com_id']." 'class='btn btn-danger'><i class='fa fa-close'></i> Delete </a>";
                     echo   "</td>";
                     }

                    else{

                     echo '<td>
                     <form class="form-horizontal" action="?action=update" method="POST">
                         <input type="hidden" name="userid" value="<?php echo $userid ?>" />
                         <input type="hidden" name="comid" value="'.$row['com_id'].'"'.' />';

                        
                      echo  '<input type="text" name="answer"  required="required"  autocomplete="off" />
                     <div class="form-group form-group-lg">
                         <div class="col-sm-offset-2 col-sm-10">
                         <input type="submit" value="update" class="btn btn-sm btn-primary btn-lg" />
                         </div>
                         </div>
                         </td>';
                     echo "<td>
                            
                            <a href='myquestion.php?action=delete&comid=".$row['com_id']." 'class='btn btn-danger'><i class='fa fa-close'></i> Delete </a>";
                         

                     echo   "</td>";            

                    echo'</form>
                    </tr>';
                 }

             }
                    ?>
                    
                </table>
               </div>
    </div>
    <?php
 

}

elseif ($action=='update') {
    

            echo "<h1 class='text-center'> Update Page </h1>";
            echo "<div class='container'>";

                   if($_SERVER['REQUEST_METHOD'] == 'POST') {

                        $id        = $_POST['userid'];
                        $answer    = $_POST['answer'];
                        $comid     = $_POST['comid'];

                        
                        
             $formErrors = array();

             if(empty($answer)){
                $formErrors[] = '<div class="alert alert-danger">answer cant be <strong> empty </strong></div>';
             }
             
             foreach ($formErrors as $error) {
                echo $error;
             }

                                            // Update Data Base
        if(empty($formErrors))  {

                
            /* $stmt = $con->prepare("INSERT INTO ques(answer = ? ) VALUES (:zanswer)");

               $stmt->execute(array('zanswer'=>$answer));*/

              $stmt = $con->prepare("UPDATE ques SET answer = ?  WHERE com_id=?");

              $stmt->execute(array($answer,$comid));
                            
             $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount(). ' Recored Updated </div>';
              redirectHome($theMsg);
            }
            
           else {

               $errorMsg= "<div class='alert alert-danger'> you cant browse this page dirctely </div>";

               redirectHome($errorMsg,'back');
         }  

              echo "</div>";
            
        }

}

elseif ($action=='pending') {

        $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

        $stmt= $con->prepare("SELECT * FROM ques WHERE user_a =? AND answer!='null'");

        $stmt  -> execute(array($userid));

        $rows=$stmt->fetchAll();

    ?>
    <h1 class="text-center">My Questions</h1>
    <div class="container">
               <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td class="col-lg-4">#ID</td>
                        <td class="col-lg-4">Question</td>
                        <td class="col-lg-4">Answers</td>
                   <?php 

                    foreach ($rows as $row) {
                   
                   echo "<tr>";
                     
                     echo "<td>".$row['com_id']."</td>";
                     echo "<td>".$row['question']."</td>";
                     echo "<td>".$row['answer']."</td>";
                     echo '<td>
                     <form class="form-horizontal" action="?action=update" method="POST">
                         <input type="hidden" name="userid" value="<?php echo $userid ?>" />
                         <input type="hidden" name="comid" value="'.$row['com_id'].'"'.' />
                     </form>';

                     echo "</tr>";
                 }
                    ?>
                    
                </table>
               </div>
    </div>
    <?php



 /**/

}

elseif ($action =='appear'){

  

    $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

        $stmt= $con->prepare("SELECT * FROM ques WHERE user_q =? AND answer!='null'");

        $stmt  -> execute(array($userid));

        $rows=$stmt->fetchAll();

    ?>
    <h1 class="text-center">My Answers Of My Questions</h1>
    <div class="container">
               <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td class="col-lg-4">#ID</td>
                        <td class="col-lg-4">question</td>
                        <td class="col-lg-4">answers</td>
                        


                   <?php 

                    foreach ($rows as $row) {
                   
                   echo "<tr>";
                     
                     echo "<td>".$row['com_id']."</td>";
                     echo "<td>".$row['question']."</td>";
                     echo "<td>".$row['answer']."</td>";
                     echo '<td>
                     <form class="form-horizontal" action="?action=update" method="POST">
                         <input type="hidden" name="userid" value="<?php echo $userid ?>" />
                         <input type="hidden" name="comid" value="'.$row['com_id'].'"'.' />
                     </form>';

                     echo "</tr>";
                 }
                    ?>
                    
                </table>
               </div>
    </div>
    <?php

}

elseif ($action =='delete'){


         echo "<h1 class='text-center'> Deleted Page </h1>";
         echo "<div class='container'>";

        $comid=isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) :0;
        
        $check=1;/*checkItem('com_id','ques',$userid);*/
        

       if ($check>0){
                
            
             $stmt =$con->prepare("DELETE FROM ques WHERE com_id= :zuser");
             $stmt ->bindParam(":zuser",$comid);
             $stmt ->execute();

             
                $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount(). ' Recored Deleted </div>';
                redirectHome($theMsg);
                   }   
   else {

            $theMsg= "<div class='alert alert-danger'> There Is No Such ID </div>";
            redirectHome($theMsg,'back');

       } 
   }



/*  elseif ($action='activate') {

     echo "<h1 class='text-center'> Actived Page </h1>";
         echo "<div class='container'>";

        $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;
        
        $check=checkItem('userid','users',$userid);
        

       if ($check>0){
                
             echo 'this id is exsist';

             $stmt =$con->prepare("UPDATE users SET RegStatus=1 WHERE UserID=?");
             
             $stmt->execute(array($userid));

             
                $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount(). ' Recored activated </div>';
                redirectHome($theMsg);
  }   else {

            $theMsg= "<div class='alert alert-danger'> There Is No Such ID </div>";
            redirectHome($theMsg,'back');

  }

  echo '</div>';
}
*/
    include $tpl .'footer.php';

    }

    else {
            header('Location: index.php');
            exit();
    }
    ob_end_flush();

    ?>
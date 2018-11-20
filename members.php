<?php 
    ob_start();
    session_start();

    $PageTitle='Members';

    if (isset($_SESSION['Username'])) { 

    	include 'init.php';

    	$action = isset($_GET['action']) ? $_GET['action'] : 'Manage';
    //start manage page

    if($action == 'Manage'){


    	$query='';

    	if(isset($_GET['page']) && $_GET['page'] == 'pending') {

    		$query='AND RegStatus = 0';
    	}

    	$userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

    	$stmt= $con->prepare("SELECT *FROM users WHERE GroupID =1 $query");

    	$stmt->execute();

    	$rows=$stmt->fetchAll();

      $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

    ?>
    <h1 class="text-center">Manage Members</h1>
    <div class="container">
    	       <div class="table-responsive">
    	       	<table class="main-table text-center table table-bordered">
    	       		<tr>
    	       			<td>#ID</td>
    	       			<td>Username</td>
    	       			<td>Email</td>
    	       			<td>FullName</td>
    	       			<td>Registerd Date</td>
    	       			<td>Control</td>
                  <td>id of asks</td>
    	       		</tr>




                   <?php
                  

                   foreach ($rows as $row) {

                   echo "<tr>";
                     
                     echo "<td>".$row['UserID']."</td>";
                     echo "<td>".$row['Username']."</td>";
                     echo "<td>".$row['Email']."</td>";
                     echo "<td>".$row['FullName']."</td>";
                     echo "<td>".$row['Date']."</td>";
                     echo "<td>
                    <a href='members.php?action=ask&userid=".$row['UserID']." 'class='btn btn-info'><i class='fa fa-edit'></i> ask question </a> ";
                    
    	       		 echo	"</td>";
                 echo "<td>".$userid."</td>";
                   echo "</tr>";

                   }

                

                    ?>
    	       		
    	       	</table>
    	       </div>
               <a href="members.php?action=add" class="btn btn-primary"><i class="fa fa-plus"></i> add new Members</a>
    </div>
    <?php
 

  }

  elseif ($action =='ask') {

$userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;
   ?>

       <div class="container">
       <div class="form-group form-group-lg">
        <form class="form-horizontal" action="?action=sendask" method="POST">
                     <input type="hidden" name="userid" value="<?php echo $userid ?>" />
                     <label class="col-sm-2 control-label">QUESTION</label>
                     <div class="col-sm-10 col-md-4">
                   <input type="text" name="ask" class="form-control" />
                     </div>
                </div>

               
                     <label class="col-sm-2 control-label">Visible</label>
                     <div class="col-sm-10  col-md-4">
                      <select class="form-control" name="status">
                        
                        <option value="1">Visible </option>
                        <option value="0">hidden</option>
                       
                      </select>
                     </div>
            
    
      <div class="form-group form-group-lg">
                     <div class="col-sm-offset-2 col-sm-10">
                   <input type="submit" value="ask" class="btn btn-primary btn-lg" />
                     </div>
                     </div>
                     </form>
                </div> 
                </div> 
<?php
  }
  elseif ($action =='sendask') {

     if($_SERVER['REQUEST_METHOD'] == 'POST') {

           echo "<h1 class='text-center'> Ask User A QUESTION </h1>";
           echo "<div class='container'>";

            $userid = $_POST['userid'];

            $ques   = $_POST['ask'];

            $user_q = $_SESSION['ID'];

            $bool = $_POST['status'];

           $formErrors = array();

           if(empty($ques)){
            $formErrors[] = 'Username Cant Be  <strong> Empty </strong>';
           }
             
                       //insert into database

                if(empty($formErrors)) {


              $stmt = $con->prepare("INSERT INTO ques (question ,user_a,user_q, boolean ) VALUES(:zques, :zuser_a,:zuser_q,:zbollean )");

                    $stmt->execute(array(

                    'zques'    => $ques,
                    'zuser_a'  => $userid,
                    'zuser_q'  => $user_q, 
                    'zbollean' => $bool

                  ));
              
              
               
                            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount(). ' Recored Updated </div>';

                            redirectHome($theMsg);

                         }   }
                        
                        

                        else{
                            echo "<div class='continer'>"; 
                          $errorMsg= "<div class='alert alert-danger'> you cant browse this page dirctely </div>";

                          redirectHome($errorMsg);

                          echo '</div>';
              } 
                    echo "</div>";

  }

  elseif ($action =='add') {

    	?>
		     <h1 class="text-center">add new member</h1>
		       <div class="container">
		         <form class="form-horizontal" action="?action=insert" method="POST">
		             <div class="form-group form-group-lg">
		           	     <label class="col-sm-2 control-label">Username</label>
		                 <div class="col-sm-10 col-md-4">
		             	 <input type="text" name="username"  class="form-control" autocomplete="off"/>
		                 </div>
		           </div>

		           <div class="form-group form-group-lg">
		           	     <label class="col-sm-2 control-label">Password</label>
		                 <div class="col-sm-10 col-md-4">	
		             	 <input  type="password" name="password" class="password form-control" autocomplete="new-password" />
		             	 <i class="show-pass fa fa-eye fa-2x"></i>
		                 </div>
		           </div>
		           
		            <div class="form-group form-group-lg">
		           	     <label class="col-sm-2 control-label">Email</label>
		                 <div class="col-sm-10 col-md-4">
		             	 <input type="email" name="Email" class="form-control" />
		                 </div>
		            </div>
		            
		             <div class="form-group form-group-lg">
		           	     <label class="col-sm-2 control-label">FullName</label>
		                 <div class="col-sm-10  col-md-4">
		             	 <input type="text" name="full" class="form-control"  />
		                 </div>
		           </div>

		            <div class="form-group form-group-lg">
		                 <div class="col-sm-offset-2 col-sm-10">
		             	 <input type="submit" value="Add New Member" class="btn btn-primary btn-lg" />
		                 </div>
		                 </div>
		                 </form>
		            </div>  	 
					<?php 
				} 

			elseif ($action == 'insert') {

                   

			   if($_SERVER['REQUEST_METHOD'] == 'POST') {

			   	 echo "<h1 class='text-center'> Update Page </h1>";
   		         echo "<div class='container'>";

				   	
				   	$user    = $_POST['username'];
				   	$pass    = $_POST['password'];
				   	$email   = $_POST['Email'];
				   	$name    = $_POST['full'];

				   	$hashpass =sha1($_POST['password']);

				   	 $formErrors = array();

                    	 if(strlen($user) < 4){
                    	 	$formErrors[] = 'Username Cant Be Less Than <strong> 4 char </strong>';
                    	 }
                    	 if(strlen($user) >  20){
                    	 	$formErrors[] = 'UserName Cant Be More Than <strong> 20 char </strong>';
                    	 }
                    	 if(empty($user)){
                    	 	$formErrors[] = 'User Cant Be <strong> empty </strong>';
                    	 }
                    	 if(empty($pass)){
                    	 	$formErrors[] = 'Password Cant Be <strong> empty </strong>';
                    	 }
                    	 if(empty($name)){
                    	 	$formErrors[] = 'Fullname Cant Be <strong> empty </strong>';
                    	 }
                    	 if(empty($email)){
                    	 	$formErrors[] = 'Email Cant Be  <strong> Empty </strong>';
                    	 }
                    	 
                    	 foreach ($formErrors as $error) {
                    	 	echo '<div class="alert alert-danger">' .$error. '</div>';
                    	 }
                    	 //insert into database

                    	 if(empty($formErrors))	{

                    	 	$check=checkItem('Username','users',$user);

                    	 	if($check == 1){ echo 'this user is exist'; }
							
							else {
							$stmt = $con->prepare("INSERT INTO users(Username , password ,Email , FullName ,RegStatus, Date) VALUES(:zuser, :zpass, :zmail, :zname,1 ,now()) ");
                            $stmt->execute(array(

                            	'zuser'=> $user,
					        	'zpass'=> $hashpass,
					        	'zmail'=> $email,
					        	'zname'=> $name 

					        ));
							
					    
               
                            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount(). ' Recored Updated </div>';

                            redirectHome($theMsg);

                            }

                        }
                        
                        }

                        else{
                            echo "<div class='continer'>"; 
                        	$errorMsg= "<div class='alert alert-danger'> you cant browse this page dirctely </div>";

                        	redirectHome($errorMsg);

                        	echo '</div>';
					    }	
	                  echo "</div>";
						}	


    	elseif ($action == 'edit') {
    	#Edit Page
    	$userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

        $stmt  = $con->prepare("SELECT * FROM  users WHERE UserID =  ? lIMIT   1");
        $stmt  -> execute(array($userid));
        $row   = $stmt->fetch();
        $count = $stmt->rowCount();

       if ($stmt->rowCount()>0){?>

         

		     <h1 class="text-center">Edit Member</h1>
		       <div class="container">
		         <form class="form-horizontal" action="?action=update" method="POST">
		         	<input type="hidden" name="userid" value="<?php echo $userid ?>" />
		             <div class="form-group form-group-lg">
		           	     <label class="col-sm-2 control-label">Username</label>
		                 <div class="col-sm-10 col-md-4">
		             	 <input type="text" name="username" required="required" class="form-control" autocomplete="off" value="<?php echo $row['Username']; ?>"/>
		                 </div>
		           </div>

		           <div class="form-group form-group-lg">
		           	     <label class="col-sm-2 control-label">Password</label>
		                 <div class="col-sm-10 col-md-4">
		                 <input type="hidden" name="oldpassword" value="<?php echo $row['password'] ?>" />	
		             	 <input type="password" name="newpassword" class="form-control" autocomplete="new-password" />
		                 </div>
		           </div>
		           
		            <div class="form-group form-group-lg">
		           	     <label class="col-sm-2 control-label">Email</label>
		                 <div class="col-sm-10 col-md-4">
		             	 <input type="email" name="Email" class="form-control" required="required" value="<?php echo $row['Email']; ?>" />
		                 </div>
		            </div>
		            
		             <div class="form-group form-group-lg">
		           	     <label class="col-sm-2 control-label">FullName</label>
		                 <div class="col-sm-10  col-md-4">
		             	 <input type="text" name="full" class="form-control" required="required" value="<?php echo $row['FullName']; ?>" />
		                 </div>
		           </div>

		            <div class="form-group form-group-lg">
		                 <div class="col-sm-offset-2 col-sm-10">
		             	 <input type="submit" value="update" class="btn btn-primary btn-lg" />
		                 </div>
		                 </div>
		                 </form>
		            </div>  	 
					<?php 
				    } else {
                        echo "<div class='container'>";

						$theMsg= "<div class='alert alert-danger'> There Is No Such ID </div>";
						redirectHome($theMsg,'back');

						echo "</div>";
					}

    }
    

	elseif ($action == 'update') {

	   		echo "<h1 class='text-center'> Update Page </h1>";
	   		echo "<div class='container'>";

				   if($_SERVER['REQUEST_METHOD'] == 'POST') {

					   	$id      = $_POST['userid'];
					   	$user    = $_POST['username'];
					   	$email   = $_POST['Email'];
					   	$name    = $_POST['full'];
	                      
	                    $pass = '';


        	 $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
        	 $formErrors = array();

        	 if(strlen($user) < 4){
        	 	$formErrors[] = '<div class="alert alert-danger">username cant be less than <strong> 4 char </strong></div>';
        	 }
        	 if(strlen($user) >  20){
        	 	$formErrors[] = '<div class="alert alert-danger">username cant be more than <strong> 20 char </strong></div>';
        	 }
        	 if(empty($user)){
        	 	$formErrors[] = '<div class="alert alert-danger">user cant be <strong> empty </strong></div>';
        	 }
        	 if(empty($name)){
        	 	$formErrors[] = '<div class="alert alert-danger">name cant be <strong> empty </strong></div>';
        	 }
        	 if(empty($email)){
        	 	$formErrors[] = '<div class="alert alert-danger">email cant be  <strong> empty </strong></div>';
        	 }
        	 
        	 foreach ($formErrors as $error) {
        	 	echo $error;
        	 }

										   	// Update Data Base
			if(empty($formErrors))	{

        $stmt2 = $con->prepare("SELECT * FROM users WHERE Username= ?,UserID!=?");

        $stmt2->execute(array($user,$id));
                
        $count =$stmt->rowCount();
        
        if($count ==1){

          echo "this USER IS exist";

        }

        else{
				echo "update";
				// $stmt = $con->prepare("UPDATE users SET Username = ? , Email = ? , FullName = ? WHERE UserID=?");
				// $stmt->execute(array($user,$email,$name,$id));
		                    
		                    
    //             $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount(). ' Recored Updated </div>';
    //             redirectHome($theMsg);
            }}
	        
	       else {

		       $errorMsg= "<div class='alert alert-danger'> you cant browse this page dirctely </div>";

               redirectHome($errorMsg,'back');
		 }	

              echo "</div>";
			
		}}

    elseif ($action =='delete'){


     	 echo "<h1 class='text-center'> Deleted Page </h1>";
         echo "<div class='container'>";



     	$userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;
        
        $check=checkItem('userid','users',$userid);
        

       if ($check>0){
                
            
             $stmt =$con->prepare("DELETE FROM users WHERE UserID= :zuser");
             $stmt ->bindParam(":zuser",$userid);
             $stmt ->execute();

             
                $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount(). ' Recored Deleted </div>';
                redirectHome($theMsg);
                   }   
   else {

  	        $theMsg= "<div class='alert alert-danger'> There Is No Such ID </div>";
            redirectHome($theMsg,'back');

       } 
   }

  elseif ($action='activate') {
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


                                        

    	include $tpl .'footer.php';

    } 

    else {
            header('Location: index.php');
            exit();
    }
    ob_end_flush();

    ?>
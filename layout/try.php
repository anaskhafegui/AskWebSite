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
                        <td class="col-lg-2">#ID</td>
                        <td class="col-lg-4">question</td>
                        <td class="col-lg-4">answer</td>
                        <td>Control</td>


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

                         
                     <div class="form-group form-group-lg">
                         <div class="col-sm-offset-2 col-sm-10">
                         <input type="submit" value="update" class="btn btn-sm btn-primary btn-lg" />
                         </div>
                         </div>
                         
                       

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
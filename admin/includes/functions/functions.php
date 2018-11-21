<?php

 function gettitle(){
      
      global $PageTitle;

      if(isset($PageTitle)){

       echo $PageTitle;

      } else {

	       echo 'default';
             }

    }  

    function redirectHome($errorMsg,$url=null , $seconds =3 ){
  
    if($url === null) {

       $url ='index.php';
    }
    else{
    

      $url = isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER'])!=='' ? $_SERVER['HTTP_REFERER']: $url='index.php';

    
    }

    	echo $errorMsg;

    	echo "<div class='alert alert-info'> your will be redirected after $seconds seconds </div>";

    	header("refresh:$seconds;url=$url");
    	
    	exit();
    
    }

   function checkItem($select,$from,$value){

    global $con;

    $statement = $con ->prepare("SELECT $select FROM $from WHERE $select =?");
   $statement->execute(array($value));

   $count = $statement->rowCount();

   return $count;
  }
   
function countItems($item,$table){


 global $con;

 $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
 
 $stmt2 ->execute();

 return $stmt2->fetchColumn();

}

function getLatest($select ,$table ,$order ,$limit=5 ){

  global $con;

  $getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
  $getstmt->execute();

  $rows=$getstmt->fetchAll();

  return $rows;
}


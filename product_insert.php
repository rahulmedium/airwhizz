<?php
error_reporting('0');
//We start our transaction.
include 'config/config.php';
try {
   
	$conn->beginTransaction();

    // prepare sql and bind parameters
    $stmt = $conn->prepare("CALL insert_product(?,?,?)");
    $cat_id=$_POST['cat_id'];
   $cat_name = $_POST['cat_name'];
   $cat_discription=$_POST['cat_discription'];
    $stmt->bindParam(1, intval($cat_id), PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    $stmt->bindParam(2, $cat_name, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    $stmt->bindParam(3, $cat_discription, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
   
     $result=$stmt->execute();
   
	if(!empty($result)){
		 echo "You Have Successfuly insert product";
	}else{
		echo "Duplicate Entery! Please insert diffrent category";
	}

 $conn->commit(); 

   
    }
catch(PDOException $e)
    {
		$conn->rollBack();
   // echo "Error: " . $e->getMessage();
    }
$conn = null;
?>

<?php
error_reporting(0);
//We start our transaction.
include 'config/config.php';
try {
   $conn->beginTransaction();
   // prepare sql and bind parameters
    $stmt = $conn->prepare("CALL category_update(?,?,?)");
    $value1 = $_POST['id'];
    $value2 = $_POST['cat_name'];
    $value3 = $_POST['cat_desc'];
    $stmt->bindParam(1, intval($value1), PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    $stmt->bindParam(2, $value2, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    $stmt->bindParam(3, $value3, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    

    // insert a row
    //$cat_name = $_POST['cat_name'];
   
    $result=$stmt->execute();
	if($result){
		 echo "You Have Successfully Updated";
	}else{
		echo "error";
	}

 $conn->commit(); 

   
    }
catch(PDOException $e)
    {
		$conn->rollBack();
    echo "Error: " . $e->getMessage();
    }
$conn = null;
?>

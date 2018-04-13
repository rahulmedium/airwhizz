<?php
//We start our transaction.
include 'config/config.php';
try {
   
	$conn->beginTransaction();

    // prepare sql and bind parameters
    $stmt = $conn->prepare("CALL delete_product(?)");
    $value = $_POST['id'];
	$stmt->bindParam(1, intval($value), PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    

    // insert a row
    //$cat_name = $_POST['cat_name'];
   
    $result=$stmt->execute();
	if($result){
		 echo "yes";
	}else{
		echo "category exist in database";
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

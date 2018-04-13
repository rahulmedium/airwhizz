<?php
//We start our transaction.
include 'config/config.php';
try {
   
	$conn->beginTransaction();

    // prepare sql and bind parameters
   $stmt = $conn->prepare("CALL category_insert(?,?)");
   $cat_name = trim($_POST['cat_name']);
   $cat_discription=$_POST['cat_discription'];
   $stmt->bindParam(1, $cat_name, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    $stmt->bindParam(2, $cat_discription, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    

    // insert a row
    $cat_name = $_POST['cat_name'];
    $cat_discription=$_POST['cat_discription'];
    $result=$stmt->execute();
    
	if($result){
		 echo "You Have Successfuly insert category";
	}else{
		echo "Duplicate Entery! Please insert diffrent category";
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

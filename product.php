<html>
    <title></title>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src=" https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="  https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

        <style>
            .no-sort::after { display: none!important; }

            .no-sort { pointer-events: none!important; cursor: default!important; }
        </style>
        <!------ Include the above in your HEAD tag ---------->
    </head>
    <body>
        <?php
        include 'config/config.php';
        $stmt = $conn->prepare("CALL get_cat_all()");
        $stmt->execute();
        $res = $stmt->fetchALL(PDO::FETCH_OBJ);

        ?>
        <div class="container">
            <h2>List of Product</h2>
            <!-- Trigger the modal with a button -->
            <a href="index.php"class="btn btn-info btn-lg">Back</a>
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">+ New Product</button>


            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">

                        <div class="modal-body">
                            <h4 class="page-header">Add Product</h4>
                            <form role="form" id="cat">
                                <div class="form-group float-label-control">
                                    <label for="">Product Name</label>
                                    <input type="text" class="form-control" name="cat_name" placeholder="Enter Product Name" required>
                                </div>
                                <div class="form-group float-label-control">
                                    <label for="">Select Category</label>
                                    <select class="form-control" name="cat_id">
                                        <option>Choose Category</option>
                <?php $i = 1; foreach ($res as $value) { ?>
                                            <option value="<?php echo $value->cat_id; ?>"><?php echo $value->cat_name; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                                <div class="form-group float-label-control">
                                    <label for="">Product Description</label>
                                    <Textarea  class="form-control" name="cat_discription" placeholder="Enter Poduct Description" required></textarea>
                    </div>
                    <input type="submit" value="submit">
                </form>
      </div>
      <div class="modal-footer">
      
      </div>
    </div>

  </div>
</div>
        
       

        <hr />

        <div class="row">
            <div class="col-sm-12">

               

	<table class="table" id="example">
    <thead>
      <tr>
      
        <th>Product Name</th>
         <th>Category Name</th>
         <th>Product Description</th>
          <th class="no-sort">Action</th>
        
      </tr>
    </thead>
    <tbody>
           <?php 
           // Fetch all product
        $stmt = $conn->prepare("CALL get_product_all()");
        $stmt->execute();
        $product_result = $stmt->fetchALL(PDO::FETCH_OBJ);
                 foreach ($product_result as $valuep) { ?>
          <tr>
           
            <td><?php echo $valuep->p_name; ?></td>
                                    <?php
                                    //get category name
                                    $stmt = $conn->prepare("CALL get_category_name($valuep->cat_id)");
                                    $stmt->execute();
                                    $cat_name = $stmt->fetchALL(PDO::FETCH_OBJ);
                                    // print_r($cat_name);
                                    ?>
            <td><?php echo $cat_name[0]->cat_name ?></td>
            <td><?php echo $valuep->p_description; ?></td>
            <td><a href="" class="btn btn-success" data-toggle="modal" data-target="#myModal<?php echo $valuep->p_id; ?> ">Edit</a>/<a href="" class="btn btn-danger" onclick='delte_cat("<?php echo $valuep->p_id; ?>")'>Delete</a></td>
          </tr>
    	  <!-- Modal -->
            <div id="myModal<?php echo $valuep->p_id; ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">

                        <div class="modal-body">
                            <h4 class="page-header">Add Product</h4>
                            <form role="form" id="pup<?php echo $valuep->p_id; ?>">
                                <input type="hidden" name="id" value="<?php echo $valuep->p_id; ?> ">
                                <div class="form-group float-label-control">
                                    <label for="">Product Name</label>
                                    <input type="text" class="form-control" name="cat_name" placeholder="Enter Product Name" value="<?php echo $valuep->p_name; ?>" required>
                                </div>
                                <div class="form-group float-label-control">
                                    <label for="">Select Category</label>
                                    <select class="form-control" name="cat_id">
                                   
            
                                        <option value="<?php echo $valuep->cat_id; ?>"><?php echo $cat_name[0]->cat_name ?></option>
                <?php $i = 1; foreach ($res as $value) { ?>
                                            <option value="<?php echo $value->cat_id; ?>"><?php echo $value->cat_name; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                                <div class="form-group float-label-control">
                                    <label for="">Product Description</label>
                                    <Textarea  class="form-control" name="cat_discription" placeholder="Enter Poduct Description" required><?php echo $valuep->p_description; ?></textarea>
                    </div>
                    <input type="submit" value="Update">
                </form>
      </div>
      <div class="modal-footer">
      
      </div>
    </div>

  </div>
</div>
         	<script>

                                $(function () {
                                    $('.modal-body').on('submit', '#pup<?php echo $valuep->p_id; ?>', function (e) {
                                      //  alert('hii');
                                        e.preventDefault();

                                        //$("#login").html('Please Wait <i class="fa fa-spinner fa-pulse fa-1x fa-fw margin-bottom"></i>');
                                        //var info = 'email=' + email + '&pass=' + pass
                                        $.ajax({
                                            type: "POST",
                                            url: "edit_product.php",
                                            data: $('#pup<?php echo $valuep->p_id; ?>').serialize(),
                                            success: function (data) {
                                                alert(data);
                                                location.reload();
                                                if ($.trim(data) === "yes") {
                                                    // window.location.href = "users.php";
                                                } else {
                                                    $("#sbcrbmsg").text(" Someone already registered with this email id. Try another email id").css("color", "red");
                                                    $('#users')[0].reset();

                                                }
                                            }
                                        });


                                    });
                                });

                    </script>   
                            <?php $i++;
                        } ?>
	</tbody>
  </table>
   
                


                

            </div>
        
		
	
   </div>
</div>
<script>
            $(document).ready(function () {
                $('#example1').dataTable({
                    "columnDefs": [{
                            "targets": 'no-sort',
                            "orderable": false,
                        }]
                });
            });
            function delte_cat(id) {

                if (confirm('Are you sure you want to delete this product?')) {

                    var id1 = $("#ac").val();

                    $.ajax({
                        url: 'product_delete.php',
                        data: {id: id},
                        type: "POST",
                        success: function (data) {
                            location.reload();

                        }
                    });
                }
            }

            $(function () {

                $("#cat").submit(function (e) {
                    e.preventDefault();

                    $.ajax({
                        type: "POST",
                        url: "product_insert.php",
                        data: $('#cat').serialize(),
                        success: function (data) {
                            alert(data);
                           // location.reload();
                        }
                    });


                });
            });
        </script>
</body>
</html>
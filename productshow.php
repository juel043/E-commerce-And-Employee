<?php   
 //index.php  
 $connect = mysqli_connect("localhost", "root", "", "zzz"); 
  
 function fill_brand($take_connection)  
 {  
      $output = '';  
      $sql = "SELECT * FROM brand";  
      $result = mysqli_query($take_connection, $sql);  
      while($row = mysqli_fetch_array($result))  
      {  
         
           $output .= '<option class="text-center" value="'.$row["brand_id"].'">'.$row["brand_name"].'</option>';  
      }  
      return $output;  
 }  
 function fill_product($take_connection)  
 {  
      $output = '';  
      $sql = "SELECT * FROM product";  
      $result = mysqli_query($take_connection, $sql);  
      while($row = mysqli_fetch_array($result))  
      {  
        
         $output .= '<div class="col-md-3">';  
           $output .= '<div style="border:1px solid #ccc; padding:20px; margin-bottom:10px;">';
           $output .= '<p class="text-center text-dark p-2 mb-2">';
           $output .=' Name: ' .$row["p_name"]." " ;
           $output .='</p>';
           $output .= '<p class="text-center text-dark p-2 mb-2">';
           $output .=' Model: ' .$row["p_model"]." " ;
           $output .='</p>';
           $output .= '<div align="center" class="mb-2">';
           $output .= '<img src="user_images/'.$row["p_pic"].' " height="150" width="150" />' ;
           $output .=  '</div>';
            $output .= '<p class="text-center text-dark p-2 mb-2">';
           $output .=' Price: ' .$row["p_price"]." " ;
           $output .='</p>';
           $output .=     '</div>';  
           $output .=     '</div>';  
        
      }  
      return $output;  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Load Records</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <style type="text/css">
             p{
        font-family: bold ;
        font-size: 15px;
      }
     body{
      margin: 0px;
      padding: 0px;
     } 
           </style>
      </head>  
      <body>  

        <div align="center" class="  bg-primary">
            <h1 class="text-center  text-dark">All Product list </h1>
        </div>
         <div align="center" >
          <a href="home.php " class="btn btn-success text-center mr-2">Home</a>
            <a href="addproductitem.php " class="btn btn-success text-center">Add Product</a>
          </div> 
           <div class="container">  
                <h3> 
                <div align="center">
                     <select name="brand" id="brand">  
                          <option value="">Show All Product</option>  
                          <?php echo fill_brand($connect); ?>  
                     </select>  
                     </div> 
                     <br /><br />  
                     <div class="row" id="show_product">  
                          <?php echo fill_product($connect);?>  
                     </div>  
                </h3>  
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function()
 {  
      $('#brand').change(function()
      {  
           var brand_id = $(this).val();  
           $.ajax({  
                url:"load_data.php",  
                method:"POST",  
                data:{brand_id:brand_id},  
                success:function(data)
                {  
                     $('#show_product').html(data);  
                }  
           });  
      });  
 });  
 </script>  
<?php  
 //load_data.php  
 $connect = mysqli_connect("localhost", "root", "", "zzz");  
 $output = '';  
 if(isset($_POST["brand_id"]))  
 {  
      if($_POST["brand_id"] != '')  
      {  
           $sql = "SELECT * FROM product WHERE brand_id = '".$_POST["brand_id"]."'";  
      }  
      else  
      {  
           $sql = "SELECT * FROM product";  
      }  
      $result = mysqli_query($connect, $sql); 
       
      while($row = mysqli_fetch_array($result))  
      {  
        ?>
        <?php
          $output .= '<div class="col-md-3">';  
           $output .= '<div style="border:1px solid #ccc; padding:20px; margin-bottom:20px;">';
           $output .= '<p class="text-center text-dark p-2 m-2">';
           $output .=' Name: ' .$row["p_name"]." " ;
           $output .='</p>';
           $output .= '<p class="text-center text-dark p-2 m-2">';
           $output .=' Model: ' .$row["p_model"]." " ;
           $output .='</p>';
           $output .= '<div align="center">';
           $output .= '<img src="user_images/'.$row["p_pic"].' " height="150" width="150" />' ;
           $output .=  '</div>';
            $output .= '<p class="text-center text-dark p-2 m-2">';
           $output .=' Price: ' .$row["p_price"]." " ;
           $output .='</p>';
           $output .=     '</div>';  
           $output .=     '</div>';  
      }  
      echo $output;  
 }  
 ?>  
 <!DOCTYPE html>
 <html>
 <head>
   <title>showproduct</title>

   <style type="text/css">
     p{
        font-family: bold ;
        font-size: 15px;
      }
   </style>
 </head>
 <body>
 
 </body>
 </html>
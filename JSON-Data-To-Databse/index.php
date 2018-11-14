<?php  
 $message = '';  
 $error = '';  
 if(isset($_POST["submit"]))  
 {  
      if(empty($_POST["f_name"]))  
      {  
           $error = "<label class='text-danger'>Enter 1st name</label>";  
      }  
      else if(empty($_POST["l_name"]))  
      {  
           $error = "<label class='text-danger'>Enter Last name</label>";  
      }  
      else if(empty($_POST["section"]))  
      {  
           $error = "<label class='text-danger'>Enter Section</label>";  
      }  
      else  
      {  
           if(file_exists('employee_data.json'))  
           {  
                $current_data = file_get_contents('employee_data.json');  
                $array_data = json_decode($current_data, true);  
                $extra = array(  
                     'f_name'               =>     $_POST['f_name'],  
                     'l_name'          =>     $_POST["l_name"],  
                     'section'     =>     $_POST["section"]  
                );  
                $array_data[] = $extra;  
                $final_data = json_encode($array_data);  
                if(file_put_contents('employee_data.json', $final_data))  
                {  
                     $message = "<label class='text-success'>Write Your Data Within JSON File Success fully</p>";  
                }  
           }  
           else  
           {  
                $error = 'JSON File not exits';  
           }  
      }  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>JSON</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br />  
           <div class="container" style="width:500px;">  
                <h3 align="">JSON Project</h3><br />                 
                <form method="post">  
                     <?php   
                     if(isset($error))  
                     {  
                          echo $error;  
                     }  
                     ?>  
                     <br />  
                     <label>First Name</label>  
                     <input type="text" name="f_name" class="form-control" /><br />  
                     <label>Last Name</label>  
                     <input type="text" name="l_name" class="form-control" /><br />  
                     <label>Section</label>  
                     <input type="text" name="section" class="form-control" /><br />  
                     <input type="submit" name="submit" value="Send" class="btn btn-info" /><br />                      
                     <?php  
                     if(isset($message))  
                     {  
                          echo $message;  
                     }  
                     ?>  
                </form>  
           </div>  
           <br />  
      </body>  
 </html>
<?php
function __autoload($class){
 include_once($class.".php");
}
 $obj_class=new Query;
if(isset($_POST['submit']))
{
	$f_name = trim($_POST['f_name']);
	$l_name = trim($_POST['l_name']);
	$section = trim($_POST['section']);
	
	$stmt = $obj_class->runQuery("SELECT * FROM students WHERE f_name=:f_name");
	$stmt->execute(array(":f_name"=>$f_name));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() > 0)
	{
		$msg = "
		      <div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Sorry !</strong>  data allready exists , Please Try another one
			  </div>
			  ";
	}
	else
	{
		if($obj_class->InsertData($f_name,$l_name,$section))
		{			
			$id = $obj_class->lasdID();		
			$key = base64_encode($id);
			$id = $key;
				
			$msg = "
					<div class='alert alert-success'><br>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Success!</strong>Data $l_name  Added Successfully. 
			  		</div>
					";
		}
		else
		{
			echo "sorry , Query could no execute...";
		}		
	}
}
?>

 
 
 <div class="row">
              <div class="col">
                <div class="card card-small mb-4">
                 
                  <div class="card-body p-0 pb-3 text-center">
                    <table class="table mb-0">
                      <thead class="bg-light">
                        <tr>
                          <th>First name</th>
                          <th>Last name</th>
                          <th>Section</th>
                        </tr>
                      </thead>
                      <tbody>
 <?php
 foreach($obj_class->showData("students") as $value){
 extract($value);
 echo <<<show
  
      <td>$f_name</td>
      <td>$l_name</td>
      <td>$section</td>                    
                          
show;
 }
 ?>

                     
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
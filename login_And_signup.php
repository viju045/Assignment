************************** Login ***************************

<html>
    <head>
        
        <title></title>
    </head>
    <body>
        <?php
            $servername="localhost";
			$username="root";
			$password="";
			$dbname="Simple";
			  
			$conn= new mysqli($servername,$username,$password,$dbname);
			 
			if($conn->connect_error)
				{
				   die ("connection failed:".$conn->connect.error);
				}
						
                        session_start();
			$em=$_POST['email'];
			$pw=$_POST['pass'];
			//die("select * from regform where email='$em' and pass='$pw'");														
			
			$result=$conn->query("select * from regform where email='$em' and pass='$pw'");								
			
			if($result->num_rows>0)
				{
				
                                        $_SESSION["email"]=$em;
                                        $_SESSION["password"]=$pw;
                                        header("Location:listed-books.php");
                                }
                                else
				{
				   ?>
                                        <script type="text/javascript">
                                        alert("msg");
                                        location.href("logout.php");
                                        </script>
                                 <?php       
                                        
				}	
				
			$conn->close();
        ?>
    </body>
</html>

*********************************** Singup/Register ******************************

<?php 
session_start();

//Code for student ID
$count_my_page = ("studentid.txt");
$hits = file($count_my_page);
$hits[0] ++;
$fp = fopen($count_my_page , "w");
fputs($fp , "$hits[0]");
fclose($fp); 
$StudentId= $hits[0];   
$fname=$_POST['fullanme'];
$mobileno=$_POST['mobileno'];
$email=$_POST['email']; 
$password=md5($_POST['password']); 
$status=1;
$sql="INSERT INTO  tblstudents(StudentId,FullName,MobileNumber,EmailId,Password,Status) VALUES(:StudentId,:fname,:mobileno,:email,:password,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':StudentId',$StudentId,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo '<script>alert("Your Registration successfull and your student id is  "+"'.$StudentId.'")</script>';
}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";
}
}

?>


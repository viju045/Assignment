*************************** Add Books *******************************

<?php
session_start();
if(isset($_POST['add']))
{
$bookname=$_POST['bookname'];
$category=$_POST['category'];
$author=$_POST['author'];
$isbn=$_POST['isbn'];
$price=$_POST['price'];
$bookimg=$_FILES["bookpic"]["name"];
// get the image extension
$extension = substr($bookimg,strlen($bookimg)-4,strlen($bookimg));
// allowed extensions
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
// Validation for allowed extensions .in_array() function searches an array for a specific value.
//rename the image file
$imgnewname=md5($bookimg.time()).$extension;
// Code for move image into directory

if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
move_uploaded_file($_FILES["bookpic"]["tmp_name"],"bookimg/".$imgnewname);
$sql="INSERT INTO  tblbooks(BookName,CatId,AuthorId,ISBNNumber,BookPrice,bookImage) VALUES(:bookname,:category,:author,:isbn,:price,:imgnewname)";
$query = $dbh->prepare($sql);
$query->bindParam(':bookname',$bookname,PDO::PARAM_STR);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':author',$author,PDO::PARAM_STR);
$query->bindParam(':isbn',$isbn,PDO::PARAM_STR);
$query->bindParam(':price',$price,PDO::PARAM_STR);
$query->bindParam(':imgnewname',$imgnewname,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Book Listed successfully');</script>";
}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";    
}}
}
?>


<div class="col-md-6">  
 <div class="form-group">
 <label>Price<span style="color:red;">*</span></label>
 <input class="form-control" type="text" name="price" autocomplete="off"   required="required" />
 </div>
</div>

<div class="col-md-6">  
 <div class="form-group">
 <label>Book Picture<span style="color:red;">*</span></label>
 <input class="form-control" type="file" name="bookpic" autocomplete="off"   required="required" />
 </div>
    </div>
<button type="submit" name="add" id="add" class="btn btn-info">Submit </button>
 </div>
</div>
</body>
</html>

************************ Editing Books *************************** 
<?php
session_start();

if(isset($_POST['update']))
{
$bookname=$_POST['bookname'];
$category=$_POST['category'];
$author=$_POST['author'];
$isbn=$_POST['isbn'];
$price=$_POST['price'];
$bookid=intval($_GET['bookid']);
$sql="update  tblbooks set BookName=:bookname,CatId=:category,AuthorId=:author,BookPrice=:price where id=:bookid";
$query = $dbh->prepare($sql);
$query->bindParam(':bookname',$bookname,PDO::PARAM_STR);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':author',$author,PDO::PARAM_STR);
$query->bindParam(':price',$price,PDO::PARAM_STR);
$query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
$query->execute();
echo "<script>alert('Book info updated successfully');</script>";
}
?>

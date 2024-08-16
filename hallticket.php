<?php



$Name=$_POST['sname'];
$ID=$_POST['id'];
$Branch=$_POST['branch'];
$Email=$_POST['email'];
$Password=$_POST['pwd'];
$Mobile=$_POST['mobile'];
$Photo=$_POST['photo'];


//Database connection

$conn=new mysqli('localhost:3306//','raju','Nagaraju1136@','Hallticket');
if($conn->connect_error){
    die('Connection Failed :'.$conn->connect_error);
}else{
    $stmt=$conn->prepare("insert into registration(Name,id,branch,email,mobile,photo,password)values(?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss",$Name,$ID,$Branch,$Email,$Mobile,$Photo,$Password);
    $stmt->execute();
    echo "registration sucessfull";
    

    $stmt->close();
    $conn->close();
}
?>
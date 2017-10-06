<?php

require_once 'db.php';

class USER
{ 

 private $conn;

 public function __construct()
 {
  $database = new Database();
  $db = $database->dbConnection();
  $this->conn = $db;
    }
 
 public function runQuery($sql)
 {
  $stmt = $this->conn->prepare($sql);
  return $stmt;
 }

 public function getEmailSend(){
  try
  {    
   $stmt = $this->conn->prepare("SELECT * FROM settings_email_send LIMIT 1");
   $stmt->execute(); 
   $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
   return $userRow;
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }

 public function deleteUser($id){
  try
  {    
   $stmt = $this->conn->prepare("DELETE FROM tbl_users WHERE userID=:userID");
   $stmt->bindparam(":userID",$id);
   $stmt->execute(); 
   $userRow=$stmt->rowCount();
   return $userRow;
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }

 
 public function lasdID()
 {
  $stmt = $this->conn->lastInsertId();
  return $stmt;
 }
 
 public function update_token_reset_pwd($id,$token)
 {
  try
  {       
   
   $stmt = $this->conn->prepare("UPDATE tbl_users SET userName =:token WHERE userID=:userID");
   $stmt->bindparam(":userID",$id);
   $stmt->bindparam(":token",$token);
   $stmt->execute(); 
   return $stmt;
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }

 public function search_user($key)
 {
  try
  {       
   
   $stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userFullName LIKE '%$key%' or userEmail LIKE '%$key%'");
   $stmt->execute(); 
   $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $data;
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }

 public function update_user_active($id,$active)
 {
  try
  {       
   
   $stmt = $this->conn->prepare("UPDATE tbl_users SET active =:active WHERE userID=:userID");
   $stmt->bindparam(":userID",$id);
   $stmt->bindparam(":active",$active);
   $stmt->execute(); 
   return $stmt;
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }

 public function check_reset_pass($email,$token)
 {
  try
  {       

   $stmt = $this->conn->prepare("SELECT userID FROM tbl_users WHERE userEmail =:email and userName=:userName");
   $stmt->bindparam(":email",$email);
   $stmt->bindparam(":userName",$token);
   $stmt->execute(); 
   return $stmt->rowCount();
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }

 public function register($id,$name,$uname,$email,$upass,$code)
 {
  try
  {       
   
   $password = md5($upass);
   $userStatus = "N";
   $stmt = $this->conn->prepare("INSERT INTO tbl_users(userID,userFullName,userName,userEmail,userPass,tokenCode,userStatus) 
                                                VALUES(:user_id, :user_full_name, :user_name, :user_mail, :user_pass, :active_code, :user_status)");
   $stmt->bindparam(":user_id",$id);
   $stmt->bindparam(":user_full_name",$name);
   $stmt->bindparam(":user_name",$uname);
   $stmt->bindparam(":user_mail",$email);
   $stmt->bindparam(":user_pass",$password);
   $stmt->bindparam(":active_code",$code);
   $stmt->bindparam(":user_status",$userStatus);
   $stmt->execute(); 
   return $stmt;
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }

 public function register_admin($id,$name,$uname,$email,$upass,$userLevel)
 {
  try
  {       
   
   $password = md5($upass);
   $userStatus = "Y";
   $stmt = $this->conn->prepare("INSERT INTO tbl_users(userID,userFullName,userName,userEmail,userPass,userStatus,userLevel) 
                                                VALUES(:user_id, :user_full_name, :user_name, :user_mail, :user_pass,  :user_status, :userLevel)");
   $stmt->bindparam(":user_id",$id);
   $stmt->bindparam(":user_full_name",$name);
   $stmt->bindparam(":user_name",$uname);
   $stmt->bindparam(":user_mail",$email);
   $stmt->bindparam(":user_pass",$password);
   $stmt->bindparam(":user_status",$userStatus);
   $stmt->bindparam(":userLevel",$userLevel);
   $stmt->execute(); 
   return $stmt;
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }
 
 public function login($email,$upass)
 {
  try
  {
   $stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
   $stmt->execute(array(":email_id"=>$email));
   $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
   
   if($stmt->rowCount() == 1)
   {
    if($userRow['userStatus']=="Y")
    {
     if($userRow['userPass']==md5($upass))
     {
      $_SESSION['userSession'] = $userRow['userID'];
      $_SESSION['userLevel'] = $userRow['userLevel'];
      return true;
     }
     else
     {
      echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>Wrong email or password. Please try again!</h5></div>';
      exit;
     }
    }
    else
    {
     echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>Your current email is not yet verified. Please check your Email!</h5></div>';
     exit;
    } 
   }
   else
   {
    echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>No account found with that email address!</h5></div>';
    exit;
   }  
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }
 
 
 public function is_logged_in()
 {
  if(isset($_SESSION['userSession']))
  {
   return true;
  }
 }

 public function is_logged_in_admin()
 {
  if(isset($_SESSION['userSession'],$_SESSION['userLevel']))
  { 
    if($_SESSION['userLevel']==="admin"){
      return true;
    }
  }
  
 }
 
 public function redirect($url)
 {
  header("Location: $url");
 }
 
 public function logout()
 {
  session_destroy();
  $_SESSION['userSession'] = false;
  $_SESSION['userLevel'] = false;
 }
 
 function send_mail($email,$message,$subject)
 {      
  require_once('../mailer/class.phpmailer.php');
  $row =$this->getEmailSend();
  $mail = new PHPMailer();
  $mail->IsSMTP(); 
  $mail->SMTPDebug  = 0;                     
  $mail->SMTPAuth   = true;                  
  $mail->SMTPSecure = "ssl";                 
  $mail->Host       = "smtp.gmail.com";      
  $mail->Port       = 465;             
  $mail->AddAddress($email);
  $mail->Username=$row['email_send'];  
  $mail->Password=$row['email_pass'];            
  $mail->SetFrom($row['domain'],$row['name']);
  $mail->AddReplyTo($row['domain'],$row['name']);
  $mail->Subject    = $subject;
  $mail->MsgHTML($message);
  $mail->Send();
 } 
}
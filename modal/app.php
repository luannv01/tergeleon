<?php

require_once 'db.php';

class APP
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
 
 
 public function getUsersforAdmin()
 {
  try
  {
   $stmt = $this->conn->prepare("SELECT * FROM tbl_users ORDER BY userID DESC");
   $stmt->execute();
   $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
   return $data;
  
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }


 public function getAppforUser($stt)
 {
  try
  {
   $stmt = $this->conn->prepare("SELECT id,name,size,OS,version,status FROM app_info WHERE status=:stt ORDER BY id DESC");
   $stmt->execute(array(":stt"=>$stt));
   $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
   return $data;
  
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }


 public function getOneApp($id)
 {
  try
  {
   $stmt = $this->conn->prepare("SELECT * FROM app_info WHERE id=:id");
   $stmt->execute(array(":id"=>$id));
   $data=$stmt->fetch(PDO::FETCH_ASSOC);
   return $data;
  
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }

 public function getAppforAdmin()
 {
  try
  {
   $stmt = $this->conn->prepare("SELECT id,name,size,OS,version,status FROM app_info  ORDER BY id DESC");
   $stmt->execute();
   $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
   return $data;
  
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }

 public function addNewApp($name,$os,$size,$version,$status,$link_offer,$link_img,$content,$producer,$date_update,$view,$hot)
 {
  try
  {
   $id="";
   $end_tracking="y";
   $stmt = $this->conn->prepare("INSERT INTO app_info(id,name,OS,size,version,status,link_offer,link_img,content,producer,date_update,view,hot,end_tracking) 
                                                VALUES(:id,:name, :os, :size, :version, :status, :link_offer, :link_img, :content, :producer, :date_update, :view, :hot, :end_tracking)");
   $stmt->bindparam(":id",$id);
   $stmt->bindparam(":name",$name);
   $stmt->bindparam(":os",$os);
   $stmt->bindparam(":size",$size);
   $stmt->bindparam(":version",$version);
   $stmt->bindparam(":status",$status);
   $stmt->bindparam(":link_offer",$link_offer);
   $stmt->bindparam(":link_img",$link_img);
   $stmt->bindparam(":content",$content);
   $stmt->bindparam(":producer",$producer);
   $stmt->bindparam(":date_update",$date_update);
   $stmt->bindparam(":view",$view);
   $stmt->bindparam(":hot",$hot);
   $stmt->bindparam(":end_tracking",$end_tracking);
   $stmt->execute();
   return $stmt;
  
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }
 
 public function setStatusApp($id,$status){
    try {
      $stmt = $this->conn->prepare("UPDATE app_info
          SET status = :status
          WHERE id = :id");
      $stmt->bindparam(":id",$id);
      $stmt->bindparam(":status",$status);
      $stmt->execute();
      return $stmt;
    }
    catch(PDOException $ex)
        {
          echo $ex->getMessage();
        }

     }
  public function deleteApp($id){
    try {
      $stmt = $this->conn->prepare("DELETE FROM app_info
WHERE id=:id");
      $stmt->bindparam(":id",$id);
      $stmt->execute();
      return $stmt;
    }
    catch(PDOException $ex)
        {
          echo $ex->getMessage();
        }

     }
  
 public function editApp($id,$name,$os,$size,$version,$status,$link_offer,$link_img,$content,$producer,$date_update,$view,$hot,$track){
    try {
      $stmt = $this->conn->prepare("UPDATE app_info
          SET name=:name, OS=:os, size=:size, version=:version, status = :status, link_offer=:link_offer, link_img=:link_img, content=:content, producer=:producer, date_update=:date_update, view=:view, hot=:hot, end_tracking=:end_tracking
          WHERE id = :id");
     $stmt->bindparam(":id",$id);
     $stmt->bindparam(":name",$name);
     $stmt->bindparam(":os",$os);
     $stmt->bindparam(":size",$size);
     $stmt->bindparam(":version",$version);
     $stmt->bindparam(":status",$status);
     $stmt->bindparam(":link_offer",$link_offer);
     $stmt->bindparam(":link_img",$link_img);
     $stmt->bindparam(":content",$content);
     $stmt->bindparam(":producer",$producer);
     $stmt->bindparam(":date_update",$date_update);
     $stmt->bindparam(":view",$view);
     $stmt->bindparam(":hot",$hot);
     $stmt->bindparam(":end_tracking",$track);
     $stmt->execute();
   return $stmt;
      return $stmt;
    }
    catch(PDOException $ex)
        {
          echo $ex->getMessage();
        }

     }
}
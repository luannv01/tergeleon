<?php session_start();
    require_once '../modal/app.php';
    $app = new APP();
    require_once '../modal/user.php';
    $user = new USER();

    if(!$user->is_logged_in())
    {
     $user->redirect('login.html');
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Blank Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php require "layout/head-link.php" ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

 <?php require "layout/nav-header.php" ?>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <?php require "layout/nav-left.php" ?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Content app
        <small>Show all app starts here</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Content app</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
<div id="x"></div>
      <!-- Default box -->
     <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 id="error-msg" class="box-title">Content apps data</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 300px;">
                  <input type="text" name="table_search" id="table_search" class="form-control pull-right" placeholder="Search">
                  <div class="input-group-btn">
                    <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                  <div class="input-group-btn"></div>
                   <div class="input-group-btn" >
                   <button data-toggle="modal" data-target="#addNewUser" class="btn btn-primary">Add new user</button>
                   </div>
                </div>

              </div>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
             <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NAME</th>
                                        <th>EMAIL</th>
                                        <th>TYPE USER</th>
                                        <th>COUNTRY</th>
                                        <th>PHONE</th>
                                        <th>SKYPE</th>
                                        <th>ACTIVE EMAIL</th>
                                        <th>BAN</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody id='checkStt'>
                                <?php
                                   
                                    if(isset($_SESSION['userLevel']) && ($_SESSION['userLevel']==="admin") ){
                                     $data= $app->getUsersforAdmin();
                                    foreach($data as $value){
                                       
                                        if($value['active']==="Y"){
                                          $checkbox =" <button type='button' class='btn bg-green btn-xs '><i class='fa fa-thumbs-o-up'></i> Enable</button>";
                                        }else{
                                          $checkbox ="<button type='button' class='btn bg-yellow btn-xs '><i class='fa fa-user-times'></i> Banned</button>";
                                        }
                                        if($value['userStatus']==="Y"){
                                          $userStatus =" <button type='button' class='btn bg-green btn-xs '><i class='fa fa-check'></i> Actived</button>";
                                        }else{
                                          $userStatus ="<a class='btn btn-warning btn-xs'><i class='fa fa-clock-o'></i> Pending</a>";
                                        }
                                        if($value['userLevel']==="admin"){
                                          $userLevel =" <button type='button' class='btn bg-green btn-xs '><i class='fa fa-user-md'></i> Admin</button>";
                                        }else{
                                          $userLevel ="<a class='btn btn-warning btn-xs'><i class='fa fa-user'></i> Agent</a>";
                                        }
                                       
                                        $action="<button type='button' class='btn bg-red btn-xs' id='".$value['userID']."' onclick='del(this)'><i class='fa fa-trash'></i> Delete</button>";
                                    echo"
                                        <tr>
                                        <th>".$value['userID']."</th>
                                        <td>".$value['userFullName']."</td>
                                        <td>".$value['userEmail']."</td>
                                        <td>".$userLevel."</td>
                                        <td>".$value['country']."</td>
                                        <td>".$value['phone']."</td>
                                        <td>".$value['skype']."</td>
                                        <td>".$userStatus."</td>
                                        <td id='check".$value['userID']."'> ".$checkbox."</td>
                                        <td>".$action."</td>
                                        </tr>
                                        
                                    ";
                                    }
                                 }
                                ?>
                                    
                                    
                                </tbody>
                            </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
 
  <!-- /.content-wrapper -->
<div class="modal fade in" id="addNewUser">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add new User</h4>
              </div>
              <div class="modal-body">
                 <form id="register_form" action="" method="post">
      <div id="error-msg"></div>
      <div class="form-group has-feedback">
        <input type="text" name="fullName" id="fullName" class="form-control" required="required" placeholder="Full name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" name="email" id="email" class="form-control" required="required" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" id="password" class="form-control" required="required" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="retypePassword" id="retypePassword" class="form-control" required="required" placeholder="Retype password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>


        <div class="form-group has-feedback">
                  <label>Select Type user:</label>
                  <select id="userLevel" name="userLevel" class="form-control">
                   <option value="agent" selected="selected">Agent</option>
                   <option value="admin" >Admin</option>
                  </select>
                </div>

      <div class="form-group has-feedback">
       <div class="g-recaptcha"  data-sitekey="6LcwgDEUAAAAACArQdy92BkEwqDif1xSR3tPUvVZ"></div>
       </div>
      <div class="form-group has-feedback">
       <div class="g-recaptcha"  data-sitekey="6LcwgDEUAAAAACArQdy92BkEwqDif1xSR3tPUvVZ"></div>
       </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox">
            <label>
              <input type="checkbox" id="confirm" name="confirm" required="required"> I agree to the <a href="#">terms</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
      </div>
        
              </div>              
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                 <button type="Submit" id="btn-submit-register" class="btn btn-primary pull-right" >Add new user</button>
                </form>      
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

  <?php require"layout/footer.php" ?>

  <!-- Control Sidebar -->
  <?php require "layout/nav-right-setting.php" ?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php require"layout/js.php" ?>
<script type="text/javascript">
function make_item_rows(result_array){  
    $.each(result_array, function(index, element){
       console.log('x');
    });                    
}
  $('#search').click(function(){
  var input = $('#table_search').val();
   var tokenAdmin = $('#tokenAdmin').val();
   $.ajax({
          url:'../controller/user-admin/search_user.php',
          type: 'POST',
          dataType: "JSON",
          data: {tokenAdmin : tokenAdmin, key : input},
          success: function (data) {
           data = jQuery.parseJSON(data);
        $.each(data, function (k, v) {
            alert(k + ':' + v);
        });
          },
      });
   
})</script>
<!-- CK Editor -->
<script src="bower_components/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
 $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('edit_ckeditors');
    CKEDITOR.replace('ckeditor');
    //bootstrap WYSIHTML5 - text editor
   // $('.textarea').wysihtml5()
  });
 function del(el){
  var check = confirm("Do you want delete this app");
  if(check === true){
         var id = $(el).attr('id');
         var tokenAdmin = $('#tokenAdmin').val();
          $.ajax({
                    url:'../controller/user-admin/deleteUser.php',
                    type: 'POST',
                    data: {id : id, tokenAdmin : tokenAdmin},
                    success: function (data) {
                      var x = $.trim(data);
                              if(x !== "success"){
                                alert(x);
                              }else{
                                window.location.reload();
                              }
                    } 
                  });
  }else{
    alert("You're Cancel");
  }
}
 


    $('#checkStt td').click(function() {
        var id =  $(this).prop('id');
        var stt = $.trim($(this).text());
        
        var tokenAdmin = $('#tokenAdmin').val();
        if(tokenAdmin===""){
            alert('Opps!');
            return false;
        }
        if(stt === "Banned"){
          $(this).children('.btn').text('Sending...');
             $.ajax({
                    url:'../controller/user-admin/editUser.php',
                    type: 'POST',
                    data: {id : id, tokenAdmin : tokenAdmin, active : "Y"},
                    success: function (data) {
                         var j = $.trim(data);
                         if(j !== "successfully"){
                          $('#checkStt td#'+id).children(":button").html("<i class='fa fa-user-times'></i> Banned");
                         alert(data);
                          }else{
                            window.location.reload();
                          }
                    },
                    
                });
          
        }
        if(stt === "Enable"){
          $(this).children('.btn').text('Sending...');
             $.ajax({
                    url:'../controller/user-admin/editUser.php',
                    type: 'POST',
                    data: {id : id, tokenAdmin : tokenAdmin, active : "N"},
                    success: function (data) {
                     var j = $.trim(data);
                     if(j !== "successfully"){
                      $('#checkStt td#'+id).children(":button").html("<i class='fa fa-thumbs-o-up'></i> Enable");
                      alert(data);
                      }else{
                        window.location.reload();
                      }
                    },
                });
        }
       
        });

     /* attach a submit handler to the form */
            $("#register_form").submit(function(e) {

                /* stop form from submitting normally */
                e.preventDefault();
                     var tokenAdmin = $('#tokenAdmin').val();
                   $('#btn-submit-register').text('Sending...');
                         var formData = new FormData($(this)[0]);
                        
                         formData.append('tokenAdmin', tokenAdmin);
                        $.ajax({
                            url:'../controller/user-admin/addNewUser.php',
                            type: 'POST',
                            data: formData,
                            async: false,
                            success: function (data) {
                               $('#btn-submit-register').text('Add new user');
                              var x = $.trim(data);
                              if(x !== "Successfully"){
                                $('#error-msg').empty().html(data);
                                 grecaptcha.reset();
                              }else{
                                window.location.reload();
                              }

                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                       
            });


</script>
</body>
</html>

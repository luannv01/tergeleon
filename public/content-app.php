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

      <!-- Default box -->
     <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Content apps data</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 300px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                  <div class="input-group-btn"></div>
                   <div class="input-group-btn" >
                   <button data-toggle="modal" data-target="#addNewApp" class="btn btn-primary">Add new app</button>
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
                                        <th>OS</th>
                                        <th>SIZE</th>
                                        <th>VERSION</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody id='checkStt'>
                                <?php
                                   
                                    if(isset($_SESSION['userLevel']) && ($_SESSION['userLevel']==="admin") ){
                                     $data= $app->getAppforAdmin();
                                    foreach($data as $value){
                                        $stt = ($value['status']==="0") ? "ON" : "OFF";
                                        $checkbox = ($value['status']==='0') ? 'Checked' : '';
                                    echo"
                                        <tr>
                                        <th>".$value['id']."</th>
                                        <td>".$value['name']."</td>
                                        <td>".$value['OS']."</td>
                                        <td>".$value['size']."</td>
                                        <td>".$value['version']."</td>
                                        <td> 
                                            <div class='switch'>
                                              <input id='check".$value['id']."' type='checkbox' name='status' 
                                              ".$checkbox.">
                                            </div>
                                        </td>
                                        <td class='js-sweetalert'>
                                            <button type='button' id='".$value['id']."' onclick='get_edit(this)' class='btn bg-blue '><i class='fa fa-edit'></i> Edit</button>
                                            <button type='button' class='btn bg-red margin' id='".$value['id']."' onclick='del(this)'><i class='fa fa-trash'></i> Delete</button>
                                        </td>
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
<div class="modal fade in" id="modal-edit-app">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Edit Apps</h4>
              </div>
              <div class="modal-body">
                                <form id="form_editApp" method="POST" enctype="multipart/form-data">
                                 <label class="form-label">Name's App:</label>
                                    <div class="form-group ">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name" id="edit_name" required>
                                        </div>
                                    </div>
                                 <label class="form-label">Version:</label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="version"  id="edit_version" required>
                                        </div>
                                    </div>
                                    <label class="form-label">Size (Mb)</label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="size" id="edit_size" required>
                                        </div>
                                    </div>
                                    <label class="form-label">Link Offer</label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="url" class="form-control" name="link_offer" id="edit_link_offer" required>
                                        </div>
                                    </div>
                                     <label class="form-label">Producer</label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="producer" id="edit_producer" required>
                                        </div>
                                    </div>
                                    <label class="form-label">View</label>
                                     <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="view" id="edit_view" required>
                                        </div>
                                    </div>
                                    <label class="form-label">Date Update</label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="date" class="form-control" name="date_update" id="edit_date_update" required ">
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <select class="form-control show-tick" name="os" id="edit_os">
                                            <option value="Null">-- Please select OS --</option>
                                            <option value="Android">Android</option>
                                            <option value="iOS">iOS</option>
                                            <option value="Windowsphone">Windowsphone</option>
                                        </select>
                                    </div>
                                    </div>
                                   
                                    
                                    <div class="form-group form-float">
                                   
                                      <div class="switch">
                                        Status: <label><input type="checkbox" name="status" id="edit_status"><span class="lever"></span></label>
                                      </div>
                                    </div>
                                           
                                     <input type="hidden" id="edit_id" name="id">
                                    <input type="hidden" id="edit_imgs" name="edit_imgs">
                                    <div class="form-group">
                                        <input type="checkbox" id="edit_checkboxHot" name="edit_checkboxHot">
                                        <label for="edit_checkboxHot">Hot</label>
                                    </div>

                                    <!-- File Upload | Drag & Drop OR With Click & Choose -->

                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <img id="edit_img" src="" width="100" height="100">
                                        <p>
                                           <div class="fallback">
                                               <input name="edit_file" type="file" multiple />
                                           </div>
                                        </div>
                                    </div>
                                    <!-- #END# File Upload | Drag & Drop OR With Click & Choose -->

                                    <!-- TinyMCE -->
                                    <div class="row clearfix">

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <h4>Content:</h4>
                                            <textarea id="edit_ckeditors" name="ckeditors">
                                           
                                            </textarea>
                                        </div>
                                    </div>
                                    
                            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="btn_submit_edit_app" class="btn btn-primary">Submit</button>
                 </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>


  <!-- /.content-wrapper -->
<div class="modal fade in" id="addNewApp">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add new Apps</h4>
              </div>
              <div class="modal-body">
                <form id="form_addNewApp" method="POST" enctype="multipart/form-data">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name" required>
                                        <label class="form-label">Name</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="version" required>
                                        <label class="form-label">Version</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="size" required>
                                        <label class="form-label">Size (Mb)</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="url" class="form-control" name="link_offer" required>
                                        <label class="form-label">http://doain.com</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="producer" required>
                                        <label class="form-label">Producer</label>
                                    </div>
                                </div>
                                 <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="view" required>
                                        <label class="form-label">View</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="date" class="form-control" name="date_update" required ">
                                        
                                    </div>
                                </div>
                                <div class="row clearfix">
                                <div class="col-sm-12">
                                    <select class="form-control show-tick" name="os">
                                        <option value="Null">-- Please select OS --</option>
                                        <option value="Android">Android</option>
                                        <option value="iOS">iOS</option>
                                        <option value="Windowsphone">Windowsphone</option>
                                    </select>
                                </div>
                                </div>
                               
                                
                                <div class="form-group form-float">
                               
                                  <div class="switch">
                                    Status: <label><input type="checkbox" name="status"><span class="lever"></span></label>
                                  </div>
                                </div>
                                       
                                 
                                
                                <div class="form-group">
                                    <input type="checkbox" id="checkbox" name="checkboxHot">
                                    <label for="checkbox">Hot</label>
                                </div>

                                <!-- File Upload | Drag & Drop OR With Click & Choose -->
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="fallback">
                                           <input name="file" type="file" multiple />
                                       </div>
                                    </div>
                                </div>
                                <!-- #END# File Upload | Drag & Drop OR With Click & Choose -->

                                <!-- TinyMCE -->
                                <div class="row clearfix">

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h4>Content:</h4>
                                        <textarea id="ckeditor" name="ckeditor">
                                       
                                        </textarea>
                                    </div>
                                </div>
                               
              </div>              
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="btn_submit_add_new_app" class="btn btn-primary">Submit</button>
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
                    url:'../controller/deleteApp.php',
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
 function get_edit(el){
         var id = $(el).attr('id');
         var tokenAdmin = $('#tokenAdmin').val();

          $.ajax({
                    url:'../controller/getOneApp.php',
                    type: 'POST',
                    dataType: "JSON",
                    data: {id : id, tokenAdmin : tokenAdmin},
                    success: function (data) {
                      
                      $('#edit_id').val(data.id);
                      $('#edit_name').val(data.name);
                      $('#edit_version').val(data.version);
                      $('#edit_size').val(data.size);
                      $('#edit_link_offer').val(data.link_offer);
                      $('#edit_producer').val(data.producer);
                      $('#edit_view').val(data.view);
                      $('#edit_date_update').val(data.date_update);
                      $('#edit_os').val('Android').prop('selected', true);
                      if(data.OS === "Android"){
                        $('#edit_os').val('Android').prop('selected', true);
                        }else if(data.OS === "iOS"){
                        $('#edit_os').val('iOS').prop('selected', true);
                        }else if(data.OS === "Windowsphone"){
                        $('#edit_os').val('Windowsphone').prop('selected', true);
                        }else{
                        $('#edit_os').val('Null').prop('selected', true);
                        }
                        if(data.hot ==="ON"){
                            $('#edit_checkboxHot').prop('checked', true);
                        }else{
                            $('#edit_checkboxHot').prop('checked', false);
                        }
                        if(data.status === "1"){
                             $('#edit_status').prop('checked', false);
                         }else{
                            $('#edit_status').prop('checked', true);
                         }
                       
                        $('#edit_img').attr('src', "../uploads/"+data.link_img);
                        $('#edit_imgs').val(data.link_img);
                      CKEDITOR.instances['edit_ckeditors'].setData(data.content);
                     // $('#edit_os').selectpicker('refresh');
                      $('#modal-edit-app').modal().show();
                    },
                    
                });
           
     }


    $('#checkStt :input:checkbox').change(function() {
        var $check =  $(this).prop('checked');
        var id = this.id;
        var tokenAdmin = $('#tokenAdmin').val();
        if(tokenAdmin===""){
            alert('Opps!');
            return false;
        }
        if($check === false){
           
             $.ajax({
                    url:'../controller/editStt.php',
                    type: 'POST',
                    data: {id : id, tokenAdmin : tokenAdmin, status : "1"},
                    success: function (data) {
                        if(data !=="success"){
                            alert(data);
                        }
                    },
                    
                });
        }
        if($check === true){
             $.ajax({
                    url:'../controller/editStt.php',
                    type: 'POST',
                    data: {id : id, tokenAdmin : tokenAdmin, status : "0"},
                    success: function (data) {
                        if(data !=="success"){
                            alert(data);
                        }
                    },
                    
                });
        }
       
        });

     /* attach a submit handler to the form */
            $("#form_addNewApp").submit(function(e) {

                /* stop form from submitting normally */
                e.preventDefault();
                     var tokenAdmin = $('#tokenAdmin').val();
                   $('#btn_submit_add_new_app').text('Sending...');
                         var formData = new FormData($(this)[0]);
                         formData.append('content', CKEDITOR.instances['ckeditor'].getData());
                         formData.append('tokenAdmin', tokenAdmin);
                        $.ajax({
                            url:'../controller/addNewApp.php',
                            type: 'POST',
                            data: formData,
                            async: false,
                            success: function (data) {
                               $('#btn_submit_add_new_app').text('Submit');
                              var x = $.trim(data);
                              if(x !== "success"){
                                alert(x);
                              }else{
                                window.location.reload();
                              }

                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                       
            });

  /* attach a submit handler to the form */
            $("#form_editApp").submit(function(e) {

                /* stop form from submitting normally */
                e.preventDefault();
                    var tokenAdmin = $('#tokenAdmin').val();
                   $('#btn_submit_edit_app').text('Sending...');
                         var formData = new FormData($(this)[0]);
                         formData.append('content_edit', CKEDITOR.instances['edit_ckeditors'].getData());
                         formData.append('tokenAdmin', tokenAdmin);
                        $.ajax({
                            url:'../controller/editApp.php',
                            type: 'POST',
                            data: formData,
                            async: false,
                            success: function (data) {
                               $('#btn_submit_edit_app').text('Submit');
                              var x = $.trim(data);
                                if(x ==="successfully"){
                                     window.location.reload();
                                 }else{
                                    alert(x);
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

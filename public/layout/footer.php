           
            <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2017-2019 <a href="#">luannv</a>.</strong> All rights
    reserved.

     <?php 
    function random_string($length) {
           $key = base64_encode(openssl_random_pseudo_bytes(3 * ($length >> 2)));

            return $key;
        }


    if(isset($_SESSION['userSession']) && $_SESSION['userLevel']){
             if($_SESSION['userLevel'] ==="admin"){
                $_SESSION['userToken'] = random_string(30);
                $token = $_SESSION['userToken'];
                echo' <input type="hidden" id="tokenAdmin" name="tokenAdmin" value="'.$token.'">';
                
             }
        }?>
  </footer>
$(function() {
    $("#body").fadeOut(2000, function() {
                $.ajax({ 
                        url:'../controller/login.php',
                        type:'POST',
                        data:{checkLog: "OK"},
                        success:function(result){
                          if(result ==="already"){
                            window.location.href="index.html";
                          }else{
                             $("body").fadeIn(1000); 
                          }
                          
                        }
                    });       
    });
});
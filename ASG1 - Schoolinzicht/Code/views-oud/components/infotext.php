<?php
    require_once MODEL_INFOTEXT;
    $getInfotext = new Infotext;
    $getInfotext = $getInfotext->getInfo($pageName);
?>
<script language="javascript" type="text/javascript">   
//    function createCookie(name,value,days) {
//	if (days) {
//		var date = new Date();
//		date.setTime(date.getTime()+(days*24*60*60*1000));
//		var expires = "; expires="+date.toGMTString();
//	}
//	else var expires = "";
//	document.cookie = name+"="+value+expires+"; path=/";
//    }
//
//    function readCookie(name) {
//            var nameEQ = name + "=";
//            var ca = document.cookie.split(';');
//            for(var i=0;i < ca.length;i++) {
//                    var c = ca[i];
//                    while (c.charAt(0)==' ') c = c.substring(1,c.length);
//                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
//            }
//            return null;
//    }
//
//       function eraseCookie(name) {
//            createCookie(name,"",-1);
//    }
//  
//    
//    check();
//    
//function set(){
//    var ele = document.getElementById("helptextcontent"); 
//    var text = document.getElementById("helptexttogglebutton");
//    eraseCookie('info');
//    if(ele.style.display == "none"){
//        createCookie('info','open', 7);
//         ele.style.display = "none";
//        text.innerHTML = "show";
//        
//    }else{
//        createCookie('info','close', 7);
//        ele.style.display = "block";
//       text.innerHTML = "hide";
//    }
//}
//function check(){
//   var cookie = readCookie('info');
//   var ele = document.getElementById("helptextcontent");
//   var text = document.getElementById("helptexttogglebutton");
//   //document.write(cookie);
//   if(cookie == 'close'){
//        document.write("closed");
//        ele.style.display = "block";
//       text.innerHTML = "hide";
//   }else{
//       document.write("open");
//       ele.style.display = "none";
//        text.innerHTML = "show";
//   }
//}
//    // function that shows or hides the infotext:
//    function toggleinfotext() {
//	var ele = document.getElementById("helptextcontent");
//	var text = document.getElementById("helptexttogglebutton");
//	if(ele.style.display == "block") {
//    		ele.style.display = "none";
//		text.innerHTML = "show";
//                  
//  	}
//	else {
//		ele.style.display = "block";
//		text.innerHTML = "hide";
//	}
// }
function checkCookieValue() {
    //check if cookie exists, if cookie exists set:
//    		ele.style.display = "none";
//		text.innerHTML = "show";
    //or the other way around
}
function setCookie() {
    //check if cookie exists, if cookie exists:
        //set cookievalue to 'none' or 'show'
        //ele.style.display = "none";
        //text.innerHTML = "show";
    //if cookie does not exists:
        //create cookie with according values
        //ele.style.display = "none";
        //text.innerHTML = "show";
}
</script>
<div id="helptextcontainer" onload="javascript:checkCookieValue();">
    <div id="helptextcontent" style="display: block">
      <center>  <?php echo nl2br($getInfotext[0]["infotext"]); ?> </center>
    </div>
    <div id="helptextbutton">
        <div class="helptextside"></div>
        
        
</div>
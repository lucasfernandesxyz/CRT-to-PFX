<!DOCTYPE html>
<html>
<meta charset="UTF-8">
   <head>
	<title> Conversor SSL para Windows </title>
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
   <head>
         <div class="container">
            <form action="resultado.php" method="post">
               <div class="ssl1">
                  <h1> Conversor SSL para Windows</h1>

               <div>   
                Domínio:
                  <input class="text" type="text" name="dominio">
               </div>
                  <p> Private Key: </p>
                  <textarea class="ssl" id="key" name="key" COLS=65 ROWS=8></textarea>
               </div>
               <div class="ssl1">
                  <p> CRT: </p>
                  <textarea class="ssl" id="cert" name="crt" COLS=65 ROWS=8></textarea>
               </div>
               </div>
               <div align=center> 
                  <input type="submit" value="Les go" name="subtmit" class="button1">
               </div>
            </form>
         </div>
</html>

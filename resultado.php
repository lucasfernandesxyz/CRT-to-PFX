<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<title> SSL Convertido </title>
</head>
<body>


<?php
//error_reporting(E_ERROR | E_PARSE);
$hostname = $_POST['dominio'];
$ip = gethostbyname($hostname);
$vpshost = gethostbyaddr($ip);
$caminho = substr($vpshost, 0, strpos($vpshost, "."));

$key = $_POST['key'];
$crt = $_POST['crt'];
$certificado = substr($hostname, 0,strpos($hostname, "."));
mkdir("temp/$certificado");
$criakey = file_put_contents("temp/$certificado/$certificado.key", $key, FILE_APPEND | LOCK_EX);
$criacrt = file_put_contents("temp/$certificado/$certificado.crt", $crt, FILE_APPEND | LOCK_EX);
shell_exec("openssl pkcs12 -export -in temp/$certificado/$certificado.crt -inkey temp/$certificado/$certificado.key -out temp/$certificado/$certificado.pfx -password pass:");


//Verifica através da API do Geolocation se o site está apontado para a Locaweb ou outro provedor

// Obtem a API KEY salva no arquivo config/api
$api_key=fopen("config/api.txt", "r");

// Inicializa cURL.
$ch = curl_init();

// Pega as informações usando a key e o IP do site
curl_setopt($ch, CURLOPT_URL, "https://ipgeolocation.abstractapi.com/v1/?api_key=$api_key&ip_address=$ip");

// CURLOPT_RETURNsTRANSFER para voltar o conteudo como uma variavel
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Executa a request.
$data = curl_exec($ch);

// Fecha cUrl.
curl_close($ch);

//Extrai os dados vindo da API e converte em uma Array
$json = json_decode($data, true);

//Exibe todas as informações obtidas em uma array
//echo '<pre>' . print_r($json, true) . '</pre>';

//Obtém o provedor vindo da API
$provedor = $json['connection']['organization_name'];


//Detalha se ouve erro em converter arquivo, ainda não implementei :p 

//if($ret === false) {
//    die("Erro ao criar arquivo");
//}
//else {
//    echo "um arquivo de $ret bytes foi gerado";
//}

?>
<div align=center>
 
 
<p>Domínio:  
<?php
echo "$hostname \n";
echo "\n";
?>
</p>

<p> IP do site: 
<?php
echo $ip;
?>
</p>

<p> Provedor: 
<?php
echo $provedor;
?>
</p>

<p> Link para validação:
<?php
echo "<a = href='https://decoder.link/sslchecker/$hostname/443' target='_blank'> https://decoder.link/sslchecker/$hostname/443 </a>";
?>
</p>

<p> Acesse a TS e baixe este arquivo:
<?php


//http://tools.stay-ugly.com/temp/$certificado/$certificado.pfx
echo "<a = href='http://cdn.stay-ugly.com/index.php?certificado=http://tools.stay-ugly.com/temp/$certificado/$certificado.pfx&site=$certificado' target='_blank'>http://cdn.stay-ugly.com/index.php?certificado=http://tools.stay-ugly.com/temp/$certificado/$certificado.pfx&site=$certificado </a>";
?>
</p>



<?php
//Verifica se o provedor é ou não a locaweb
if ($provedor == "Locaweb Serviços de Internet S/A") {
	echo "<p> Você precisa salvar no seguinte caminho: </p>";
	echo "<code>";
	echo '\\\\';
	echo $caminho;
	echo '\e$';
	echo "</code>";
} 	else {
	echo "Atenção: Este site não está apontando para a Locaweb. Seu provedor atual é a $provedor. Verifique no chamado qual servidor correto para salvar o certificado";
}

?>

<br/>
<br/>
<br/>
<br/>

<a href="windows.php"<p> Fazer outra conversão </p> </a>

</div>
</body>
</html>


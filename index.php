<!DOCTYPE html>
<html>
<head>
	<title>IMAGENS</title>
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
<h3>Envio de arquivos</h3>
<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" name="cadastro" >
	Nome: <input type="text" placeholder="Seu nome" name="nome"><br />
	Arquivo: <input type="file" title="Adicionar arquivo" name="arquivo"><br/>
	<button type="submit" class="btn btn-primary" name="cadastrar" value="Cadastrar">Enviar</button>
</form>
</body>
</html>
<!-- aqui começa o codigo PHP -->

<?php
// Conexão com o banco de dados
$conn = @mysql_connect("localhost", "banco", "123456") or die ("Problemas na conexão.");
$db = @mysql_select_db("banco", $conn) or die ("Problemas na conexão");
 
// Se o usuário clicou no botão cadastrar efetua as ações
if ($_POST['cadastrar']) {
 
	// Recupera os dados dos campos
	$nome = $_POST['nome'];
	$foto = $_FILES["foto"];
 
	// Se a foto estiver sido selecionada
	if (!empty($foto["name"])) {
 
		// Largura máxima em pixels
		$largura = 150;
		// Altura máxima em pixels
		$altura = 180;
		// Tamanho máximo do arquivo em bytes
		$tamanho = 1000;
 
    	// Verifica se o arquivo é uma imagem
    	if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){
     	   $error[1] = "Isso não é uma imagem.";
   	 	} 
 
		// Pega as dimensões da imagem
		$dimensoes = getimagesize($foto["tmp_name"]);
 
		// Verifica se a largura da imagem é maior que a largura permitida
		if($dimensoes[0] > $largura) {
			$error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
		}
 
		// Verifica se a altura da imagem é maior que a altura permitida
		if($dimensoes[1] > $altura) {
			$error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
		}
 
		// Verifica se o tamanho da imagem é maior que o tamanho permitido
		if($foto["size"] > $tamanho) {
   		 	$error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
		}
 
		// Se não houver nenhum erro
		if (count($error) == 0) {
 
			// Pega extensão da imagem
			preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
 
        	// Gera um nome único para a imagem
        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
 
        	// Caminho de onde ficará a imagem
        	$caminho_imagem = "fotos/" . $nome_imagem;
 
			// Faz o upload da imagem para seu respectivo caminho
			move_uploaded_file($foto["tmp_name"], $caminho_imagem);
 
			// Insere os dados no banco
			$sql = post_query("INSERT INTO usuarios VALUES ('', '".$nome."', '".$nome_imagem."')");
 
			// Se os dados forem inseridos com sucesso
			if ($sql){
				echo "Você foi cadastrado com sucesso.";
			}
		}
 
		// Se houver mensagens de erro, exibe-as
		if (count($error) != 0) {
			foreach ($error as $erro) {
				echo $erro . "<br />";
			}
		}
	}
}
?>
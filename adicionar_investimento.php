<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8">
      <title>Adicionar investimento</title>
      <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link  rel="stylesheet"  href="bootstrap/css/bootstrap.min.css">

  <script src="https://kit.fontawesome.com/45a5aaa029.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="script.js"></script>
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg_nav">
	     <div class="container">
	     	   <img src="dashboard.png" width="150" alt="Meus dashboards">
	            <ul class="navbar-nav">
                    <li class="nav-item btn btn-secondary"><a href="index.html" class="nav-link">Voltar</a></li>
                </ul>
          </div>   
	</nav>

	<?php if (isset($_GET['retorno']) && $_GET['retorno']=='erro') {?>
		<div class="text-white text-center btn-danger position-relative" id="div_erro" >
		<h3 class="text-white">Erro</h3>
		<p class="text-white">Formulário contém campos vazios.</p>
		<button id="fechar" class="btn btn-danger"  style="position: absolute; top: 10%; right: 10%;">x</button>
	   </div>

		
	<?php }elseif (isset($_GET['retorno']) && $_GET['retorno']=='cadastrado') {?>
		<div class="text-white text-center btn-success position-relative" id="div_sucesso" >
		<h3 class="text-white">Investimento salvo!</h3>
		<p class="text-white">Você já pode acompanhar seu novo investimento.</p>
		<button id="fechar" class="btn btn-success"  style="position: absolute; top: 10%; right: 10%;">x</button>
	   </div>
	<?php }?>
	

	<section>
		<div class="container">
			<div class="card">
				<div class="card-header "><strong>Insira os dados do seu ativo</strong></div>
				<div class="card-body">
					<form class="form-group" action="backend.php?acao=inserir" method="post">

						<label for="cod">Código</label>
						<input type="text"  name="cod" class="form-control" placeholder="Ex: CCRO3">
						<label for="cnpj">Cnpj</label>
						<input type="text" name="cnpj" class="form-control" placeholder="Ex: 12.345.678/0002-00">
						<label for="preco_ativo">Preço da ação</label>
						<input type="text" name="preco_ativo" class="form-control">
						<label for="quant_ativo">Quantidade adquirida</label>
						<input type="number" name="quant_ativo" class="form-control">
						<button type="submit" class="form-control btn btn-dark mt-3">Clique para salvar seu investimento</button>
					</form>
				</div>
			</div>
		</div>
	</section>

</body>
</html>
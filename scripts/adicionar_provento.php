<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Adicionar proventos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- css do Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <!-- scripts do Bootstrap (o jquery aqui é o utilizado pelo Bootstrap) -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  
  <!-- scripts fontawesome -->
  <script src="https://kit.fontawesome.com/45a5aaa029.js" crossorigin="anonymous"></script>
  <!-- script do jquery externo pois esta aplicação o utiliza-->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  <!-- script do jquery Mask Plugin de máscaras para inputs-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <!-- css da aplicação -->
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <!-- script js da aplicação -->
  <script src="../scripts/script.js"></script>
</head>

<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg_nav">
		<div class="container">
			<img src="../imagens/dashboard.png" width="150" alt="Meus dashboards">
			<ul class="navbar-nav">
				<li class="nav-item btn btn-secondary"><a href="../index.html" class="nav-link">Voltar</a></li>
			</ul>
		</div>
	</nav>

	<?php if (isset($_GET['retorno']) && $_GET['retorno'] == 'erro') { ?>
		<div class="text-white text-center btn-danger position-relative" id="div_erro">
			<h3 class="text-white">Erro</h3>
			<p class="text-white">Formulário contém campos vazios.</p>
			<button id="fechar" class="btn btn-danger" style="position: absolute; top: 10%; right: 10%;">x</button>
		</div>


	<?php } elseif (isset($_GET['retorno']) && $_GET['retorno'] == 'cadastrado') { ?>
		<div class="text-white text-center btn-success position-relative" id="div_sucesso">
			<h3 class="text-white">Investimento salvo!</h3>
			<p class="text-white">Você já pode acompanhar seu novo investimento.</p>
			<button id="fechar" class="btn btn-success" style="position: absolute; top: 10%; right: 10%;">x</button>
		</div>
	<?php } ?>


	<section>
		<div class="container">
			<div class="card">
				<div class="card-header "><strong>Insira os dados dos seus Proventos</strong></div>
				<div class="card-body">
					<form class="form-group" action="backend.php?acao=inserir_provento" method="post">
						<?php if (isset($_GET["cod"]) && !empty($_GET["cod"])) { ?>
							<input name="cod" type="hidden" aria-hidden="true" value=<?= $_GET["cod"] ?>>

						<?php } else { ?>
							<label for="cod">Código</label>
							<input type="text" name="cod" class="form-control" placeholder="Ex: CCRO3" required pattern="^[A-z]{4}[1-9]{1}[0-9]{0,1}$">

						<?php } ?>


						<label class="mt-2" for="valor_provento">Valor do provento</label>
						<input required type="text" name="valor_provento" class="form-control valor" placeholder="Ex: 1.15">
						<label class="mt-2" for="data_provento">Data recebido</label>
						<input required type="date" name="data_provento" class="form-control" placeholder="Ex: ">
						<label class="mt-2" for="tipo_provento">Tipo de provento</label>
						<select required class="form-control" name="tipo_provento">
							<option value="" disabled selected>Escolha uma opção</option>
							<option value="dividendo">Dividendo</option>
							<option value="jcp">Jcp</option>
						</select>
						<button type="submit" class="form-control btn btn-dark mt-3">Clique para salvar seu provento</button>
					</form>
				</div>
			</div>
		</div>
	</section>

</body>

</html>
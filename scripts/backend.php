<?php
class Investimentos
{
	private $id;
	private $cod;
	private $cnpj;
	private $quant_ativo;
	private $preco_ativo;
	private $valor_total_ativo;
	private $valor_provento;
	private $data_provento;
	private $tipo_provento;



	public function __get($atribute)
	{
		return $this->$atribute;
	}

	public function __set($atribute, $value)
	{
		$this->$atribute = $value;
	}
}

class Bd
{


	public static function conectar()
	{

		static $local_banco = 'localhost';
		static $nome_banco = 'investimentos';
		static $usuario = 'root';
		static $senha = '';



		try {
			$conexao = new PDO("mysql:host=$local_banco;dbname=$nome_banco", $usuario, $senha);

			return $conexao;
		} catch (PDOException $e) {
			echo "Algo deu errado verifique a mensagem a seguir para mais informações <strong>MENSAGEM: </strong>$e";
		}
	}

	public static function todos_dados()
	{
		$conexao = Bd::conectar();
		$query = "SELECT tbA.id,tbA.cod,tbA.cnpj,tbA.quant,tbA.preco,tbA.total_investido from ativos AS tbA;";

		$consulta = $conexao->prepare($query);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_OBJ);
	}

	public static function provento_anual($tipo, $ano)
	{
		$conexao = Bd::conectar();
		if($tipo=="ambos"){
			$query = "SELECT cod,SUM(valor_recebido) as Total,data_recebido,tipo_provento FROM proventos WHERE proventos.tipo_provento='dividendo' && proventos.data_recebido LIKE '$ano%' GROUP BY proventos.cod UNION SELECT cod,SUM(valor_recebido) as Total,data_recebido,tipo_provento FROM proventos WHERE proventos.tipo_provento='jcp' && proventos.data_recebido LIKE '$ano%' GROUP BY proventos.cod ORDER BY cod;";
		}else{
			$query = "SELECT cod,SUM(valor_recebido) as Total,data_recebido,tipo_provento FROM proventos WHERE proventos.tipo_provento='$tipo'&& proventos.data_recebido LIKE '$ano%' GROUP BY proventos.cod;";
		}

		$stmt = $conexao->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}



	public static function provento_mensal($data_i, $data_f)
	{
		$conexao = Bd::conectar();
		$query = "SELECT  p.cod,p.tipo_provento,p.data_recebido,p.valor_recebido FROM proventos AS p
			WHERE p.data_recebido BETWEEN :data_inicial and :data_final";

		$stmt = $conexao->prepare($query);
		$stmt->bindValue(':data_inicial', $data_i);
		$stmt->bindValue(':data_final', $data_f);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}




	public static function adicionar_ativo(Investimentos $ativo)
	{
		$conexao = Bd::conectar();
		$query = "INSERT INTO ativos(cod,cnpj,preco,quant,total_investido)VALUES(:cod,:cnpj,:preco_ativo,:quant_ativo,:valor_total_ativo);";
			
		$stmt = $conexao->prepare($query);
		$stmt->bindValue(":cod", $ativo->__get('cod'));
		$stmt->bindValue(":cnpj", $ativo->__get('cnpj'));
		$stmt->bindValue(":preco_ativo", $ativo->__get('preco_ativo'));
		$stmt->bindValue(":quant_ativo", $ativo->__get('quant_ativo'));
		$stmt->bindValue(":valor_total_ativo", $ativo->__get('valor_total_ativo'));

		$stmt->execute();
	}

	public static function adicionar_provento(Investimentos $provento)
	{
		$conexao = Bd::conectar();
		$query = "INSERT INTO proventos(cod,data_recebido,valor_recebido,tipo_provento) VALUES (:cod, :data_provento, :valor_provento, :tipo_provento)";
	
		$stmt = $conexao->prepare($query);
		$stmt->bindValue(":cod", $provento->__get("cod"));
		$stmt->bindValue(":valor_provento", $provento->__get("valor_provento"));
		$stmt->bindValue(":data_provento", $provento->__get("data_provento"));
		$stmt->bindValue(":tipo_provento", $provento->__get("tipo_provento"));
	    $stmt->execute();
	}

	public static function deletar_ativo($id)
	{
		$conexao = Bd::conectar();
		$query = "DELETE FROM ativos WHERE ativos.id =:id";

		$stmt = $conexao->prepare($query);
		$stmt->bindValue(":id", $id);

		$stmt->execute();
	}
}


$acao = isset($_GET['acao']) ? $_GET['acao'] : "nada recebido";

if ($acao == "todos_dados" || $acao == "procurar_cnpj") {
	$dados = Bd::todos_dados();
	print_r(json_encode($dados));
} elseif ($acao == "provento_anual") {
	$tipo=$_GET['tipo'];
	$ano=$_GET['ano'];
	$dados = Bd::provento_anual($tipo,$ano);
	print_r(json_encode($dados));

} elseif ($acao == "provento_mensal") {
	$data = explode('/',$_GET['data']);
	$dias = cal_days_in_month(CAL_GREGORIAN, intval($data[0]), $data[1]);
	$data_i = "$data[1]-" . "$data[0]-" . '01';
	$data_f = "$data[1]-" . "$data[0]-" . "$dias";
	$dados3 = Bd::provento_mensal($data_i, $data_f);
	print_r(json_encode($dados3));
} elseif ($acao == "inserir") {
	if ((isset($_POST['cod']) && !empty($_POST['cod'])) && (isset($_POST['cnpj']) && !empty($_POST['cnpj'])) && (isset($_POST['quant_ativo']) && !empty($_POST['quant_ativo'])) && (isset($_POST['preco_ativo']) && !empty($_POST['preco_ativo']))) {
		$valor=str_replace(",",".",$_POST['preco_ativo']);
		$investimento = new Investimentos();
		$investimento->__set("cod", strtoupper($_POST['cod']));
		$investimento->__set("cnpj", $_POST['cnpj']);
		$investimento->__set("preco_ativo", $valor);
		$investimento->__set("quant_ativo", $_POST['quant_ativo']);
		$investimento->__set("valor_total_ativo", $investimento->__get('preco_ativo') * $investimento->__get('quant_ativo'));
		Bd::adicionar_ativo($investimento);
		header('location:adicionar_investimento.php?retorno=cadastrado');
	} else {
		header('location:adicionar_investimento.php?retorno=erro');
	}
} elseif ($acao == "inserir_provento") {
	$valor=str_replace(",",".",$_POST['valor_provento']);
	$provento = new Investimentos();
	$provento->__set("cod", strtoupper($_POST['cod']));
	$provento->__set("valor_provento", $valor);
	$provento->__set("data_provento", $_POST['data_provento']);
	$provento->__set("tipo_provento", $_POST['tipo_provento']);

	Bd::adicionar_provento($provento);
	header('location:adicionar_provento.php?retorno=cadastrado');

} elseif (isset($_POST['id'])) {
	Bd::deletar_ativo($_POST['id']);
} elseif ($acao == "nada recebido") {

	echo("nada");
}

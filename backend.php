<?php
	class Investimentos{
		private $id;
		private $cod;
		private $cnpj;
		private $quant_ativo;
		private $preco_ativo;
		private $valor_total_ativo;
		private $valor_provento;
		private $data_provento;
		private $tipo_provento;


		public function __get($atribute){
			return $this->$atribute;
		}

		public function __set($atribute,$value){
			$this->$atribute=$value;
		}



	}

	class Bd{
		

		public static function conectar(){

			static $local_banco='localhost';
			static $nome_banco='investimentos';
			static $usuario='root';
			static $senha='';



			try {
				$conexao=new PDO("mysql:host=$local_banco;dbname=$nome_banco",$usuario,$senha);

				return $conexao;
				
			} catch (PDOException $e) {
				 echo "Algo deu errado verifique a mensagem a seguir para mais informações <strong>MENSAGEM: </strong>$e";
			}
		}

		public static function todos_dados(){
			$conexao=Bd::conectar();
			$query="SELECT tbA.id,tbA.cod,tbA.cnpj,tbP.quant,tbP.preco,tbP.total_investido from ativos AS tbA LEFT JOIN posicao AS tbP ON(tbA.id=tbP.id_ativo)";
			

			$consulta=$conexao->prepare($query);
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_OBJ);
		}

		public static function provento_anual(){
			$conexao=Bd::conectar();
			$query="SELECT  a.cod,p.tipo_provento,ROUND(SUM(valor_recebido),2) AS Total FROM proventos AS p INNER JOIN ativos as a ON(fk_cod_ativo=a.id) WHERE p.tipo_provento='jcp' GROUP BY a.cod UNION
			SELECT  a.cod,p.tipo_provento, ROUND(SUM(valor_recebido),2) AS Total FROM proventos AS p INNER JOIN ativos as a ON(fk_cod_ativo=a.id) WHERE p.tipo_provento='dividendo' GROUP BY a.cod ORDER BY cod";

			$stmt=$conexao->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);

		}



		public static function provento_mensal($data_i,$data_f){
			$conexao=Bd::conectar();
			$ativos_consulta=Bd::todos_dados();
			$query="SELECT  a.cod,p.tipo_provento,p.data_recebido,p.valor_recebido FROM proventos AS p INNER JOIN ativos as a ON(fk_cod_ativo=a.id)
			WHERE p.data_recebido BETWEEN :data_inicial and :data_final";

			$stmt=$conexao->prepare($query);
			$stmt->bindValue(':data_inicial',$data_i);
			$stmt->bindValue(':data_final',$data_f);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}



		
		public static function adicionar_ativo(Investimentos $ativo){
			$conexao=Bd::conectar();
			$query="INSERT INTO ativos(cod,cnpj)VALUES(:cod,:cnpj);
			INSERT INTO posicao(id_ativo)SELECT id FROM ativos WHERE cod=:cod;
			UPDATE posicao SET preco=:preco_ativo,quant=:quant_ativo,total_investido=:valor_total_ativo WHERE id_ativo=(SELECT id FROM ativos WHERE cod=:cod);";

			$stmt=$conexao->prepare($query);
			$stmt->bindValue(":cod",$ativo->__get('cod'));
			$stmt->bindValue(":cnpj",$ativo->__get('cnpj'));
			$stmt->bindValue(":preco_ativo",$ativo->__get('preco_ativo'));
			$stmt->bindValue(":quant_ativo",$ativo->__get('quant_ativo'));
			$stmt->bindValue(":valor_total_ativo",$ativo->__get('valor_total_ativo'));

			$stmt->execute();

		}

		

	}


	$acao=isset($_GET['acao'])? $_GET['acao']:"nada recebido";
	
	if ($acao=="todos_dados"||$acao=="procurar_cnpj") {
		$dados=Bd::todos_dados();
		print_r(json_encode($dados));
	}elseif ($acao=="provento_anual") {
		$dados2=Bd::provento_anual();
		print_r(json_encode($dados2));
	}elseif($acao=="provento_mensal"){
		$mes=$_GET['data'];
		$dias=cal_days_in_month(CAL_GREGORIAN, intval($mes), 2022);
		$data_i='2022-'."$mes-".'01';
		$data_f='2022-'."$mes-"."$dias";
		$dados3=Bd::provento_mensal($data_i,$data_f);
		print_r(json_encode($dados3));
	}elseif($acao=="inserir"){
		if ((isset($_POST['cod']) && !empty($_POST['cod'])) && (isset($_POST['cnpj']) && !empty($_POST['cnpj'])) && (isset($_POST['quant_ativo']) && !empty($_POST['quant_ativo'])) && (isset($_POST['preco_ativo']) && !empty($_POST['preco_ativo'])) ) {

			    $investimento=new Investimentos();
			    $investimento->__set("cod",$_POST['cod']);
				$investimento->__set("cnpj",$_POST['cnpj']);
				$investimento->__set("preco_ativo",$_POST['preco_ativo']);
				$investimento->__set("quant_ativo",$_POST['quant_ativo']);
				$investimento->__set("valor_total_ativo",$investimento->__get('preco_ativo')*$investimento->__get('quant_ativo'));
	        	Bd::adicionar_ativo($investimento); 	
			    header('location:adicionar_investimento.php?retorno=cadastrado');
				


		}else{
			   header('location:adicionar_investimento.php?retorno=erro');
		}


	} elseif ($acao=="nada recebidod") {
		
		$investimento=new Investimentos();
		$investimento->__set("cod","pdgr3");
		$investimento->__set("cnpj","1223233232");
		$investimento->__set("preco_ativo",13.5);
		$investimento->__set("quant_ativo",100);
		$investimento->__set("valor_total_ativo",$investimento->__get('preco_ativo')*$investimento->__get('quant_ativo'));

		Bd::adicionar_ativo($investimento);
	}



?>
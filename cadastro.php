<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php

include 'conexao.php';
session_start();

if(isset($_POST["registrar"])){

    $Nome = $_POST["nome"];
	$Email = $_POST["email"];
	$Senha = $_POST["senha"];
    $Uti = $_POST["uti"];
    $Enfermagem = $_POST["enfermagem"];

    try{
        $Comando=$conn->prepare("INSERT INTO hospital(nome, email, senha, total_UTI, total_enfermaria ) VALUES ( ?, ?, ?, ?, ?)");
        
        $Comando->bindParam(1, $Nome);
        $Comando->bindParam(2, $Email);
        $Comando->bindParam(3, $Senha);
        $Comando->bindParam(4, $Uti); 
        $Comando->bindParam(5, $Enfermagem);
                    
        if ($Comando->execute()){
            if ($Comando->rowCount() >0){
                echo "<script> alert('Cadastro Realizado com Sucesso!')</script>"; 

                $sql = $conn->prepare("SELECT id_hospital FROM hospital WHERE email = ?");
                $sql->bindParam(1, $Email);
                
                

                if ($sql->execute()) {
                    $res = $sql->fetch(PDO::FETCH_ASSOC);
                    $idH = $res['id_hospital'];

                    
                    try {
                        $n=1;
                        for ($i=0; $i < (int)$Uti; $i++) {                             
                            $Comando=$conn->prepare("INSERT INTO leitos(tipo_leito, num_leito, id_hospital) VALUES ( 'UTI',?, ?)");
                            $Comando->bindParam(1, $n);
                            $Comando->bindParam(2, $idH);
                            $Comando->execute();
                            $n++;
                        }
                        $n=1;
                        for ($i=0; $i < (int)$Enfermagem; $i++) { 
                            $query=$conn->prepare("INSERT INTO leitos(tipo_leito, num_leito, id_hospital) VALUES ( 'Enfermaria',?, ?)");
                            $query->bindParam(1, $n);
                            $query->bindParam(2, $idH);
                            $query->execute();
                            $n++;
                        }
                    } catch (\Throwable $th) {
                        throw $th;
                    }

                    $Nome = null; 
                    $Email = null;
                    $Senha = null;
                    $Uti = null; 	
                    $Enfermagem = null;

                    header('Refresh: 0; url=login.php');
                    
                }
                
            
            } else{
                echo "Erro ao tentar efetivar o regitro.";
            }
        } else{ 
            throw new PDOException("Erro: Não foi possivel executar a declaração sql.");
        }     
    }
    catch (PDOException $erro){
        echo"Erro" . $erro->getMessage();
    }

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Cadastro</title>
</head>
<body>
	<div class="register">
    <svg xmlns="http://www.w3.org/2000/svg" width="110.64" height="59.211" viewBox="0 0 94.64 43.211"><g transform="translate(-99.36 -35.789)"><path d="M1.36,10.31V-14h9.759A8.505,8.505,0,0,1,16.9-12.246a5.715,5.715,0,0,1,2,4.5,5.275,5.275,0,0,1-1.233,3.664,6.149,6.149,0,0,1-3,1.858A5.8,5.8,0,0,1,18.1-.161a5.867,5.867,0,0,1,1.354,3.837A6.121,6.121,0,0,1,17.37,8.434a8.524,8.524,0,0,1-5.9,1.875ZM5.805-3.79h4.654a4.288,4.288,0,0,0,2.882-.868,3.079,3.079,0,0,0,1.007-2.466,3.075,3.075,0,0,0-.99-2.414,4.334,4.334,0,0,0-2.969-.886H5.805Zm0,10.488h4.966a4.638,4.638,0,0,0,3.073-.92A3.2,3.2,0,0,0,14.939,3.19,3.32,3.32,0,0,0,13.793.516,4.621,4.621,0,0,0,10.7-.456h-4.9ZM20.252,10.31V-14H36.123l-2.064,3.577H24.7v6.668H35.081l-3.092,3.3L24.7-.282V6.733H36.123L34.059,10.31Zm17.051,0V-14h8.3a13.071,13.071,0,0,1,7.154,1.754c2.783,1.437,3.085,2.176,3.976,3.994a14.4,14.4,0,0,1,1.337,6.407,14.4,14.4,0,0,1-1.337,6.407C55.843,6.38,55.54,7,52.758,8.434A13.216,13.216,0,0,1,45.6,10.31Zm4.445-3.82H45.4a9.932,9.932,0,0,0,4.827-.99,5.633,5.633,0,0,0,2.535-2.848,11.822,11.822,0,0,0,.764-4.5,11.853,11.853,0,0,0-.764-4.48,5.707,5.707,0,0,0-2.535-2.882A9.788,9.788,0,0,0,45.4-10.215H41.749Z" transform="translate(98 49.789)" fill="#6a7bff"/><text transform="translate(116 74)" fill="#c5cbdf" font-size="18" font-family="OpenSans-SemiBold, Open Sans" font-weight="600"><tspan x="0" y="0">manager</tspan></text></g></svg>
		<form action="" method="post">
            <h1>Cadastro</h1>
            <input type="text" name="nome" placeholder="Nome da instituição"><br>
			<input type="email" name="email" placeholder="E-mail de Acesso"><br>
            <input type="password" name="senha" placeholder="Senha de Acesso"><br>
            <p>Total de leitos</p>
            <div class="group-leito">
                <input type="number" name="uti" id="" placeholder="UTI">
                <input type="number" name="enfermagem" id="" placeholder="Enfermaria">
            </div>
			<input type="submit" name="registrar" value="Cadastrar">  
        </form>	
	</div>
</body>
</html>
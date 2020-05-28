<?php
include 'conexao.php';

if (isset($_POST['alterar'])) {
    $nome = $_POST["nome_paciente"];
    $nasc= $_POST["nasc"];
    $leito = $_POST["leito"];
    $id = $_GET['id'];
    
    try{  
        $Comando=$conn->prepare("UPDATE pacientes SET nome=?, nascimento=?, id_leito=? WHERE id_paciente=?");
        
        $Comando->bindParam(1, $nome);
        $Comando->bindParam(2, $nasc);
        $Comando->bindParam(3, $leito);
        $Comando->bindParam(4, $id);
                         
        if ($Comando->execute()){
            if ($Comando->rowCount() >0){
                echo "<script> alert('Dados Alterados com sucesso!!')</script>"; 
                $nome = null;
                $nasc = null;
                $leito = null;
                $id = null;
                header('Refresh: 0; url=home.php');
            
            } else{
                echo "Erro ao tentar Alterar Dados";
            }
        } else{ 
            
            throw new PDOException("Erro: Não foi possivel executar a declaração sql.");
        
        }    
   }catch (PDOException $erro){
       echo"Erro" . $erro->getMessage();
   }
}


?>

<!DOCTYPE html>
<html lang="pt-bt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Alterar dados</title>
</head>
<body>

<div class="contAlterar">
    <div class="add_paciente">
    <h2>Alterar Dados</h2>
    <?php
    $id = $_GET['id'];

    $Comando=$conn->prepare("SELECT * FROM pacientes
    WHERE id_paciente = ?");   

    $Comando->bindParam(1, $id);

    if ($Comando->execute()){
        if ($Comando->rowCount() >0){ 
            while($Linha = $Comando->fetch(PDO::FETCH_OBJ)){
                $nome = $Linha->nome;
                $nasc = $Linha->nascimento;
                $id_leito = $Linha->id_leito;

                $sql = $conn->prepare("SELECT num_leito FROM leitos WHERE id_leito = ?");
                $sql->bindParam(1, $id_leito);
                $sql->execute();
                $res = $sql->fetch(PDO::FETCH_ASSOC);
                $leito = $res['num_leito'];
            
    ?>
        <form action="" method="post">
            <input type="text" class="txt"name="nome_paciente" id="nome_paciente" value="<?php echo $nome ?>">
            <div class="group_input">
                <input type="date" name="nasc" id="nasc" value="<?php echo $nasc?>" >
                <input type="number" name="leito" id="leito" value="<?php echo $leito?>">  
            </div>
            <input type="submit" name="alterar"value="Alterar">
        </form>
    <?php
            }
        }
    }
    
    ?>
    </div> 
</div>
   
</body>
</html>


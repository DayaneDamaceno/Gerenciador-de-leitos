<?php
include 'conexao.php';
session_start();

if (isset($_POST['alterar'])) {
    $nome = $_POST["nome_paciente"];
    $nasc= $_POST["nasc"];
    $leito = $_POST["leito"];
    $id = $_GET['id'];
    $id_leito = $_GET['lt'];
    $tipoLeito = $_GET['tp'];
    
    
    try{  
        $smd = $conn->prepare("SELECT id_leito from leitos where num_leito= ? and tipo_leito= ? and id_hospital= ?");
        $smd->bindParam(1, $leito);
        $smd->bindParam(2, $tipoLeito);
        $smd->bindParam(3, $_SESSION['id']);
        $smd->execute();
        $response = $smd->fetch(PDO::FETCH_ASSOC);
        $new_leito = $response['id_leito'];

        if ($id_leito != $new_leito) {
            $sql= $conn->prepare("UPDATE leitos SET status_leito='Disponivel' WHERE id_leito=?");
            $sql->bindParam(1, $id_leito);
            $sql->execute();

            if ($rep['status_leito'] == 'Ocupado') {
                echo "<script> alert('Leito ja está ocupado')</script>"; 
                header('Refresh: 0; url=alterar.php');
                return;
            }else {
                $sql= $conn->prepare("SELECT * FROM leitos where id_leito=?");
                $sql->bindParam(1, $new_leito);
                $sql->execute();
                $rep= $sql->fetch(PDO::FETCH_ASSOC); 

                $Comando=$conn->prepare("UPDATE pacientes SET nome=?, nascimento=?, id_leito=? WHERE id_paciente=? and id_hospital=?");
        
                $Comando->bindParam(1, $nome);
                $Comando->bindParam(2, $nasc);
                $Comando->bindParam(3, $new_leito);
                $Comando->bindParam(4, $id);
                $Comando->bindParam(5, $_SESSION['id']);
                                
                if ($Comando->execute()){
                    if ($Comando->rowCount() >0){
                        $sql=$conn->prepare("UPDATE leitos SET status_leito='Ocupado' WHERE id_leito=?");
                        $sql->bindParam(1, $new_leito);
                        $sql->execute();
                        echo "<script> alert('Dados Alterados com sucesso!!')</script>"; 
                        $nome = null;
                        $nasc = null;
                        $leito = null;
                        $id = null;
                        $id_leito = null;
                        $tipoLeito = null;
                        header('Refresh: 0; url=home.php');
                    
                    } else{
                        echo "Erro ao tentar Alterar Dados";
                    }
                } else{ 
                    
                    throw new PDOException("Erro: Não foi possivel executar a declaração sql.");
                
                }  
            }
        }else{
            $Comando=$conn->prepare("UPDATE pacientes SET nome=?, nascimento=?, id_leito=? WHERE id_paciente=? and id_hospital=?");
        
            $Comando->bindParam(1, $nome);
            $Comando->bindParam(2, $nasc);
            $Comando->bindParam(3, $id_leito);
            $Comando->bindParam(4, $id);
            $Comando->bindParam(5, $_SESSION['id']);
                            
            if ($Comando->execute()){
                if ($Comando->rowCount() >0){
                    echo "<script> alert('Dados Alterados com sucesso!!')</script>"; 
                    $nome = null;
                    $nasc = null;
                    $leito = null;
                    $id = null;
                    $id_leito = null;
                    $tipoLeito = null;
                    header('Refresh: 0; url=home.php');
                
                } else{
                    echo "Erro ao tentar Alterar Dados";
                }
            } else{ 
                
                throw new PDOException("Erro: Não foi possivel executar a declaração sql.");
            
            }   
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


<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php
include 'conexao.php';

$id = $_GET['id'];

try{  
    $sql=$conn->prepare("SELECT id_leito from pacientes where id_paciente=?");
    $sql->bindParam(1, $id);
    $sql->execute();
    $res = $sql->fetch(PDO::FETCH_ASSOC);
    $leito = $res['id_leito'];

    $Comando=$conn->prepare('DELETE FROM pacientes WHERE id_paciente=?');
    $Comando->bindParam(1, $id);
                
    if ($Comando->execute()){
        if ($Comando->rowCount() >0){
            $sql=$conn->prepare(
                "UPDATE leitos SET status_leito = 'Disponivel' 
                WHERE id_leito = ?");
            $sql->bindParam(1, $leito);

            if ($sql->execute()) {
                echo "<script> alert('Paciente removido com sucesso!!')</script>"; 
                $id = null;

                header('Refresh: 0; url=home.php'); 
            }

        } else{
            echo "Erro ao tentar remover paciente";
        }
    } else{ 
        
        throw new PDOException("Erro: Não foi possivel executar a declaração sql.");
    
    }    
}catch (PDOException $erro){
   echo"Erro" . $erro->getMessage();
}



?>
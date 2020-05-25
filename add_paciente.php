<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php
include 'conexao.php';
session_start();

if (isset($_POST["add"])) {

    $nome = $_POST["nome_paciente"];
    $nasc= $_POST["nasc"];
    $leito = $_POST["leito"];
    $tipoLeito = $_POST["tipo_leito"];
    date_default_timezone_set('America/Sao_Paulo');
    $hora_entrada = Date('H:i');
    $data_entrada = Date('Y/m/d');
    
    try{  
        $smd = $conn->prepare("SELECT id_leito from leitos where num_leito= ? and tipo_leito= ? and id_hospital= ?");
        $smd->bindParam(1, $leito);
        $smd->bindParam(2, $tipoLeito);
        $smd->bindParam(3, $_SESSION['id']);
        $smd->execute();
        $response = $smd->fetch(PDO::FETCH_ASSOC);
        $id_leito = $response['id_leito'];


        $sql = $conn->prepare("SELECT tipo_leito, status_leito FROM leitos WHERE id_leito = ?");
        $sql->bindParam(1, $id_leito);
        $sql->execute();
        $res = $sql->fetch(PDO::FETCH_ASSOC);
        $tipo = $res['tipo_leito'];
        $status = $res['status_leito'];
                    
        if ($tipo === $tipoLeito and $status === 'Disponivel'){

            $Comando=$conn->prepare(
                "INSERT INTO pacientes(nome, nascimento, id_leito, hora_entrada, data_entrada, id_hospital)
                VALUES (?, ?, ?, ?, ?, ?)");
            
            $Comando->bindParam(1, $nome);
            $Comando->bindParam(2, $nasc);
            $Comando->bindParam(3, $id_leito);
            $Comando->bindParam(4, $hora_entrada);
            $Comando->bindParam(5, $data_entrada);
            $Comando->bindParam(6, $_SESSION['id']);
            
            if ($Comando->execute()){
                 if ($Comando->rowCount() >0) {

                    $sql=$conn->prepare(
                        "UPDATE leitos SET status_leito = 'Ocupado' 
                        WHERE id_leito = ? and tipo_leito=?");
                    $sql->bindParam(1, $id_leito);
                    $sql->bindParam(2, $tipoLeito);

                    if ($sql->execute()) {

                        echo "<script> alert('Paciente Adicionado com sucesso!!')</script>"; 
                        $nome = null;
                        $idade = null;
                        $leito = null;
                        $hora_entrada = null;
                        $data_entrada = null;
                        $tipoLeito = null; 
    
                        header('Refresh: 0; url=home.php');
                    }else{
                        echo "<script> alert('Erro ao tentar cadastrar paciente')</script>";
                        header('Refresh: 0; url=home.php');
                    }   
                } else {
                    echo "<script> alert('Erro ao tentar cadastrar paciente')</script>";
                    header('Refresh: 0; url=home.php');
                } 
            } else{
                throw new PDOException("Erro: Não foi possivel executar a declaração sql.");
            }
        } else{ 
           echo "<script> alert('Erro ao tentar cadastrar paciente')</script>";
           header('Refresh: 0; url=home.php');
        }    
   }catch (PDOException $erro){
       if (strrpos($erro->getMessage(),"Integrity constraint violation: 1062")) {
           echo "<script>alert('O Leito informado está ocupado')</script>";
       }else{
         echo"Erro" . $erro->getMessage();
       }
      
   }

}
?>
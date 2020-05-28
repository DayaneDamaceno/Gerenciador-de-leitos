<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php
include 'conexao.php';
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gerenciador de Leitos</title>
</head>
<body>
    
<header>
<svg xmlns="http://www.w3.org/2000/svg" width="94.64" height="43.211" viewBox="0 0 94.64 43.211"><g transform="translate(-99.36 -35.789)"><path d="M1.36,10.31V-14h9.759A8.505,8.505,0,0,1,16.9-12.246a5.715,5.715,0,0,1,2,4.5,5.275,5.275,0,0,1-1.233,3.664,6.149,6.149,0,0,1-3,1.858A5.8,5.8,0,0,1,18.1-.161a5.867,5.867,0,0,1,1.354,3.837A6.121,6.121,0,0,1,17.37,8.434a8.524,8.524,0,0,1-5.9,1.875ZM5.805-3.79h4.654a4.288,4.288,0,0,0,2.882-.868,3.079,3.079,0,0,0,1.007-2.466,3.075,3.075,0,0,0-.99-2.414,4.334,4.334,0,0,0-2.969-.886H5.805Zm0,10.488h4.966a4.638,4.638,0,0,0,3.073-.92A3.2,3.2,0,0,0,14.939,3.19,3.32,3.32,0,0,0,13.793.516,4.621,4.621,0,0,0,10.7-.456h-4.9ZM20.252,10.31V-14H36.123l-2.064,3.577H24.7v6.668H35.081l-3.092,3.3L24.7-.282V6.733H36.123L34.059,10.31Zm17.051,0V-14h8.3a13.071,13.071,0,0,1,7.154,1.754c2.783,1.437,3.085,2.176,3.976,3.994a14.4,14.4,0,0,1,1.337,6.407,14.4,14.4,0,0,1-1.337,6.407C55.843,6.38,55.54,7,52.758,8.434A13.216,13.216,0,0,1,45.6,10.31Zm4.445-3.82H45.4a9.932,9.932,0,0,0,4.827-.99,5.633,5.633,0,0,0,2.535-2.848,11.822,11.822,0,0,0,.764-4.5,11.853,11.853,0,0,0-.764-4.48,5.707,5.707,0,0,0-2.535-2.882A9.788,9.788,0,0,0,45.4-10.215H41.749Z" transform="translate(98 49.789)" fill="#6a7bff"/><text transform="translate(116 74)" fill="#c5cbdf" font-size="18" font-family="OpenSans-SemiBold, Open Sans" font-weight="600"><tspan x="0" y="0">manager</tspan></text></g></svg>
<a href="logout.php">
    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="24.004" viewBox="0 0 31 34.004"><g transform="translate(-2.493 -1)"><path d="M27.54,9.96a13.5,13.5,0,1,1-19.095,0" fill="none" stroke="#ff6464" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/><path d="M18,3V18" fill="none" stroke="#ff6464" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/></g></svg>
</a>
</header>

<div class="container_completo">
    <div class="conteudo_info">

        <h3><?php echo $_SESSION['nome']; ?></h3>  
        <div class="info">
            <p>Total de leitos</p>
            <div class="info-tot">
                <div class="info_leitos">
                <p>UTI</p>
                <h1><?php echo $_SESSION['totUTI']; ?></h1>
                </div>
                <div class="info_leitos">
                    <p>Enfermaria</p>
                    <h1><?php  echo $_SESSION['totEnf'];  ?></h1>
                </div>
            </div>
            <p>Disponiveis</p>
            <div class="info_disponivel">    
            <?php
                 $Comando=$conn->prepare("SELECT COUNT(*) as total FROM leitos where id_hospital = ? and status_leito='Disponivel' and tipo_leito='UTI'");
                 $Comando->bindParam(1, $_SESSION['id']);   
                             
                 if ($Comando->execute()){
                     if ($Comando->rowCount() >0){ 
                         while($Linha = $Comando->fetch(PDO::FETCH_OBJ)){
                             $total_UTI= $Linha->total;
 
                             ?>
                             <div class="uti format">
                             <p>UTI</p>
                             <h1><?php echo $total_UTI;?></h1>
                             </div>
                             <?php
                         }
                     }
                 }
                 $Comando=$conn->prepare("SELECT COUNT(*) as total FROM leitos where id_hospital = ? and status_leito='Disponivel' and tipo_leito='Enfermaria'");
                $Comando->bindParam(1, $_SESSION['id']);   
                            
                if ($Comando->execute()){
                    if ($Comando->rowCount() >0){ 
                        while($Linha = $Comando->fetch(PDO::FETCH_OBJ)){
                            $total_Enf= $Linha->total;
                            ?>
                            <div class="enfermaria format">
                            <p>Enfermaria</p>
                            <h1><?php echo $total_Enf;?></h1>
                            </div> 
                            <?php
                        }
                    }
                }
            ?>            
            </div>
        </div>
    </div>

    <div class="conteudo">
        <div class="add_paciente">
            <h2>Adicionar novo paciente</h2>
            <form action="add_paciente.php" method="post">
                <input type="text" class="txt"name="nome_paciente" id="nome_paciente" placeholder="Nome do paciente">
                <div class="group_input">
                    <input type="date" name="nasc" id="nasc" placeholder="Data de nascimento">
                    <input type="number" name="leito" placeholder="Leito"> 
                    <select name="tipo_leito" id="" placeholder="Tipo do leito">
                        <option value="UTI">UTI</option>
                        <option value="Enfermaria">Enfermaria</option>
                    </select> 
                     
                </div>
                <input type="submit" name="add"value="Adicionar">
            </form>
        </div>

        <div class="consultar_paciente">
            <h2>Consultar paciente</h2>
            <form action="" method="post">   
                <input type="text" name="nomepaciente" id="nome_paciente" placeholder="Nome do paciente">
                <input type="submit" name="consultar" value="Consultar">
            </form>
            <?php
                if (isset($_POST["consultar"])) {

                $nome = '%' . $_POST["nomepaciente"] . '%';

                $Comando=$conn->prepare("SELECT * FROM pacientes
                WHERE nome LIKE ? and id_hospital=?");   
                
                $Comando->bindParam(1, $nome);
                $Comando->bindParam(2, $_SESSION['id']);
                
                if ($Comando->execute()){
                    if ($Comando->rowCount() >0){ 
                        $res = $Comando->fetch(PDO::FETCH_ASSOC);
                        $idd = $res['id_leito'];

                        $hora = date('H:i', strtotime($res['hora_entrada']));
                        $data = date('d/m/Y', strtotime($res['data_entrada']));

                        $sql=$conn->prepare(" SELECT tipo_leito, num_leito
                        from leitos  
                        where id_leito = ?");

                        $sql->bindParam(1, $idd);
                         
                        if ($sql->execute()){
                            if ($sql->rowCount() >0){ 
                                $resul = $sql->fetch(PDO::FETCH_ASSOC);
                            }
                        }
                        ?>
                            <div class="item">
                                <div class="dados">
                                    <p>Leito <?php echo $resul['tipo_leito'];?> - <?php echo $resul['num_leito']?></p>
                                    <p>Paciente: <?php echo $res['nome'];?></p>
                                    <p>Hora de Entrada: <?php echo $hora?></p>
                                    <p>Data de Entrada: <?php echo $data?></p>
                                </div>
                                <div class="acoes">
                                    <a href="alterar.php?id=<?php echo $res['id_paciente']?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15.436" height="19.874" viewBox="0 0 25.436 19.874"><path d="M0,9.5V8.706A1.192,1.192,0,0,1,1.192,7.514H19.077V5.129a1.193,1.193,0,0,1,2.035-.843l3.974,3.974a1.192,1.192,0,0,1,0,1.686l-3.974,3.974a1.193,1.193,0,0,1-2.035-.843V10.693H1.192A1.192,1.192,0,0,1,0,9.5Zm24.244,7.551H6.359V14.668a1.193,1.193,0,0,0-2.035-.843L.349,17.8a1.192,1.192,0,0,0,0,1.686L4.324,23.46a1.193,1.193,0,0,0,2.035-.843V20.232H24.244a1.192,1.192,0,0,0,1.192-1.192v-.795A1.192,1.192,0,0,0,24.244,17.052Z" transform="translate(0 -3.936)" fill="#00b28e"/></svg>
                                    </a>
                                    <a href="deletar.php?id=<?php echo $res['id_paciente']?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13.391" height="22.44" viewBox="0 0 21.391 22.44"><g transform="translate(2.827 2.827)"><line x2="15.737" y2="16.786" fill="none" stroke="#ff6464" stroke-linecap="round" stroke-width="4"/><line y1="16.786" x2="15.737" fill="none" stroke="#ff6464" stroke-linecap="round" stroke-width="4"/></g></svg>
                                    </a>
                                </div>
                            </div>
                        <?php
                    }                         
                }    
            }
            
            ?> 
            
        </div>  

    </div>
</div>

</body>
</html>
<?php
    include_once('config.php');

    $sql = "SELECT dia, horario FROM cliente";
    $reservas = mysqli_query($conexao,$sql);

    $ocupados = [];

    while($row = mysqli_fetch_assoc($reservas)){
        $chave = $row['dia'] . '-' . $row['horario'];
        $ocupados[] = $chave;
    }
    
    if(isset($_POST['enviar']) && !empty($_POST['nome']) && !empty($_POST['telefone'])){
        $nome = trim($_POST['nome']);
        $telefone = trim($_POST['telefone']);
        $dia = trim($_POST['dia']);
        $horario = trim($_POST['horario']);
        $servico = trim($_POST['servico']);

        if(empty($nome) || empty($telefone)){
            echo "Nome e telefone são obrigatórios!";
            exit;
        }

        if($nome == 'admin@01' && $telefone == '83912345678'){
            header("Location: reservas.php");
            exit;
        }
        
        $sql = "INSERT INTO cliente(nome,telefone,dia,horario,servico) VALUES ('$nome','$telefone','$dia','$horario','$servico')";

        mysqli_query($conexao, $sql);

        header("Location: confirm.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbearia Império</title>
    <link rel="stylesheet" href="Assents/style4.css">
</head>
<body id="5">
    <header>
        <div class="barra-menu">
            <div class="logo">
                <a href="home.php#1"><img src="Assents/logo1.png" alt="logo1"></a>
            </div>
            <nav class="menu">
                <ul>
                    <li><a class="menu-itens" href="home.php#2"><strong>SOBRE NÓS</strong></a></li>
                    <li><a class="menu-itens" href="servicos.php#home1"><strong>SERVIÇOS</strong></a></li>
                    <li><a class="menu-itens" href="home.php#3"><strong>CONTATO</strong></a></li>
                    <li><a class="menu-itens" href="home.php#4"><strong>LOCALIZAÇÃO</strong></a></li>
                </ul>
            </nav>
        </div>    
    </header>
    <div class="forms">
        <?php 
            $sql = "SELECT dia, horario FROM cliente";
            $reservas = mysqli_query($conexao,$sql);

            $ocupados = [];

            while($row = mysqli_fetch_assoc($reservas)){
                $chave = $row['dia'] . '-' . $row['horario'];
                $ocupados[] = $chave;
            }
        ?>
        <form action="formulario.php" method="POST">
            <fieldset>
                <legend><b>Formulário de Agendamento</b></legend>
                <div>
                    <label for="dados1"><b>Nome Completo:</b></label><br>
                    <input type="text" name="nome" id="nome" required>
                </div>
                <br>
                <div>
                    <label for="dados2"><b>Telefone:</b></label><br>
                    <input type="tel" name="telefone" placeholder="83912345678" pattern="[0-9]{11}" required><br>
                    <small>Exemplo: 83912345678</small>
                </div>
                <br>
                <div>
                    <label for="dados3"><b>Dia da Semana:</b></label><br>
                    <select name="dia" required>
                        <option value="domingo">Domingo</option>
                        <option value="segunda">Segunda-feira</option>
                        <option value="terca">Terça-feira</option>
                        <option value="quarta">Quarta-feira</option>
                        <option value="quinta">Quinta-feira</option>
                        <option value="sexta">Sexta-feira</option>
                        <option value="sabado">Sábado</option>
                    </select>
                </div> 
                <br>   
                <div>
                    <label for="dados4"><b>Horário:</b></label><br>
                    <select name="horario" id="horario" required>
                        <option value="">Selecione o dia primeiro</option>
                    </select>
                </div>
                <script>
                    const horarios = [
                        "08h-09h",
                        "09h-10h",
                        "10h-11h",
                        "13h-14h",
                        "14h-15h",
                        "15h-16h",
                        "16h-17h"
                    ];

                    const ocupados = <?php echo json_encode($ocupados); ?>;

                    document.querySelector("select[name='dia']").addEventListener("change", function() {
                        const dia = this.value;
                        const selectHorario = document.getElementById("horario");

                        selectHorario.innerHTML = "";

                        horarios.forEach(h => {
                            const chave = dia + "-" + h;
                            const disable = ocupados.includes(chave) ? "disabled" : "";

                            selectHorario.innerHTML += `
                                <option value="${h}" ${disable}>
                                    ${h}${disable ? " (Indisponível)" : ""}
                                </option>`;
                        });
                    });

                </script>
                <br>
                <div>
                    <label for="dados5"><b>Serviço:</b></label><br>
                    <select name="servico" required>
                        <option value="Corte Degradê">Corte Degradê</option>
                        <option value="Corte Degradê Navalhado">Corte Degradê Navalhado</option>
                        <option value="Corte na Tesoura">Corte na Tesoura</option>
                        <option value="Corte Social">Corte Social</option>
                        <option value="Barba">Barba</option>
                        <option value="Sobrancelha Pinça">Sobrancelha na Pinça</option>
                        <option value="Limpeza Sombrancelha">Limpeza de Sombrancelha</option>
                        <option value="Selagem">Selagem</option>
                        <option value="Corte Degradê+Barba">Corte Degradê + Barba</option>
                        <option value="Corte Navalhado+Barba">Corte Navalhado + Barba</option>
                        <option value="Corte Navalhado+Barba+Sobrancelha">Corte Navalhado + Barba + Sobrancelha</option>
                        <option value="Corte Degradê+Sobrancelha">Corte Degradê + Sobrancelha</option>
                        <option value="Corte Tesoura+Barba">Corte Tesoura + Barba</option>
                        <option value="Corte+Pomada">Corte + Pomada</option>
                        <option value="Corte Social+Limpeza Sobrancelha">Corte Social + Limpeza de Sobrancelha</option>
                        <option value="Corte Degradê+Selagem+Sobrancelha">Corte Degradê + Selagem + Sobrancelha</option>
                        <option value="Corte Degradê+Limpeza Sobrancelha">Corte Degradê + Limpeza de Sobrancelha</option>
                        <option value="Corte Social+Limpeza Sobrancelha">Corte Social + Limpeza de Sobrancelha</option>
                    </select>
                </div>
                <br>
                <div>
                    <input type="submit" name="enviar">
                </div>
            </fieldset>
        </form>
    </div>
</body>
</html>
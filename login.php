<?php
session_start();
if (isset($_SESSION['logado']) &&  $_SESSION['logado'] == 'SIM') :
    header("Location: index.php");
endif;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div id="site">
        <figure>
            <img src="images/logo.png" alt="Logo Markt Club">
        </figure>
        <form action="php/login.php" id="login" method="post">
            <legend>FAÇA SEU LOGIN</legend>
            <p>Digite seu CPF no campo abaixo e clique em logar para fazer seu login.</p>

            <div class="input">
                <input type="text"
			pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Digite um CPF no formato: xxx.xxx.xxx-xx" oninput="addChar(this)"
            maxlength="14" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
            id="input_login" placeholder="CPF" inputmode="numeric" name="login">
                <label for="input_login">CPF</label>
            </div>
            <div class="input">
                <input type="password" id="input_senha" placeholder="Senha" inputmode="numeric" name="senha">
                <label for="input_senha">Senha</label>
            </div>
            <div style="display: flex; width: 100%; justify-content: space-between; align-items: center;">
                <div id="alert"></div>
                <button id="botao" style="margin: 0">LOGAR</button>
            </div>
        </form>
    </div>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/cpf.js"></script>
    <script>
        $(document).ready(function(){
            $("#botao").click(function(e){
                e.preventDefault()
                var data = $("#login").serialize();
                console.log(data);
                $.ajax({
                    type : 'POST',
                    url  : 'php/login.php',
                    data : data,
                    dataType: 'json',
                    beforeSend: function()
                    {	
                        $("#botao").html('Validando...');
                    },
                    success :  function(response) {				
                        if(response.codigo == "1") {	
                            $("#botao").html('Entrar');
                            $("#alert").css('display', 'none');
                            window.location.href = "index.php";
                        } else {			
                            $("#botao").html('Entrar');
                            $("#alert").html("<span id='mensagem'>" + response.mensagem + "</span>")
                            $("#mensagem").css({'color' : '#bf0505', 'font-size' : '15px'})
                        }
                    }
                })
            })

        $("#alert").hover(function(){
            $(".bx-x").click(function(){
                $("#alert").css('display', 'none')
            })
        })
        })
    </script>
</body>

</html>

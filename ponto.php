<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relógio de Ponto</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom right, #0D1B2A, #1B263B);
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 5px;
            object-fit: cover;
            mix-blend-mode: lighten;
        }
        .empresa {
            font-size: 1.2em;
            color: #FFFFFF;
            margin-bottom: 10px;
        }
        h1 {
            font-size: 3em;
            color: #E63946;
            margin-bottom: 20px;
        }
        #clock-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #1B263B;
            padding: 20px 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            margin-bottom: 30px;
        }
        #data {
            font-size: 1em;
            color: #ffffffb3;
            margin-bottom: 5px;
        }
        #clock {
            font-size: 4em;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 1em;
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
            width: 250px;
            text-align: center;
        }
        button {
            background-color: #E63946;
            border: none;
            color: white;
            padding: 15px 30px;
            font-size: 1.2em;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #c62828;
        }
        #status {
            margin-top: 20px;
            font-size: 1.2em;
            color: #A8DADC;
        }
        #mensagem {
            margin-top: 30px;
            font-size: 2em;
            color: #06D6A0;
            opacity: 0;
        }
        @keyframes aparecer {
            0% { transform: scale(0.9); opacity: 0; }
            50% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }
    
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #fff;
            background: #E63946;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        .logout-btn:hover {
            background: #c62828;
        }

</style>
</head>
<body>
<a href="logout.php" class="logout-btn">Sair</a>

    <h1>Relógio de Ponto</h1>
    <img class="avatar" src="https://play-lh.googleusercontent.com/0Llc3tZhC3Kx2BsBs8IBThlF0GcZVF9GC63WxQgR1HsN81X2TeBzLNGtXCvWuFHom-I=w240-h480-rw" alt="Foto do Usuário" />
    <div class="empresa">Zart Supermecados</div>
    <input type="text" id="nome" placeholder="Digite seu número" required>
    <div id="clock-container">
        <div id="data"></div>
        <div id="clock"></div>
 </div>


		<button onclick="baterPonto()">Bater Ponto</button>
		<br>
		<?php
		session_start();
		if (isset($_SESSION['nome']) && $_SESSION['nome'] === 'Administrador') {
		?>

		<a href="admin.php">
			<button type="button">Relatórios</button>
		</a>
		
		<br>
		    
<a href="http://localhost/relogio_ponto/usuarios.php">
    <button type="button">Gerenciar Usuários</button>
</a>
		
		<?php
}
?>

<p id="status"></p>
<div id="mensagem"></div>

    <script>
        function atualizarRelogio() {
            const agora = new Date();
            document.getElementById('clock').innerText = agora.toLocaleTimeString();
            document.getElementById('data').innerText = agora.toLocaleDateString();
        }
        setInterval(atualizarRelogio, 1000);
        atualizarRelogio();

        function baterPonto() {
            const hora = new Date().toLocaleString();
            const nome = document.getElementById('nome').value.trim();

            if (!nome) {
                alert('Por favor, digite seu número.');
                return;
            }

            if (!/^[0-9]+$/.test(nome)) {
                alert('Digite um número válido.');
                return;
            }

            fetch('salvar_ponto.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'hora=' + encodeURIComponent(hora) + '&nome=' + encodeURIComponent(nome)
            })
.then(response => response.text())
.then(data => {
    document.getElementById('status').innerText = data;
    const msg = document.getElementById('mensagem');
    msg.innerText = 'PONTO BATIDO, BOM TRABALHO!';
    msg.style.color = '#FF0000'; // <-- aqui a cor branca é aplicada
    msg.style.animation = 'none';
    msg.offsetHeight;
    msg.style.animation = 'aparecer 1s ease-in-out forwards';
    setTimeout(() => {
        msg.style.opacity = 0;
        msg.innerText = '';
    }, 4000);
})
.catch(error => console.error('Erro:', error));

        }
    </script>
</body>
</html>

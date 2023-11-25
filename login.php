<?php include("header.php"); ?>

<!-- Init of Bootstrap -->

<div class="container">
	
	<div class="col-md-12 col-md-offset-6">
		<h1> Controle Financeiro</h1>

		<!-- Form for Login -->
			<form method="POST" class="log" action="controller/loginController.php">

				<br><br><p>Login</p><br>

				<!-- Agência -->
				<input type="text" name="agencia" class="form-control field" placeholder="Agência" autofocus required><br>

				<!-- Conta -->
				<input type="text" name="conta" class="form-control field" placeholder="Conta" required><br>

				<!-- Senha -->
				<input type="password" name="senha" class="form-control field" placeholder="Senha" required><br>

				<!-- Botão para fazer Login -->
				<button class="btn btn-default" type="submit">
					 <i class="fa fa-lock"></i> Entrar
				</button><br><br>
			</form>

			<p id="credits">&copy; Rogério Furquim - <?php echo date("Y"); ?> - Todos os direitos Reservados</p>
		

	</div>

</div>

</body>
</html>
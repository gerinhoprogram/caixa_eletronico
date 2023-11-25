<!-- PHP - Incluindo Arquivos Necessarios -->
<?php 

session_start();

if(isset($_SESSION['login'])) {

	session_start();
    include_once '../../model/Conexao.class.php';
    include_once '../../model/Conta.class.php';

    $contas = new Contas();

	$id = $_POST['id'];

	include('../../header.php');

?>

<div class="content p-1">
                <div class="list-group-item" style="background-color: #eaeef3">
                    
                        <div class="mr-auto p-2">
                            <h2 class="text-center">Conta</h2><br>
							<a class="badge p-2 badge-primary btn-lg" href="<?php echo $base_url ?>view/contas"><i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i></a>
                        </div>

                        <div class="table-responsive">
							<table class="table table-hover">
								<thead class="thead">
									<tr>
										<th>ID</th>
										<th>TITULAR</th>
										<th>AGÊNCIA</th>
										<th>CONTA</th>
										<th style="text-align: center;">
										    SALDO
										</th>
										<th colspan="2" style="text-align: center;">
										    AÇÕES
										</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($contas->getInfo($id) as $info) : ?>
									<?php 
										$saldo_conta = $info['saldo'];
										$id_conta = $info['id'];
									?>
									<tr class="tr">
										<td><?php echo $info['id'] ?></td>
										<td><?php echo $info['titular'] ?></td>
										<td><?php echo $info['agencia'] ?></td>
										<td><?php echo $info['conta'] ?></td>
										<td style="text-align: center;">
											<span class="badge badge-pill p-2 badge-primary">R$ <?php echo $info['saldo'] ?></span>
										</td>

										<td style="text-align: center;">
											<button class="btn btn-primary btn-lg" onclick="window.print()">
												<i class="fa fa-print"></i>
											</button>
								
											<button class="btn btn-warning btn-lg form_jquery">
												<i class="fa fa-dollar-sign"></i>
											</button>
										</td>

									</tr>
								<?php endforeach ?>
								</tbody>
							</table>
							
							<hr><br><br>

							<form method="POST" action="<?php echo $base_url ?>controller/contas/contas.php" style="font-weight: bold; font-style: italic;" class="formulario">
								
								<h4 class="text-center">
									<strong>
										Efetue a Transação <i class="fa fa-handshake"></i>
									</strong>
								</h4><br>

								<div class="container">
									<div class="form-row">
										
										<div class="col-md-4" style="clear: both;"></div>
										<div class="col-md-4">
											<label for="tipo">Tipo</label><br>
											<select name="tipo" class="form-control"required>
												<option value="1">Entrada</option>
												<option value="0">Saída</option>
											</select>
										</div>
										<div class="col-md-4" style="clear: both;"></div>

										<div class="col-md-4" style="clear: both;"></div>
										<div class="col-md-4">
											<br><label for="tipo">Data</label><br>
											<input type="date"class="form-control" name="data">
										</div>
										<div class="col-md-4" style="clear: both;"></div>

										<div class="col-md-4" style="clear: both;"></div>

										<div class="col-md-4">
											<br><label for="valor">Valor</label>
											<input type="text" name="valor" class="form-control" pattern="[0-9.,]{1,}" required>
											<input type="hidden" name="id_conta" value="<?php echo $id_conta ?>" required><br>
											<input type="hidden" name="acao" value="transacao" required><br>

											<label for="motivo">Motivo</label>
											<textarea name="motivo" class="form-control" rows="3"></textarea><br>

											<select class="form-control" name="despeza" id="">
												<option value="0">Outros</option>
												<?php foreach($contas->listDespezas() as $despeza) : ?>
													<option value="<?php echo $despeza['id']?>"><?php echo $despeza['nome']?></option>
												<?php endforeach ?>
											</select>

										</div>
										<div class="col-md-4" style="clear: both;"></div>
										<div class="col-md-4" style="clear: both;"></div>

										<div class="col-md-4">
											<br><button class="btn btn-primary btn-block">
												Efetuar Transação <i class="fa fa-handshake"></i>
											</button>
										</div>

										<div class="col-md-4" style="clear: both;"></div>

									</div>
								</div>

							</form>
							
							<br><hr>

							<?php if($saldo_conta > 0) : ?>
							
							<h3 class="text-center">
								Movimentação/Extrato <i class="fa fa-folder-open"></i>
							</h3><br>

							<div class="table-responsive">

								<table class="table table-hover">
									<thead class="thead text-center">
										<tr>
											<th>Data</th>
											<th>Valor da movimentação</th>
											<th>Movimentação</th>
											<th>Motivo</th>
										</tr>
									</thead>
									<tbody class="text-center">
										<?php foreach($contas->listHistoric($id) as $historic) : ?>
										<tr>
											<td><?php echo date("d/m/Y", strtotime($historic['data_operacao'])) ?></td>
											
											<?php if($historic['tipo']) : ?>
												<td style="color: green;">+
											<?php else : ?>
												<td style="color: red;">-
											<?php endif ?>
												 R$ <?php echo $historic['valor'] ?>
											</td>
											
											<td><?php echo ($historic['tipo'] ? '<span class="badge badge-pill p-2 badge-success">Entrada +</span>' : '<span class="badge badge-pill p-2 badge-danger">Saída - </span>')  ?></td>

											<td><?php echo $historic['motivo']  ?></td>
										</tr>
										<?php endforeach ?>
									</tbody>
								</table>


							</div>

							<?php endif ?>

						</div>

               
                </div>
            </div>

            <script type="text/javascript" src="<?php echo $base_url ?>assets/js/jquery-3.3.1.min.js"></script>
			<script type="text/javascript" src="<?php echo $base_url ?>assets/js/script.js"></script>

	<?php 
		}
	?>
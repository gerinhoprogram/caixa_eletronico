<?php 

	session_start();

	if(isset($_SESSION['login'])){

	include_once '../../model/Conexao.class.php';
	include_once '../../model/Conta.class.php';

	$contas = new Contas();

	include("../../header.php");

?>

        <div class="d-flex">

			<?php include('../../menu.php') ?>

            <div class="content p-1">

                <div class="p-2" style="background-color: #eaeef3">
                    
                        <div class="mr-auto p-2">
                            <h2 class="text-center"><i class="fas fa-chart-bar"></i>&nbsp;&nbsp;&nbsp;contas</h2><br><br>
                        </div>

                        <div class="table-responsive">
							<table>
								<tr>
									<td>
										<a class="badge p-2 badge-success btn-lg" href="<?php echo $base_url ?>view/contas/add_conta.php">Adicionar conta</a>
									</td>
								</tr>
							</table>
							<table class="table table-hover">
								<thead class="thead">
									<tr>
										<th>ID</th>
										<th>TITULAR</th>
										<th>SALDO</th>
										<th class="text-center">AÇÕES</th>
									</tr>
								</thead>
								<tbody>
									<?php $total = 0; ?>
									<?php foreach($contas->listAccounts() as $account) : ?>
									<tr class="tr">
										<td><?php echo $account['id'] ?></td>
										<td><?php echo $account['titular'] ?></td>
										<td>R$ <?php echo $account['saldo'] ?></td>

										<td class="text-center">
											<form method="POST" action="<?php echo $base_url ?>view/contas/add_transacao.php">
												<input type="hidden" name="id" value="<?=$account['id'] ?>">
												<button class="btn btn-warning btn-xs float-left">
													<i class="fa fa-dollar-sign"></i>
												</button>
											</form>
										
											<button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#exampleModal-<?php echo $account['id'] ?>">
											<i class="fa fa-trash" aria-hidden="true"></i>
											</button>
										</td>
									</tr>

									<!-- Modal -->
									<div class="modal fade" id="exampleModal-<?php echo $account['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Excluir conta</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												Deseja excluir a conta <?php echo $account['titular'] ?>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
												<form method="POST" action="<?php echo $base_url ?>controller/contas/contas.php">
													<input type="hidden" name="id" value="<?=$account['id'] ?>">
													<input type="hidden" name="acao" value="deletar">
													<button class="btn btn-danger btn-xs">
														Excluir
													</button>
												</form>
											</div>
											</div>
										</div>
									</div>
									<?php $total = $total + $account['saldo']; ?>
									<?php endforeach ?>
								</tbody>
								<tfooter>
									<tr>
										<td colspan="4">Total: R$ <?php echo $total ?></td>
									</tr>
								</tfooter>
							</table>
						</div>
               
                </div>
            </div>

        </div>

<?php 

	include('../../footer.php');

	}else{
		header("Location: ../../login.php?access_denied");
	}

?>
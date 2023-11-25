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
                            <h2 class="text-center"><i class="fas fa-chart-bar"></i>&nbsp;&nbsp;&nbsp;Despezas</h2><br><br>
                        </div>

                        <div class="table-responsive">
							<table>
								<tr>
									<td>
										<a class="badge p-2 badge-success btn-lg" href="<?php echo $base_url ?>view/despezas/adicionar.php">Adicionar despeza</a>
									</td>
								</tr>
							</table>
							<table class="table table-hover">
								<thead class="thead">
									<tr>
										<th>ID</th>
										<th>NOME</th>
										<th>VALOR</th>
										<th class="text-center">AÇÕES</th>
									</tr>
								</thead>
								<tbody>
									<?php $total = 0; ?>
									<?php foreach($contas->listDespezas() as $despezas) : ?>
									<tr class="tr">
										<td><?php echo $despezas['id'] ?></td>
										<td><?php echo $despezas['nome'] ?></td>
										<td>R$ <?php echo $despezas['valor'] ?></td>

										<td class="text-center">
											<form method="POST" action="<?php echo $base_url ?>view/despezas/editar.php">
												<input type="hidden" name="id" value="<?=$despezas['id'] ?>">
												<button class="btn btn-warning btn-xs float-left">
													<i class="fa fa-dollar-sign"></i>
												</button>
											</form>
										
											<button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#exampleModal-<?php echo $despezas['id'] ?>">
											<i class="fa fa-trash" aria-hidden="true"></i>
											</button>
										</td>
									</tr>

									<!-- Modal -->
									<div class="modal fade" id="exampleModal-<?php echo $despezas['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Excluir despeza</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												Deseja excluir a despeza <?php echo $despezas['nome'] ?>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
												<form method="POST" action="<?php echo $base_url ?>controller/despezas/despezas.php">
													<input type="hidden" name="id" value="<?=$despezas['id'] ?>">
													<input type="hidden" name="acao" value="deletar">
													<button class="btn btn-danger btn-xs">
														Excluir
													</button>
												</form>
											</div>
											</div>
										</div>
									</div>
									<?php $total = $total + $despezas['valor']; ?>
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
		header("Location: login.php?access_denied");
	}

?>
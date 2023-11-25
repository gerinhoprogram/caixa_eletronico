
<?php 

session_start();

if(isset($_SESSION['login'])) {

	session_start();
    include_once '../../model/Conexao.class.php';
    include_once '../../model/Conta.class.php';

    $contas = new Contas();

    $id = $_POST['id'];

    include("../../header.php");

?>

    <div class="content p-1">
                <div class="list-group-item" style="background-color: #eaeef3">
                    
                        <div class="mr-auto p-2">
                            <h2 class="text-center">Adicionar nova conta</h2><br>
                        </div>

                        <form action="<?php echo $base_url ?>controller/despezas/despezas.php" method="POST">
                            
                            <div class="form-row">
                                <?php foreach($contas->getDespeza($id) as $info) : ?>		
                                <input type="hidden" name="acao" value="editar">
                                <input type="hidden" name="id" value="<?php echo $info['id'] ?>">
                                <div class="col-md-4" style="clear: both;"></div>
                                <div class="col-md-4">
                                    <input class="form-control mb-3" type="text" name="nome" require placeholder="Nome da despeza" value="<?php echo $info['nome'] ?>">
                                </div>
                                <div class="col-md-4" style="clear: both;"></div>
                
                                <div class="col-md-4" style="clear: both;"></div>
                                <div class="col-md-4">
                                    <input class="form-control mb-3" type="text" name="valor" pattern="[0-9.,]{1,}" require placeholder="Valor" value="<?php echo $info['valor'] ?>">
                                </div>
                                <div class="col-md-4" style="clear: both;"></div>

                                <div class="col-md-4" style="clear: both;"></div>
                                <div class="col-md-4">
                                    <a class="badge p-2 badge-primary btn-lg" href="<?php echo $base_url ?>view/despezas"><i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i></a>

                                    <button class="btn btn-success btn-lg" type="submit">
                                    <i class="far fa-save"></i> Salvar
                                    </button>
                                </div>
                                <div class="col-md-4" style="clear: both;"></div>
                            </div>

                            <?php endforeach ?>
                        </form>
               
                </div>
            </div>


	<?php 
        include("../../footer.php");
		}
	?>
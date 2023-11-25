<?php 

	session_start();

	if(isset($_SESSION['login'])){

	include_once 'model/Conexao.class.php';
	include_once 'model/Conta.class.php';

	$contas = new Contas();

	include('header.php');

?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <div class="d-flex">

			<?php include('menu.php') ?>

            <div class="content p-1">

                <div class="p-2" style="background-color: #eaeef3">
                    
                        <div class="mr-auto p-2">
                            <h2 class="text-center"><i class="fas fa-chart-bar"></i>&nbsp;&nbsp;&nbsp;Dashboard</h2><br><br>
                        </div>

						<div class="form-row">
										
							<div class="col-md-12">
								<div id="columnchart_values"></div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12">
								<div id="columnchart_values_2"></div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12">
								<div id="total"></div>
							</div>
						</div>

               
                </div>
            </div>

        </div>

<?php 

	echo"<script type='text/javascript'>
    
				google.charts.load('current', {packages:['corechart']});
				google.charts.setOnLoadCallback(drawChart);
				function drawChart() {
				var data = google.visualization.arrayToDataTable([";
					echo"['Element', 'Total R$', { role: 'style' } ],";

					foreach ($contas->listHistoricRel(11, 0, false) as $account) {
						echo"['".date("d/m", strtotime($account['data_operacao']))."', ".$account['total'].", 'red'],";
				}

				echo"]);

				var view = new google.visualization.DataView(data);
				view.setColumns([0, 1,
								{ calc: 'stringify',
									sourceColumn: 1,
									type: 'string',
									role: 'annotation' },
								2]);

				var options = {
					title: 'Total de despezas por dia (Conta casa)',
					width: '100%',
					height: 400,
					bar: {groupWidth: '95%'},
					legend: { position: 'none' },
				};
				var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_values'));
				chart.draw(view, options);
			}

    </script>";

	echo"<script type='text/javascript'>
    
				google.charts.load('current', {packages:['corechart']});
				google.charts.setOnLoadCallback(drawChart);
				function drawChart() {
				var data = google.visualization.arrayToDataTable([";
					echo"['Element', 'Total R$', { role: 'style' } ],";

					foreach ($contas->listHistoricRel(10, 1, true) as $account) {
						echo"['".date("d/m", strtotime($account['data_operacao']))."', ".$account['total'].", 'green'],";
				}

				echo"]);

				var view = new google.visualization.DataView(data);
				view.setColumns([0, 1,
								{ calc: 'stringify',
									sourceColumn: 1,
									type: 'string',
									role: 'annotation' },
								2]);

				var options = {
					title: 'Total de entradas por dia (Conta banco)',
					width: '100%',
					height: 400,
					bar: {groupWidth: '95%'},
					legend: { position: 'none' },
				};
				var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_values_2'));
				chart.draw(view, options);
			}

    </script>";

	echo"<script type='text/javascript'>
    
				google.charts.load('current', {packages:['corechart']});
				google.charts.setOnLoadCallback(drawChart);
				function drawChart() {
				var data = google.visualization.arrayToDataTable([";
					echo"['Element', 'Total R$', { role: 'style' } ],";

					foreach ($contas->listTotal() as $total) {
						echo"['".date("d/m", strtotime($total['data_operacao']))."', ".$total['valor'].", '#ccc'],";
				}

				echo"]);

				var view = new google.visualization.DataView(data);
				view.setColumns([0, 1,
								{ calc: 'stringify',
									sourceColumn: 1,
									type: 'string',
									role: 'annotation' },
								2]);

				var options = {
					title: 'Total das contas por dia',
					width: '100%',
					height: 400,
					bar: {groupWidth: '95%'},
					legend: { position: 'none' },
				};
				var chart = new google.visualization.ColumnChart(document.getElementById('total'));
				chart.draw(view, options);
			}

    </script>";

	include('footer.php');

	}else{
		header("Location: login.php?access_denied");
	}

?>
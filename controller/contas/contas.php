<?php

    session_start();
    include_once '../../model/Conexao.class.php';
    include_once '../../model/Conta.class.php';

    $contas = new Contas();
    $acao = addslashes($_POST['acao']);

    if(!$acao){
        header('Location: ../../view/contas');
    }

    if($acao == 'transacao'){
    
        if(isset($_POST['valor']) && isset($_POST['id_conta'])){

            $valor = str_replace(",", ".", $_POST['valor']);
            $valor = floatval($valor);

            $dados = [
                'tipo' => addslashes($_POST['tipo']),
                'motivo' => addslashes($_POST['motivo']),
                'data' => $_POST['data'],
                'id_conta' => addslashes($_POST['id_conta']),
                'valor' => $valor,
                'despeza' => $_POST['despeza'],
            ];

        //     echo"<pre>";
        //   print_r($dados);
        //   exit();

            
            $contas->setTransaction($dados);
            header("Location: ../../view/contas?transacao_realizada");
          
        }else{
            header("Location: ../../view/contas?erro");
        }
    
    }

    if($acao == 'adicionar'){

        if(isset($_POST['conta'])){

            $nome = addslashes($_POST['nome']);
            $agencia = addslashes($_POST['agencia']);
            $conta = addslashes($_POST['conta']);
            $senha = md5($_POST['senha']);

            $contas->addConta($nome, $agencia, $conta, $senha);
            header('Location: ../../view/contas?conta_criada');

        }else{
            header('Location: ../../view/contas?erro');
        }
    }

    if($acao == 'deletar'){

        if(isset($_POST['id'])){

            $id = $_POST['id'];
            
            if($contas->deleteConta($id)){
                header('Location: ../../view/contas?resgistro_deletado_sucesso');
            }else{
                header("Location: ../../view/contas?erro");
            }
            
        }else{
            header("Location: ../../view/contas?erro");
        }

    }


    

    


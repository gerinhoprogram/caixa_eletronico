<?php

    session_start();
    include_once '../../model/Conexao.class.php';
    include_once '../../model/Conta.class.php';

    $contas = new Contas();
    $acao = addslashes($_POST['acao']);

    if($acao == 'editar'){
    
        if(isset($_POST['id'])){

            $id = addslashes($_POST['id']);
            $nome = addslashes($_POST['nome']);
            $valor = str_replace(",", ".", $_POST['valor']);
            $valor = floatval($valor);
    
            if($contas->editarDespeza($id, $valor, $nome)){

                header('Location: ../../view/despezas?alterado_sucesso');

            }else{

                header('Location: ../../view/despezas?erro');

            }
    
        }else{
    
            header('Location: ../../view/despezas?erro');
    
        }
    }

    if($acao == 'adicionar'){
    
        if(isset($_POST['nome']) && isset($_POST['valor'])){

            $nome = addslashes($_POST['nome']);
            $valor = str_replace(",", ".", $_POST['valor']);
            $valor = floatval($valor);
    
            $contas->addDespeza($nome, $valor);
            header('Location: ../../view/despezas?despeza_criada');
    
        }else{
    
            header('Location: ../../view/despezas?erro');
    
        }
    }

    if($acao == 'deletar'){

        if(isset($_POST['id'])){

            $id = $_POST['id'];
            
            if($contas->deleteDespeza($id)){
                header('Location: ../../view/despezas?resgistro_deletado_sucesso');
            }else{
                header("Location: ../../view/despezas?erro");
            }
            
        }else{
            header("Location: ../../view/despezas?erro");
        }
    }


    

    


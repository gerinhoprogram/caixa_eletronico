<?php

    //heranca Contas herda os metodos de conexao
    class Contas extends Conexao{

        /*METODOS PARA CONTA*/

        //METODO PARA LISTAR CONTAS
        public function listAccounts(){

            $pdo = parent::get_instance();
            $sql = "select * from contas order by id asc";
            $sql = $pdo->prepare($sql);
            $sql->execute();

            if($sql->rowCount() > 0){
                return $sql->fetchAll();
            }

        }

        //metodo para efetuar transação
        public function setTransaction($dados){

            date_default_timezone_set('America/Sao_Paulo');

            if($dados['data']){
                $date = $dados['data'];
            } else{
                $date = date('Y-m-d');
            }

            $pdo = parent::get_instance();
            $sql = "insert into historico
                    (id_conta, tipo, valor, data_operacao, motivo, despeza)
                    values (:id_conta, :tipo, :valor, :data_operacao, :motivo, :despeza)";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":id_conta", $dados['id_conta']);
            $sql->bindValue(":tipo", $dados['tipo']);
            $sql->bindValue(":valor", $dados['valor']);
            $sql->bindValue(":data_operacao", $date);
            $sql->bindParam(":motivo", $dados['motivo']);
            $sql->bindValue(":despeza", $dados['despeza']);
            $sql->execute();

            if($dados['tipo']){

                //deposito
                $sql = "update contas set saldo = saldo + :valor where id = :id";
                $sql = $pdo->prepare($sql);
                $sql->bindValue(":valor", $dados['valor']);
                $sql->bindValue(":id", $dados['id_conta']);
                $sql->execute();

                $sql="select sum(saldo) as saldo_total from contas where id = 10 or id = 11";
                $sql = $pdo->prepare($sql);
                $sql->execute();
                $total = $sql->fetch();

            }else{

                //retirada
                $sql = "update contas set saldo = saldo - :valor where id = :id";
                $sql = $pdo->prepare($sql);
                $sql->bindValue(":valor", $dados['valor']);
                $sql->bindValue(":id", $dados['id_conta']);
                $sql->execute();

                $sql="select sum(saldo) as saldo_total from contas where id = 10 or id = 11";
                $sql = $pdo->prepare($sql);
                $sql->execute();
                $total = $sql->fetch();
            }

            $pdo = parent::get_instance();
            $sql="select data_operacao from valor_total where data_operacao = :data_operacao";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":data_operacao", $date);
            $sql->execute();

            if($sql->rowCount() > 0){
                $sql = "update valor_total set valor = :valor where data_operacao = :data_operacao";
                $sql = $pdo->prepare($sql);
                $sql->bindValue(":data_operacao", $date);
                $sql->bindValue(":valor", $total['saldo_total']);
                $sql->execute();
            }else{
                $sql = "insert into valor_total
                (data_operacao, valor)
                values (:data_operacao, :valor)";
                $sql = $pdo->prepare($sql);
                $sql->bindValue(":data_operacao", $date);
                $sql->bindValue(":valor", $total['saldo_total']);
                $sql->execute();
            }


        }

        //metodo para adicionar conta
        public function addConta($nome, $conta, $agencia, $senha){
            $pdo = parent::get_instance();
            $sql = "insert into contas
                    (titular, agencia, conta, senha, saldo)
                    values (:titular, :agencia, :conta, :senha, :saldo)";
            $sql = $pdo->prepare($sql);
            $sql->bindParam(":titular", $nome);
            $sql->bindValue(":agencia", $agencia);
            $sql->bindValue(":conta", $conta);
            $sql->bindParam(":senha", $senha);
            $sql->bindValue(":saldo", 0);
            $sql->execute();
        }

        

        //METODO PARA DELETAR CONTA
        public function deleteConta($id){
            $pdo = parent::get_instance();
            $sql = "delete from contas 
                    where id = :id";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount() > 0){
                return true;
            }else{
                return false;
            }

        }

        // metodo para pegar informações de cada conta
        public function getInfo($id){
            $pdo = parent::get_instance();
            $sql="select * from contas where id = :id";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount() > 0){
                return $sql->fetchAll();
            }
    
        }

        /*METODOS PARA HISTORICO*/

        //metodo para listar historico
        public function listHistoric($id){
            $pdo = parent::get_instance();
            $sql = "select * from historico where id_conta = :id_conta order by id desc";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":id_conta", $id);
            $sql->execute();
            
            if($sql->rowCount() > 0){
                return $sql->fetchAll();
            }
        }

        //metodo para listar historico
        public function listTotal(){
            $pdo = parent::get_instance();

            $sql = "select * from valor_total";
            $sql = $pdo->prepare($sql);
            $sql->execute();

            $linhas = $sql->rowCount();
            $minimo = $linhas - 12;
            
            if($sql->rowCount() > 0){

                $pdo = parent::get_instance();
                $sql = "select * from valor_total limit $minimo, $linhas";
                $sql = $pdo->prepare($sql);
                $sql->execute();
                
                if($sql->rowCount() > 0){
                    return $sql->fetchAll();
                }
            }

            
        }

        /*METODOS PARA DESPEZAS*/

        //metodo para listar despezas
        public function listDespezas(){
            $pdo = parent::get_instance();
            $sql = "select * from despezas";
            $sql = $pdo->prepare($sql);
            $sql->execute();
            
            if($sql->rowCount() > 0){
                return $sql->fetchAll();
            }
        }

        //metodo para editar despezas
        public function editarDespeza($id, $valor, $nome){
            $pdo = parent::get_instance();
            $sql = "update despezas set nome = :nome, valor = :valor where id = :id";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->bindValue(":valor", $valor);
            $sql->bindParam(":nome", $nome);
            $sql->execute();
            
            if($sql->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        //metodo para adicionar despezas
        public function addDespeza($nome, $valor){
            $pdo = parent::get_instance();
            $sql = "insert into despezas
                    (nome, valor)
                    values (:nome, :valor)";
            $sql = $pdo->prepare($sql);
            $sql->bindParam(":nome", $nome);
            $sql->bindValue(":valor", $valor);
            $sql->execute();
        }

         // metodo para pegar informações de cada conta
        public function getDespeza($id){
            $pdo = parent::get_instance();
            $sql="select * from despezas where id = :id";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount() > 0){
                return $sql->fetchAll();
            }
    
        }

         //METODO PARA DELETAR DESPEZA
         public function deleteDespeza($id){
            $pdo = parent::get_instance();
            $sql = "delete from despezas 
                    where id = :id";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount() > 0){

                return true;
                
            }else{
               
                return false;
            }

        }

        /**
         * METODOS PARA RELATORIOS
         */

        public function listHistoricRel($id, $tipo, $boll){
            
            $pdo = parent::get_instance();

            if($boll){
                $sql="select *, sum(valor) as total from historico
                where id_conta = :id_conta and tipo = :tipo
                group by data_operacao";
            }else{
                
                $pdo = parent::get_instance();
                $sql = "select * from historico";
                $sql = $pdo->prepare($sql);
                $sql->execute();

                $linhas = $sql->rowCount();
                $minimo = $linhas - 12;

                $pdo = parent::get_instance();
                $sql="select *, sum(valor) as total from historico
                where id_conta = :id_conta and tipo = :tipo
                group by data_operacao
                limit 10, $linhas";
            }

            
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":id_conta", $id);
            $sql->bindValue(":tipo", $tipo);
            $sql->execute();

            if($sql->rowCount() > 0){
                return $sql->fetchAll();
            }
    
        }

        /*METODOS PARA LOGIN*/

        //METODO PARA LOGIN
        public function setLogged($agencia, $conta, $senha){
            $pdo = parent::get_instance();
            $sql = "select * from contas 
                    where agencia = :agencia and 
                    conta = :conta and 
                    senha = :senha";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":agencia", $agencia);
            $sql->bindValue(":conta", $conta);
            $sql->bindValue(":senha", $senha);
            $sql->execute();

            if($sql->rowCount() > 0){
                $sql = $sql->fetch();

                $_SESSION['login'] = $sql['id'];

                header('Location: ../index.php?login_success');
                exit;
            }else{
                header('Location: ../login.php?not_login');
            }

        }

        //metodo para fazer logout
        public function logout(){
            unset($_SESSION['login']);
        }

    }
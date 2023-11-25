<?php

session_start();
include_once '../model/Conexao.class.php';
include_once '../model/Conta.class.php';

$contas = new Contas();
$contas->logout();

header('Location: ../login.php?session_ending_success');

<?php

    class Conexao {

        public static $instance;

        public static function get_instance(){

            if(!isset(self::$instance)){
                self::$instance = new PDO("mysql:host=rogerioweb.com;dbname=u281483592_caixa;", "u281483592_caixa", "@Caixa_Eletronico2022",
                 array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

                 self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }

            return self::$instance;

        }

    }
?>
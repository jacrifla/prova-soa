<?php

define('SGBD'       , 'mysql'       );
define('HOST'       , 'localhost'   );
define('DBNAME'     , 'soa'       );
define('CHARSET'    , 'utf8'        );
define('USER'       , 'root'        );
define('PASSWORD'   , ''            );
define('SERVER'     , 'windows'     );
define('PORTA_DB'   , 3306          );

class ConnectionDB{

    private static $pdo;

    private function __construct(){// privar o construtor não permite que essa classe seja instanciada

    }

    private static function existsExtension(){
        $extension = 'pdo_mysql';
        // switch(SGBD):
        //     case 'mysql':
        //         $extension = 'pdo_mysql';
        //         break;
        // endswitch;
        if(empty($extension) || !extension_loaded($extension)){
            echo "Extensão PDO ' {$extension}' não está habilitada";
        }
    }

    public static function getInstance(){
        self::existsExtension();
        //self é tipo um this para métodos estáticos
        if(!isset(self::$pdo)){
            try{
                switch(SGBD):
                    case 'mysql':
                        $options = array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
                        self::$pdo = new \PDO("mysql:host=" . HOST . "; dbname=" . DBNAME . ";", USER, PASSWORD, $options);
                        break;
                endswitch;

                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);//habilita a exibição de mensagens de erro
            }catch (\PDOException $e){
                throw new \PDOException($e->getMessage());
            }catch (\Exception $e){
                throw new \Exception($e->getMessage());
            }
        }

        return self::$pdo;
    }


}

//testar a conexao
// $ConnectionDB = ConnectionDB::getInstance();

// var_dump($ConnectionDB);

// require '../model/VendaModel.php';

// var_dump(VendaModel::show());
// var_dump(VendaModel::find(3));

// $produto = [
//     'descricao'=> 'Produto 2',
//     'valor'=> 5
// ];
// $retorno = VendaModel::insert($produto);

// if ($retorno){
//     echo 'gravado com sucesso';
// }else{
//     echo 'programador burro do carai';
// }

// $produto = [
//     'descricao'=> 'Produto 2, novo',
//     'codigo'=> 2,
//     'valor'=>55
// ];
// $retorno = VendaModel::update($produto);

// if ($retorno){
//     echo 'atualizado com sucesso';
// }else{
//     echo 'programador burro do carai';
// }

// var_dump(VendaModel::delete(2));


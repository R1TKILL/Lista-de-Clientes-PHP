<?php 

//imports:

/*Ná página de formulário, por algum motivo só atualiza se mudar pra esse segundo import,
causando, erro nas outras páginas por não encontrar mais a interface.*/
require('src/php/interface/ConnectInterface.php');
//require('../interface/ConnectInterface.php');
use Controler\ConnectInterface as CI;

/**
 * Class: Classe de conexão e iteração com o DATABASE.
 * @author: R1TKILL - <antoniojunio402@gmail.com>;
 */
class ConnectDB implements CI{

    //Attributes:

    /**
     * Instância: recebe o tipo de dialeto sql;
     * @access: private;
     * @type: string;
     */
    private string $dialectSQL;

    /**
     * Instância: recebe o endereço da conexão;
     * @access: private;
     * @type: string;
     */
    private string $host;

    /**
     * Instância: recebe a porta ao da conexão;
     * @access: private;
     * @type: string;
     */
    private string $port;

    /**
     * Instância: recebe o nome do database;
     * @access: private;
     * @type: string;
     */
    private string $database;

    /**
     * Instância: monta a string com endereço de conexão SQL para o endpoint;
     * @access: private;
     * @type: string;
     */
    private string $address;

    /**
     * Instância: recebe o usuário do database;
     * @access: private;
     * @type: string;
     */
    private string $user;

    /**
     * Instância: recebe a senha do database;
     * @access: private;
     * @type: string;
     */
    private string $pass;

    /**
     * Instância: endpoint de conexão e execução dos métodos sql;
     * @access: private;
     * @type: PDO;
     */
    private readonly PDO $conn;

    //Construct:

    /**
     * Constructor: Tem a função de inicializar os valores necessários para tudo funcionar;
     * @author: R1TKILL - <antoniojunio402@gmail.com>; 
     */
    public function __construct(){
        $this -> dialectSQL = getenv('DialectSQL');
        $this -> host = getenv('HOST');
        $this -> port = getenv('PORT');
        $this -> database = getenv('DATABASE');
        $this -> address = ($this -> dialectSQL.':host='.$this -> host.';port='.$this -> port.';dbname='.$this -> database);
        $this -> user = getenv('DB_USER');
        $this -> pass = getenv('PASSWORD');
        $this -> connectDrive();
    }

    //Methods:

    /**
     * Conexão: Realiza a conexão com a base de dados.
     * @author: R1TKILL - <antoniojunio402@gmail.com>;
     * @access: public;
     * @version: 1.0;
     * @return: PDO;
     */
    public function connectDrive(): PDO{
        if(empty($this -> conn)){
            try {
                $this -> conn = new \PDO($this -> address, $this -> user, $this -> pass);
                return $this -> conn;
            } catch (\PDOException $ex) {
                die("Erro ao tentar conectar no Database = <strong>{$ex->getMessage()}</strong>");
            }
        }
    }

    /**
     * Registro: Registra novos dados na Base de Dados.
     * @author: R1TKILL - <antoniojunio402@gmail.com>;
     * @access: public;
     * @param: ...$fields[string $name, string $email, string $age, string $work];
     * @version: 1.0;
     * @return: void;
     */
    public function insertDates(...$fields): void{
        try {
            if(filter_var($fields[1], FILTER_VALIDATE_EMAIL)){
                $query = "INSERT INTO \"Clients\"(name, email, age, work) VALUES ('$fields[0]','$fields[1]','$fields[2]','$fields[3]')";
                $this -> conn -> query($query);
            }else{
                echo "<h3>O formato de email esta incorreto!</h3>";
            }
        } catch (\PDOException $ex) {
            die("Erro ao tentar inserir no Database = <strong>{$ex->getMessage()}</strong>");
        }
    }

    /**
     * Leitura: Retorna todos os registros existem na Base de Dados.
     * @author: R1TKILL - <antoniojunio402@gmail.com>;
     * @access: public;
     * @version: 1.0;
     * @return: array;
     */
    public function readAllDates(): array{
        try {
            $query = 'SELECT * FROM "Clients"';
            $sqlDates = $this -> conn -> query($query);
            $resultSql = $sqlDates -> fetchAll();

            if(empty($resultSql)){
                echo "<h3>Não há dados cadastrados no banco de dados!</h3>";
            }else{
                return $resultSql;
            }
        } catch (\PDOException $ex) {
            die("Erro ao tentar listar dados do Database = <strong>{$ex->getMessage()}</strong>");
        }
    }

    /**
     * Leitura individual: Válida se o id passado existe e retorna o registro da Base de Dados.
     * @author: R1TKILL - <antoniojunio402@gmail.com>;
     * @access: public;
     * @param: int $id;
     * @version: 1.0;
     * @return: string;
     */
    public function readFilterDate(int $id): array{
        try {
            $query = "SELECT * FROM \"Clients\" WHERE id = $id";
            $sqlDate = $this -> conn -> query($query);
            $resultSql = $sqlDate -> fetchAll();

            if(empty($resultSql)){
                //<h3>Dados inexistente no banco!</h3>";
            }else{
                return $resultSql;
            }
        } catch (\PDOException $ex) {
            die("Erro ao tentar buscar o dado do Database = <strong>{$ex->getMessage()}</strong>");
        }
    }

    /**
     * Modificação: Válida se o id passado existe e atualiza as informações do registro na Base de Dados.
     * @author: R1TKILL - <antoniojunio402@gmail.com>;
     * @access: public;
     * @param: ...$fields[int $id, string $name, string $email, string $age, string $work];
     * @version: 1.0;
     * @return: void;
     */
    public function updateFilterDate(...$fields): void{
        try {
            $query = "UPDATE \"Clients\" SET name='$fields[1]', email='$fields[2]', age='$fields[3]', work='$fields[4]' WHERE id = $fields[0]";
            $this -> conn -> query($query);
        } catch (\PDOException $ex) {
            die("Erro ao tentar modificar o dado do Database = <strong>{$ex->getMessage()}</strong>");
        }
    }

    /**
     * Remoção: Válida se o id passado existe e remove o registro da Base de Dados.
     * @author: R1TKILL - <antoniojunio402@gmail.com>;
     * @access: public;
     * @param: int $id;
     * @version: 1.0;
     * @return: void;
     */
    public function deleteFilterDate(int $id): void{
        try {
            $query = "DELETE FROM \"Clients\" WHERE id = $id";
            $this -> conn -> query($query);
        } catch (\PDOException $ex) {
            die("Erro ao tentar deletar o dado do Database = <strong>{$ex->getMessage()}</strong>");
        }
    }
}

?>
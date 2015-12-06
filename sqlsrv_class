<?php

/**
 * Class connection
 * @author Antonio Santos
 * @version 0.1
 */
class connection{

    private $_query;
    private $conn;
    private $host = SERVER/INSTANCE;  //Alterar para dados do servidor SQL
    private $user = USER;             //Alterar para dados do servidor SQL
    private $password = PASSWORD;     //Alterar para dados do servidor SQL
    private $db = DATABASE;           //Alterar para dados do servidor SQL

    /**
     * Criar conexão com servidor SQL
     *
     * @return void
     */
    public function __construct(){
        $info = array(
            'UID' => $this->user,
            'PWD' => $this->password,
            'Database' => $this->db,
            'CharacterSet' => 'UTF-8'
        );

        $this->conn = sqlsrv_connect($this->host, $info);

        if( $this->conn === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }

    /**
     * Enviar query para servidor SQL
     *
     * @param string $query sql query
     *
     * @return void
     */
    public function query($query){

        $query = filter_var($query, FILTER_SANITIZE_STRING);

        $this->_query = sqlsrv_query($this->conn, $query);
        if (!$this->_query) {
            die(print_r(sqlsrv_errors(), true));
        }

    }

    /**
     * Enviar query para metodo query e devolve resultados como objecto
     *
     * @param string $query sql query
     *
     * @return object
     */
    public function results_object($query)
    {
        $this->query($query);
        $results = array();
        while ($res = sqlsrv_fetch_object($this->_query)) {
            $results[] = $res;
        }
        return $results;
    }

    /**
     * Enviar query para metodo query e devolve resultados como array
     *
     * @param string $query sql query
     *
     * @return array
     */
    public function results_array($query)
    {
        $this->query($query);
        $results = array();
        while ($res = sqlsrv_fetch_array($this->_query, SQLSRV_FETCH_ASSOC)) {
            $results[] = $res;
        }
        return $results;
    }

    /**
     * Preparar query SELECT simples e enviar para metodo results_object.
     * Apenas com possibilidade de AND nas condições.
     * Sem ORDER definido.
     *
     * @param string    $table      tabela selecionada
     * @param array     $fields     campos da tabela a apresentar
     * @param array     $conditions condições WHERE
     *
     * @return object
     */
    public function select($table, array $fields, array $conditions){

        $fields_string = implode (", ", $fields );

        $query = 'SELECT '.$fields_string.' FROM '.$table.' WHERE ';

        foreach( $conditions as $key=>$value ){
            $query .= ' '.$key.'='.$value.' AND';
        }
        $query = rtrim($query," AND");

        $results = $this->results_object($query);

        return $results;
    }

    /**
     * Preparar query INSERT INTO simples e enviar para metodo results_object.
     *
     * @param string      $table  tabela selecionada
     * @param array       $fields campos e valores da tabela preencher
     * @param bool|string $output caso seja necessário devolver algum campo da tabela
     *
     * @return array|object
     */
    public function insert($table, array $fields, $output = false){

        $query = 'INSERT INTO '.$table;

        $keys = implode (", ", array_keys( $fields ) );
        $query .= ' ('.$keys.')';

        $values = implode (", ", $fields );

        if ( $output ){
            $query .= ' OUTPUT INSERTED.'.$output.' VALUES ('.$values.')';
            $results = $this->results_object($query);
        }else{
            $query .= ' VALUES ('.$values.')';
            $this->query($query);
            $results[] = 'OK';
        }

        return $results;
    }

    /**
     * Preparar query SELECT simples e enviar para metodo results_object.
     * Apenas com possibilidade de AND nas condições.
     *
     * @param string      $table      tabela selecionada
     * @param array       $conditions condições WHERE
     * @param bool|string $output     caso seja necessário devolver algum campo da tabela
     *
     * @return array|object
     */
    public function delete($table, array $conditions, $output = false){

        $query = 'DELETE FROM '.$table;

        if ( $output ){
            $query .= ' OUTPUT DELETED.'.$output;
        }

        $query .= ' WHERE';

        foreach( $conditions as $key=>$value ){
            $query .= ' '.$key.'='.$value.' AND';
        }
        $query = rtrim($query," AND");

        if ( $output ){
            $results = $this->results_object($query);
        }else{
            $this->query($query);
            $results[] = 'OK';
        }

        return $results;
    }

    /**
     * Preparar query UPDATE simples e enviar para metodo results_object.
     * Apenas com possibilidade de AND nas condições.
     *
     * @param string      $table         tabela selecionada
     * @param array       $fields_insert campos e valores a editar
     * @param array       $conditions    condições WHERE
     * @param bool|string $output        caso seja necessário devolver algum campo da tabela
     *
     * @return array|object
     */
    public function update($table, $fields_insert, $conditions, $output = false){

        $query = 'UPDATE '.$table;

        $query .= ' SET';

        foreach( $fields_insert as $key=>$value ){
            $query .= ' '.$key.'='.$value.',';
        }

        $query = rtrim($query,',');

        if ( $output ){
            $query .= ' OUTPUT INSERTED.'.$output;
        }

        $query .= ' WHERE';

        foreach( $conditions as $key=>$value ){
            $query .= ' '.$key.'='.$value.' AND';
        }

        $query = rtrim($query," AND");

        if ( $output ){
            $results = $this->results_object($query);
        }else{
            $this->query($query);
            $results[] = 'OK';
        }

        return $results;
    }

    /**
     * Fechar conexão com servidor SQL
     *
     * @return void
     */
    public function __destruct() {
        if (!is_null($this->conn)) {
            sqlsrv_close($this->conn);
        }
    }
}

?>

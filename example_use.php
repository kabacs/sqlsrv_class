<?php
/**
 * Exemplos de uso para class connection
 * @author Antonio Santos
 * @version 0.1
 */
 
$db = new connection();

/**
 * Exemplo de insert
 */
$fields_insert = array(
    'field1' => 'first inserted field',
    'field2' => 'second inserted field',
    'field3' => 'third inserted field'
);
$result = $db->insert( 'table_name', $fields_insert, 'id' );

/**
 * Exemplo de select
 */
$result = $db->select( 'table_name', array('*'), array('id'=>1) );

/**
 * Exemplo de update
 */
$fields_update = array(
    'field1' => 'first updated field',
    'field2' => 'second updated field',
    'field3' => 'third updated field'
);
$conditions = array(
    'user' => 'tester'
);
$result = $db->update( 'table_name', $fields_update, $conditions, 'id' );

/**
 * Exemplo de delete
 */
 $conditions = array(
    'id' => 1
);
$result = $db->delete( 'table_name', $conditions );

/**
 * Exemplo de outras queries
 */
 $result = $db->results_object( 'SELECT e.first_name, e.last_name, u.user_type, u.username FROM table_name AS e INNER JOIN second_table_name AS u ON e.id = u.employee_id' );

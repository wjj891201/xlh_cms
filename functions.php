<?php
/**
 * [p 调试函数]
 * @param  [type]  $data [数据]
 * @param  [type]  $exit [结束]
 * @return [type]        []
 */
function p($data='', $exit=0){
    echo '<pre>';    
    if(is_array($data)){
        print_r($data);
    }elseif(is_bool($data)){
        echo $data ? 'true' : 'false';
    }elseif(is_null($data)){
        echo 'null';
    }elseif(is_object($data)){
        print_r((array)$data);
    }else{
        echo $data; 
    } 
    echo '</pre>';
    !$exit or exit;        
}

/**
 * [getLastSql 打印SQl]
 * @param  [resource] $query [数据库资源]
 * @return [string]          [sql语句]
 */
function getLastSql($query=NULL){
    $sql = '';
    if(!empty($query)){
        $queryCommand = clone $query;
        $sql = $queryCommand->createCommand()->getSql();
    }
    echo $sql;
}
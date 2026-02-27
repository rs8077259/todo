<?php 
namespace Util;
function cluster(array $arr):array{
    $cluster=[];
    foreach($arr as $element){
        $key = array_keys($cluster);
        if(in_array($element['todo_id'],$key)){
            array_push($cluster[$element['todo_id']],$element);
        }
        else{
            $cluster[$element["todo_id"]] =[];
            array_push($cluster[$element['todo_id']],$element);

        }
    }
    return $cluster;
}

/* $a=[
    [
        'todo_id'=>'dhkjfhjkldshfkjdshkfjhsdjkfhskjdhfkjsdh',
        "random"=>"fkldfhoidhfodsofhfdklfhfdh",
        "y"=>9374437
    ],
    [
        'todo_id'=>'dhkjfhjkldshfkjdshkfjhsdjkfhskjdhfkjsdh',
        "random"=>"dejabu",
        "y"=>12022005
    ],
    [
        'todo_id'=>'dhkjfhjkldshfkjdidfhikdhklhkfjhsdjkfhskjdhfkjsdh',
        "random"=>"fkldfhoidhfodsofhfdklfhfdh",
        "y"=>9374437
    ],
    [
        'todo_id'=>'dhkjfhjkldshfkjdfjkdhjkshkfjhsdjkfhskjdhfkjsdh',
        "random"=>"fkldfhoidhfodsofhfdklfhfdh",
        "y"=>9374437
    ],
    [
        'todo_id'=>'dhkjfhjkldshfkjdshkfjhwerioruysdjkfhskjdhfkjsdh',
        "random"=>"fkldfhoidhfodsofhfdklfhfdh",
        "y"=>9374437
    ],
]; */

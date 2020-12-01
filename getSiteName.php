<?php
    $list = ['abc', 'def'];
    $arr = array('a' => '', 'b' => $list, 'c' => '', 'd' => '', 'e' => '');
    echo json_encode($arr);
?>
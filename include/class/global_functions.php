<?php

function VD(&$var) {
    echo '<br><pre>'.print_r($var, true).'</pre>';
}

function BR($lines = 1) {
    echo str_repeat('<br>', $lines);
}
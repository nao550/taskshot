<?php

function h($str)
{
    return  htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function filter_post($str)
{
    return filter_input(INPUT_POST, $str, FILTER_SANITIZE_SPECIAL_CHARS);
}

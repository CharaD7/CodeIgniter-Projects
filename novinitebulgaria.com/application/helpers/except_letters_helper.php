<?php

function except_letters($str)
{
    return mb_ereg_replace('[^a-zA-Zа-яА-Я0-9\s]', '', $str);
}

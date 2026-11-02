<?php

function sysData($field)
{

    global $sysConfig;

    return $sysConfig[$field] ?? false;
}

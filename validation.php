<?php

function validName($name): bool
{
    if ($name != "" || $name != null) {
        return true;
    }
    return false;
}

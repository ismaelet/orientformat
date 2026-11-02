<?php

if (user()->groupId) {
    redirect_old('/');
}

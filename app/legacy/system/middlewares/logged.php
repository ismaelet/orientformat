<?php

if (! logged()) {
    redirect_old('/login');
}

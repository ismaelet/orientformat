<?php

if (sysData('static') || logged()) {
    redirect_old(sysData('logged-redirect'));
}

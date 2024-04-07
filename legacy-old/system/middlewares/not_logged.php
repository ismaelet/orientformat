<?php

if (sysData('static') || logged()) redirect(sysData('logged-redirect'));
<?php

use Legacy\Activity\Test;

$sibling = new Test($legacyTest->step - 1, $user);

header('Location: '.$sibling->url);
exit();

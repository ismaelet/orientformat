<?php

$sibling = new \Legacy\Activity\Test($test->step - 1, $user);

header('Location: ' . $sibling->url);
exit();

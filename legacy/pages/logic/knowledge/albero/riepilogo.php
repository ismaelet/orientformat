<?php

$sibling = new \Legacy\Activity\Test($legacyTest->step - 1, $user);

header('Location: ' . $sibling->url);
exit();

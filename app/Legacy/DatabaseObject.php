<?php

namespace App\Legacy;

trait DatabaseObject {
	use ConstructFromDatabase;
	use DynamicProperties;
}

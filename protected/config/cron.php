<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/cron_config.php'),
	require(dirname(__FILE__).'/database.php')
);

<?php 
require('vendor/autoload.php');

define("pk_test","pk_test_51R91QA4cU8xLEUc1PfA6xs7gzRRiRp38peftdZ28SfGJm9I0ertnAl0q4d77JjVLZPFiBjgUoy9Gh7yB8cgAbDok00rR4pHhUe");
define("sk_test","sk_test_51R91QA4cU8xLEUc1M20n0KUzljaeHuvqoSIUQ2ewjCRt7Rwd4E5FTFLxR45qunReYWeorlbEtZPE0KTHwdnn8kY100aUcIxqUn");

\Stripe\Stripe::setApiKey($sk_test);
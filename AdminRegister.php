<?php

use App\classes\CLIBankingApp;

require "vendor/autoload.php";

$cliBankingApp = new CLIBankingApp();
$cliBankingApp->runAdminRegister();
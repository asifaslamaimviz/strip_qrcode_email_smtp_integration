<?php 
require('stripe-php-master/init.php');
$publishableKey="pk_test_51M35IfLsuGyV4cRXL5d9GrGV7UiTCSw84LcVwHXm4aqH3SIJsWtWSqFDMhmltCpzFQZVUpPD8zpEr18fuHNF3rl000AJifjLUl";
$secretKey="sk_test_51M35IfLsuGyV4cRXK0KqilRKIZ1bvz1oo9wvilJrrMSTOtJiZgjuG6Sfhg9FL1wPcDtTCqFMJyJg2gV6RqUbpvUj00HlBgD4El";
\Stripe\Stripe::setApiKey($secretKey);
?>
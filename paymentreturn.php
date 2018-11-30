<?php
$status = database_read($_GET["order_id"]);
echo "<p>Your payment status is '" . htmlspecialchars($status) . "'.</p>";
<?php
$pwd = password_hash("quack", PASSWORD_DEFAULT);
echo $pwd;
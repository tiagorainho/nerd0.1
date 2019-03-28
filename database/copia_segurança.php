<?php 

mysql --user=username --password=passwd -e 'DROP DATABASE test_db;'
mysql --user=username --password=passwd -e 'CREATE DATABASE test_db;'
mysqldump --user=username --password=passwd live_db | mysql --user=username --password=passwd test_db
    
?>
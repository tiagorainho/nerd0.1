mysql --user="root" --password="" -e 'DROP DATABASE inventario;'
mysql --user="root" --password="" -e 'CREATE DATABASE inventario;'
mysqldump --user="root" --password=""  inventario  | mysql --user="root" --password=""   projetos 
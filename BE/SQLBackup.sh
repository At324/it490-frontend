#/bin/bash
mysqldump -u root -p login > backup.sql
echo "Backup complete"

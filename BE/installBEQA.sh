echo "start"

tar -xzf /home/sean/tmp/BEPackage-Version-.tar.gz /home/sean/packages

mysql -u root -p login < home/sean/packages/sqlBackup/sqlBackup.sql

mkdir /home/sean/Desktop/it490-frontend/BE
mv /home/sean/packages/ home/sean/Desktop/it490-frontend/BE
echo "complete"

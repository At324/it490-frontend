
echo "started packaging"

	cd /home/sean/tmp
	echo "MySQL Password?"
		mkdir sqlBackup
			cd sqlBackup/
				mysqldump -u root -p login > backup_sql.sql
				cd ..
	
	
	cp -a /home/sean/Desktop/it490-frontend/BE /home/sean/tmp/

	tar -zcvf BEPackage-Version-.tar.gz /home/sean/tmp/ . 
	
	scp -r BEPackage-Version-.tar.gz sean@10.10.10.116:/home/sean/zip/
	echo "Sent"
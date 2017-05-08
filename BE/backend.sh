
echo "started packaging"

package=`php deploy.php BEPackage-Version- | xargs`
	cd /tmp/
	echo "MySQL Password?"
		mkdir sqlBackup
			cd sqlBackup/
				mysqldump -u root -p login > backup_sql.sql
				cd ..
				cd ..
	
	BESource=/home/sean/Documents/it490-frontend/BE
		cp -a $BESource* /tmp/

	tar -czvf BEPackage-Version-"$package".tar.gz -C /tmp/ . 
		
		rm -r /tmp/BE/
		rm -r /tmp/sqlBackup/
        echo `ls | grep BEPackage-Version-"$package"`
		echo "Bundle Complete"
	
	# Scp package to the deploy server
	echo "Sending to deploy server..."
	scp -r BEPackage-Version-"$package".tar.gz sean@127.0.0.1:/home/sean/packages/
	
	cp BEPackage-Version-"$package".tar.gz BE/
	rm BEPackage-Version-"$package".tar.gz
	php update.php BEPackage-Version-"$package".tar.gz "$package"
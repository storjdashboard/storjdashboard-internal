#!/bin/bash
clear
echo "---------------------------------------"
echo "---------------------------------------"
echo "  STORJDASHBOARD - INTERNAL - UPDATER  "
echo "---------------------------------------"
echo "---------------------------------------"
echo
echo "WebRoot: $1"
echo "New Download File: $2"
echo "Version: $3"
echo 
echo "Please check the above contains the correct information before proceeding."
echo
read -r -p "Are you sure? [y/N] " response
if [[ "$response" =~ ^([yY][eE][sS]|[yY])$ ]]
then
     echo "Extracting TAR"
	 cd "$1/include_content/scripts/update/downloads/"
	 tar -xf "$1/include_content/scripts/update/downloads/$2"
	 echo "Extracted"
	 echo "Removing Connections Folder"
	 cd "storjdashboard-internal-$3/web/" #now in the extracted directory
	 rm -r "Connections"
	 echo "Removing cfg.php"
	 rm "cfg.php"
	 cd "$1/include_content/scripts/update/downloads/"
	 echo "Removing Downloaded File"
	 rm $2
	 echo "Deleted Downloaded File"
else
    echo "nothing left to do... Exiting.."
fi
echo 
echo "If there has been any errors so far... DO NOT CONTINUE..."

read -r -p "Continue? [y/N] " response2
if [[ "$response2" =~ ^([yY][eE][sS]|[yY])$ ]]
then
	#y
	clear
	echo "Starting Sync"
	echo
	rsync -avh "$1/include_content/scripts/update/downloads/storjdashboard-internal-$3/web/" "$1/"
	echo "Setting Permissions"
	chmod -R ugo+rw "$1/"
	echo "Cleaning Downloads Folder"
	rm -R "$1/include_content/scripts/update/downloads/"
	mkdir "$1/include_content/scripts/update/downloads/"
	echo "Setting Write Folder"
	chmod -R 777 "$1/include_content/scripts/update/downloads/"
	echo "Setting www-data as file owner"
	chown -R www-data "$1"

else
    	#n
	echo "nothing left to do... Exiting.."
fi
echo "----------------------"
echo "-------COMPLETED------"
echo "----------------------"

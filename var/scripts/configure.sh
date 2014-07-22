#!/bin/bash
# $1 Target directory name
BASE=${PWD}

if [ -d $BASE/$1 ]; then
	echo "Directory already exists, aborting."
else
	git clone https://github.com/strackovski/app-skeleton.git $1
	echo "Configuring project with name $1..."
	sed -i "s/app-skeleton/$1/" $BASE/$1/composer.json
	sed -i "s/app-skeleton/$1/" $BASE/$1/.htaccess
	find $BASE/$1/src/ -type f -exec \
	    sed -i "s/PROJECT_NAME/$1/g" {} +
	echo 'Project ready!';
fi

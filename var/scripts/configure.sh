#!/bin/bash
# $1 Project name
BASE=${PWD}

if [ -z "$1" ]; then
    echo "Undefined project name, aborting."
else
	echo "Configuring project with name $1..."
	sed -i "s/app-skeleton/$1/" $BASE/composer.json
	sed -i "s/app-skeleton/$1/" $BASE/.htaccess
	find $BASE/src/ -type f -exec \
	    sed -i "s/PROJECT_NAME/$1/g" {} +
	echo 'Project configured, run composer install to install dependencies.';
fi
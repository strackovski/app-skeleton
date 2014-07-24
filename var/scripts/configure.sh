#!/bin/bash
# $1 Project name
# Script directory (this file)
BASE="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

if [ -z "$1" ]; then
    printf "Required argument project-name missing.\n"
    printf "Usage: ./configure.sh <project-name> [--auto-install]\n"
    exit 1
else
    cd $BASE
	cd ../..

	printf "Configuring project with name $1, located in ${PWD##*/} ...\n"

	if [ ! -f composer.json ]; then
        printf "Required file composer.json not found in project root!\n"
        exit 1
    fi

    if [ ! -d src ]; then
           printf "Directory 'src' not found in project root.\n"
           printf "Are you missing project sources?\n"
           exit 1
    fi

	if [ ! -f .htaccess ]; then
        printf ".htaccess not found, URL rewriting will not work if it relies on it!\n"
    else
        sed -i "s/app-skeleton/$1/" .htaccess
    fi

    if [ ! -f phpdoc.xml ]; then
        printf "phpdoc.xml not found, skipping...\n"
    else
        sed -i "s/app-skeleton/$1/" phpdoc.xml
    fi

    sed -i "s/app-skeleton/$1/" composer.json
	find src/ -type f -exec \
	    sed -i "s/PROJECT_NAME/$1/g" {} +

    if [ $2 ]; then
        if [ $2 == "--auto-install" ]; then
            printf "Executing composer's installation command...\n"
            composer install
            exit 0
        else
            printf "Invalid flag $2 \n"
            exit 1
        fi
    else
        printf "Project configured, run composer install to install dependencies.\n";
    fi
fi

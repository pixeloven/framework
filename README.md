# pixeloven/framework
[![Build Status](https://dev.azure.com/pixeloven/Framework/_apis/build/status/pixeloven.framework?branchName=master)]

A simple framework to extend Laravel/Lumen

## Setup
The quickest way to get setup is to fist ensure you have docker installed. Then proceed to run the following:
```
docker-compose build
```
This will create a php-7.2 docker image and container with everything we need to run and verify our code. Once complete we can run the composer through our newly minted container.
```
docker-compose run php-7.2 composer install
```

## Code Quality Testing
There are two simple steps for verifying your changes.

### Testing
This compors alias can be found in the composer.json file under scripts. We utilizes PHPUnit for all testing.
```
docker-compose run php-7.2 composer test
```


#### Linting
This compors alias can be found in the composer.json file under scripts. We utilizes PHPCodesniffer for all liniting needs.
```
docker-compose run php-7.2 composer lint
```

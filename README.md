# pixeloven/framework

[![Build Status](https://dev.azure.com/pixeloven/Framework/_apis/build/status/pixeloven.framework?branchName=master)](https://dev.azure.com/pixeloven/Framework/_build/latest?definitionId=1&branchName=master)
[![Donate](https://img.shields.io/badge/donate-paypal-blue.svg)](https://paypal.me/briangebel)

A simple framework to extend Laravel/Lumen

## Setup
The quickest way to get setup is to fist ensure you have docker installed. Then proceed with running the following:
```
docker-compose build
```
This will create a php-7.4 docker image and container with everything we need to run and verify our code. Once complete we can run the composer through our newly minted container.
```
docker-compose run php-7.4 composer install
```
## Code Quality Testing
There are two simple steps for verifying your changes.

### Testing
This compors alias can be found in the composer.json file under scripts. We utilizes PHPUnit for all testing.
```
docker-compose run php-7.4 composer test
```

#### Linting
This compors alias can be found in the composer.json file under scripts. We utilizes PHPCodesniffer for all liniting needs.
```
docker-compose run php-7.4 composer lint
```

## Usage
The Http model is meant to help abstract the request into an input model. The example below shows how it might be used in production. 

First we have our Address model which defines how our API accepts address.

```php
<?php

declare(strict_types=1);

namespace App\Http\Models;

use PixelOven\Http\Model;

/**
 * @SWG\Definition(
 *     type="object",
 *     required={"street", "postal", "region", "country"},
 *     @SWG\Xml(
 *         name="AddressBody"
 *     )
 * )
 *
 * Class AddressBody
 * @package App\Http\Models
 */
class AddressBody extends Model
{
    /**
     * @SWG\Property(
     *     description="Street address",
     * )
     * @var string
     */
    public $street;

    /**
     * @SWG\Property(
     *     description="Postal code",
     * )
     * @var string
     */
    public $postal;

    /**
     * @SWG\Property(
     *     description="Region, Province or State",
     * )
     * @var string
     */
    public $region;

    /**
     * @SWG\Property(
     *     description="Country",
     * )
     * @var string
     */
    public $country;

}
```

Then building off of this we define our User model which has a relationship with Address.
```php
<?php

declare(strict_types=1);

namespace App\Http\Models;

use PixelOven\Http\Model;

/**
 * @SWG\Definition(
 *     type="object",
 *     required={"email", "name"},
 *     @SWG\Xml(
 *         name="UserBody"
 *     )
 * )
 *
 * Class UserBody
 * @package App\Http\Models
 */
class UserBody extends Model
{
    protected $relations = [
      'address' => AddressBody::class
    ];

    /**
     * @SWG\Property(
     *     description="User's email",
     * )
     * @var string
     */
    public $email;

    /**
     * @SWG\Property(
     *     description="User's full name",
     * )
     * @var string
     */
    public $name;

    /**
     * @SWG\Property(
     *     description="Address body",
     * )
     * @var AddressBody
     */
    public $address;

}
```

As we can see from the above User now is related to address where address is a nested property. There is nothing stoping us from also extending a model if we wish for a flatter structure.

Lastly we can use these models to replace the raw Request object. 
```php
<?php

declare(strict_types=1);

  /**
     * @SWG\Post(
     *     path="/pixeloven/v1/user",
     *     summary="Create user",
     *     tags={"V1 User"},
     *     description="Create a new user",
     *     operationId="createUser",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="UserBody",
     *         in="body",
     *         description="User object",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/UserBody")
     *     ),
     *     @SWG\Response(ref="#/responses/201", response=201),
     *     @SWG\Response(ref="#/responses/404", response=404),
     *     @SWG\Response(ref="#/responses/422", response=422),
     *     @SWG\Response(ref="#/responses/500", response=500)
     * )
     *
     * @param UserBody $model
     */
    public function createUser(
        UserBody $model,
    ) {
        $model->validate([
            'email' => ['required', 'string', 'email'],
            'name' => ['required', 'string'],
        ]);

        $userEmail = $model->email;
        $userName = $model->name;
        $userAddress = $model->address;


        // ...
```
In this particular example we are also leveraging:
```
darkaonline/swagger-lume
```
This package allows us to use swagger annotations along side our request model.

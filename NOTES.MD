High level plan
1) Add support for laravel responder 
2) Find/implement an appropriate JWT library for authentication protecting against common vulnerabilities.
3) Find/implmenent Paseto. https://github.com/paragonie/paseto for laravel
4) extend laravel native event system to support kafka more nautrally

We should add better support for laravel and lumen
```
    "require": {
        "php": ">=7.4",
        "laravel/lumen-framework": ">=6.0"
    },
```

Currently we rely on a few dependecies from the lumen framework. Either we make the decision to only support lumen or push for supporting both.
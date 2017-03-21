# Leaderboard API - build with Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

## Use

```
GET: http://localhost/api/v1/{leaderboard_name}
GET: http://localhost/api/v1/{leaderboard_name}/{limit}

If limit is not defined, you'll receive all leaderboard items.

Response (array of leaderboard items):  
[
  {
    "id":5,
    "leaderboard":"tennis",
    "name":"Daniel",
    "image":"images/1490066401_x1niktqy.png",
    "score":132,
    "rank":1,
    "created_at":"2017-03-21 03:20:01",
    "updated_at":"2017-03-21 03:20:01"
  }
]```


```
POST URL: http://localhost/api/v1/{leaderboard_name}
POST DATA:
{
  "leaderboard": "tennis",    // required | string | min:3
  "name": "Daniel",           // required | string | min:2
  "score": 132,               // required | numeric
  "image": {attach image},    // optional
}

RESPONSE:  
{
  "id":5,
  "leaderboard":"tennis",
  "name":"Daniel",
  "image":"images/1490066401_x1niktqy.png",
  "score":132,
  "rank":1,
  "created_at":"2017-03-21 03:20:01",
  "updated_at":"2017-03-21 03:20:01"
}
```
### Loading images:
server + '/storage/' + image field from the api like:  
`http://localhost:8000/storage/images/1490066401_x1niktqy.png`

## Installation
* This requires Php/Mysql environment (e.g. MAMP)
* Clone the repository
* Install composer
* run  `composer install`
* set up mysql database and database user
* set up .env file

Create a symbolic link to be able to serve stored files:  
On Mac OS X:  
`ln -s /path/to/laravel/storage/app/public /path/to/laravel/public/storage`

If you are on windows you can run this command on cmd:  
`mklink /j /path/to/laravel/public/storage /path/to/laravel/storage/app/public`


---

### Official Lumen Documentation
Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

### Lumen License
The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

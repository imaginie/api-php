# Imaginie PHP API Client

A PHP Client implementation of Imaginie API v3 methods

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

PHP >= 7.1
[Composer](https://getcomposer.org/doc/00-intro.md) - Dependency Manager for PHP

### Installing

Make sure you have the prerequisites above and then you can install our library using composer.
Navigate to your project folder and type:

```
$ composer require imaginie/api-client
```

### Usage

Composer generates a **autoload.php** file in vendor **folder**.
Include this file and then you can use our library.

```
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$Imaginie->login(); // this is not required - it returns the JWT token
$students = $Imaginie->getStudents();
var_dump($students);
```

## Implemented methods

**login()** - returns the JWT token

```
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$Imaginie->login();

// You can get the token by this whay as well
$Imaginie->getToken();

// Or if you have a token, you can set it
$Imaginie->setToken('YourTokenHere');
```

**getStudents()** - returns a list with your school students

```
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$students = $Imaginie->getStudents();
var_dump($students);
```

**getStudent($id)** - returns a specific student

```
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$student = $Imaginie->getStudent(1234567890);
var_dump($student);
```

## Samples

There is a **samples** folder with many examples

## API Docs

* [Imaginie API v3 doc](https://imaginiev3.docs.apiary.io) - Doc of our last API version
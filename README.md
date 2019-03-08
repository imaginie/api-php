# Imaginie PHP API Client

A PHP Client implementation of Imaginie API v3 methods

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

- PHP >= 7.1
- [Composer](https://getcomposer.org/doc/00-intro.md) - Dependency Manager for PHP

### Installing

Make sure you have the prerequisites above and then you can install our library using composer.
Navigate to your project folder and type:

```shell-script
$ composer require imaginie/api-client
```

### Usage

Composer generates a **autoload.php** file in vendor **folder**.
Include this file and then you can use our library.

```php
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

```php
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

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$students = $Imaginie->getStudents();
var_dump($students);
```

response:

```json
[
	{
		"code": "123456",
		"email": "teste@teste.com.br",
		"name": "João do Teste",
		"class_code": [
			"XPTOEM3A"
		]
	},
	{
		"code": "123456",
		"email": "teste@teste.com.br",
		"name": "João do Teste",
		"class_code": [
			"XPTOEM3A"
		]
	}
]
```


**getStudent($id)** - returns a specific student

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$student = $Imaginie->getStudent(1234567890);
var_dump($student);
```

response:

```json
{
	"code": "123456",
	"email": "teste@teste.com.br",
	"name": "João do Teste",
	"class_code": [
		"XPTOEM3A"
	]
}
```

**createStudent($name, $email, $code, $class_code=null)** - returns an object with the created student

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$student = $Imaginie->createStudent('Michael Jackson', 'student@email.com', 'STD001', 'ABC123');
var_dump($student);
```

response:

```json
{
	"code": "STD001",
	"email": "student@email.com",
	"name": "Michael Jackson",
	"class_code": [
		"ABC123"
	]
}
```

**updateStudent($id, $name, $email, $code=null, $class_code=null)** - returns an object with the updated student

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$student = $Imaginie->updateStudent(19642009, 'Michael Joseph Jackson', 'michael@jackson.com');
var_dump($student);
```

response:

```json
{
	"code": "STD001",
	"email": "student@email.com",
	"name": "Michael Jackson",
	"class_code": [
		"ABC123"
	]
}
```

**deleteStudent($id)**

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
try
{
    $Imaginie->deleteStudent(1234567890);
}
catch (Exception $ex)
{
    die($ex->getMessage());
}
```

**getClasses()** - returns a list with your school Classes

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$classes = $Imaginie->getClasses();
var_dump($classes);
```

response:

```json
[
	{
    "id": 123,
    "name": "Ensino Médio",
    "description": "Ensino Médio",
    "code": "EM1",
    "parent": "ESC123",
    "school": "Teste",
    "school_id": 123,
    "total_students": 0
  },
	{
    "id": 123,
    "name": "Ensino Médio",
    "description": "Ensino Médio",
    "code": "EM1",
    "parent": "ESC123",
    "school": "Teste",
    "school_id": 123,
    "total_students": 0
  }
]
```

**getClass($id)** - returns a specific Class

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$class = $Imaginie->getClass(1234567890);
var_dump($class);
```

response:

```json
{
  "id": 123,
  "name": "Ensino Médio",
  "description": "Ensino Médio",
  "code": "EM1",
  "parent": "ESC123",
  "school": "Teste",
  "school_id": 123,
  "total_students": 0
}
```

**createClass($name, $description, $code, $parent_code=null)** - returns an object with the created Class

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$class = $Imaginie->createClass('Ensino Médio', 'Ensino Médio', 'EM1', 'ESC123');
var_dump($class);
```

response:

```json
{
  "id": 123,
  "name": "Ensino Médio",
  "description": "Ensino Médio",
  "code": "EM1",
  "parent": "ESC123",
  "school": "Teste",
  "school_id": 123,
  "total_students": 0
}
```

**updateClass($id, $name, $email, $code=null, $class_code=null)** - returns an object with the updated Class

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$class = $Imaginie->updateClass(19642009, 'Ensino Médio', 'Ensino Médio', 'EM1', 'ESC123');
var_dump($class);
```

response:

```json
{
  "id": 123,
  "name": "Ensino Médio",
  "description": "Ensino Médio",
  "code": "EM1",
  "parent": "ESC123",
  "school": "Teste",
  "school_id": 123,
  "total_students": 0
}
```

**deleteClass($id)**

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
try
{
    $Imaginie->deleteClass(1234567890);
}
catch (Exception $ex)
{
    die($ex->getMessage());
}
```

**getAssessments()** - returns a list with your school Assessments

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$assessments = $Imaginie->getAssessments();
var_dump($assessments);
```

response:

```json
[
  {
    "id": 742,
    "theme": 399,
    "theme_title": "Ocupação das escolas de São Paulo: a educação é para todos?",
    "classes": [
      {
        "code": "XPTOEM3A",
        "name": "A",
        "description": "XPTO/EnsinoMedio/3/A"
      }
    ],
    "created": "2017-08-06T00:04:03.382545",
    "school_correction": false,
    "school_payment": false,
    "number_of_corrections": 1,
    "drafts_available": "2017-01-01T00:00:00",
    "deadline": "2017-12-01T00:00:00",
    "draft_count": 0,
    "sent_count": 0,
    "finished_count": 0
  },
  {
    "id": 742,
    "theme": 399,
    "theme_title": "Ocupação das escolas de São Paulo: a educação é para todos?",
    "classes": [
      {
        "code": "XPTOEM3A",
        "name": "A",
        "description": "XPTO/EnsinoMedio/3/A"
      }
    ],
    "created": "2017-08-06T00:04:03.382545",
    "school_correction": false,
    "school_payment": false,
    "number_of_corrections": 1,
    "drafts_available": "2017-01-01T00:00:00",
    "deadline": "2017-12-01T00:00:00",
    "draft_count": 0,
    "sent_count": 0,
    "finished_count": 0
  }
]
```

**getAssessment($id)** - returns a specific Assessment

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$assessment = $Imaginie->getAssessment(1234567890);
var_dump($assessment);
```

response:

```json
{
  "id": 1234567890,
  "theme": 399,
  "theme_title": "Ocupação das escolas de São Paulo: a educação é para todos?",
  "classes": [
    {
      "code": "XPTOEM3A",
      "name": "A",
      "description": "XPTO/EnsinoMedio/3/A"
    }
  ],
  "created": "2017-08-06T00:04:03.382545",
  "school_correction": false,
  "school_payment": false,
  "number_of_corrections": 1,
  "drafts_available": "2017-01-01T00:00:00",
  "deadline": "2017-12-01T00:00:00",
  "draft_count": 0,
  "sent_count": 0,
  "finished_count": 0
}
```

**createAssessment($theme_id, $drafts_available, $deadline, $class_code=null)** - returns an object with the created Assessment

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$assessment = $Imaginie->createAssessment(399, "2017-01-01T00:00:00", "2017-12-01T00:00:00", "XPTOEM3A");
var_dump($assessment);
```

response:

```json
{
  "id": 1234567890,
  "theme": 399,
  "theme_title": "Ocupação das escolas de São Paulo: a educação é para todos?",
  "classes": [
    {
      "code": "XPTOEM3A",
      "name": "A",
      "description": "XPTO/EnsinoMedio/3/A"
    }
  ],
  "created": "2017-08-06T00:04:03.382545",
  "school_correction": false,
  "school_payment": false,
  "number_of_corrections": 1,
  "drafts_available": "2017-01-01T00:00:00",
  "deadline": "2017-12-01T00:00:00",
  "draft_count": 0,
  "sent_count": 0,
  "finished_count": 0
}
```

**updateAssessment($id, $name, $email, $code=null, $class_code=null)** - returns an object with the updated Assessment

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
$assessment = $Imaginie->updateAssessment(1234567890, 399, "2017-01-01T00:00:00", "2017-12-01T00:00:00", "XPTOEM3A");
var_dump($assessment);
```

response:

```json
{
  "id": 1234567890,
  "theme": 399,
  "theme_title": "Ocupação das escolas de São Paulo: a educação é para todos?",
  "classes": [
    {
      "code": "XPTOEM3A",
      "name": "A",
      "description": "XPTO/EnsinoMedio/3/A"
    }
  ],
  "created": "2017-08-06T00:04:03.382545",
  "school_correction": false,
  "school_payment": false,
  "number_of_corrections": 1,
  "drafts_available": "2017-01-01T00:00:00",
  "deadline": "2017-12-01T00:00:00",
  "draft_count": 0,
  "sent_count": 0,
  "finished_count": 0
}
```

**deleteAssessment($id)**

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
try
{
    $Imaginie->deleteAssessment(1234567890);
}
catch (Exception $ex)
{
    die($ex->getMessage());
}
```

## Samples

There is a **samples** folder with many examples

## API Docs

* [Imaginie API v3 doc](https://imaginiev3.docs.apiary.io) - Doc of our last API version
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

**getStudentEssays($student_code, $essay_status=null)**

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
try
{
    $Imaginie->getStudentEssays('STD001');
}
catch (Exception $ex)
{
    die($ex->getMessage());
}
```

response:

```json
[
  {
    "id": 331324,
    "theme": {
      "id": 564,
      "title": "Impactos ambientais do consumo no século XXI",
      "signed_thumb": "https://s3-sa-east-1.amazonaws.com/img.br/images/themes/2017/2/21/bb82b544-f85a-11e6-b266-024749005da7/impactos-ambientais-do-consumojpg?Signature=GrtYmaMB1%2FyWEtxYmUC3hxa%2Bl7A%3D&Expires=1502162722&AWSAccessKeyId=AKIAJT6DYWKITELZRSQQ",
      "school": null
    },
    "status": "CORRECTED",
    "assessment": null,
    "final_score": 0,
    "created": "2017-03-06T22:54:54Z",
    "report": "Fuga ao tema",
    "exam": 2,
    "school": {
      "logo": "https://app.imaginie.com/static/images/logo-icone-50px.png",
      "name": "Imaginie"
    },
    "author": 24765,
    "author_code": "MariaZ",
    "sent_correction": "2017-03-06T22:59:21Z",
    "finished": "2017-06-20T17:10:33Z",
    "deadline": null,
    "criteria_values": [
      {
        "name": "Critério 1 - Demonstrar domínio da norma culta",
        "criteria_value": 0,
        "color": "#ffff00"
      },
      {
        "name": "Critério 2 - Compreender a Proposta",
        "criteria_value": 0,
        "color": "#ff9634"
      },
      {
        "name": "Critério 3 - Selecionar, relacionar argumentos",
        "criteria_value": 0,
        "color": "#5e7bff"
      },
      {
        "name": "Critério 4 - Conhecer os mecanismos linguísticos para a construção da argumentação",
        "criteria_value": 0,
        "color": "#0cff66"
      },
      {
        "name": "Critério 5 - Elaborar a proposta de solução para o problema ",
        "criteria_value": 0,
        "color": "#fe02ff"
      }
    ]
  },
  {
    "id": 331323,
    "theme": {
      "id": 564,
      "title": "Impactos ambientais do consumo no século XXI",
      "signed_thumb": "https://s3-sa-east-1.amazonaws.com/img.br/images/themes/2017/2/21/bb82b544-f85a-11e6-b266-024749005da7/impactos-ambientais-do-consumojpg?Signature=7nYB9EypC1Aoevn8Gm9ENofdDnI%3D&Expires=1502161673&AWSAccessKeyId=AKIAJT6DYWKITELZRSQQ",
      "school": null
    },
    "status": "CORRECTED",
    "report": "Válida",
    "assessment": null,
    "final_score": 840,
    "created": "2017-03-06T20:16:51Z",
    "exam": 2,
    "school": {
      "logo": "https://app.imaginie.com/static/images/logo-icone-50px.png",
      "name": "Imaginie"
    },
    "author": 24765,
    "author_code": "123456",
    "sent_correction": "2017-03-06T22:59:01Z",
    "finished": "2017-06-19T13:23:09Z",
    "deadline": null,
    "criteria_values": [
      {
        "name": "Critério 1 - Demonstrar domínio da norma culta",
        "criteria_value": 120,
        "color": "#ffff00"
      },
      {
        "name": "Critério 2 - Compreender a Proposta",
        "criteria_value": 160,
        "color": "#ff9634"
      },
      {
        "name": "Critério 3 - Selecionar, relacionar argumentos",
        "criteria_value": 200,
        "color": "#5e7bff"
      },
      {
        "name": "Critério 4 - Conhecer os mecanismos linguísticos para a construção da argumentação",
        "criteria_value": 160,
        "color": "#0cff66"
      },
      {
        "name": "Critério 5 - Elaborar a proposta de solução para o problema ",
        "criteria_value": 200,
        "color": "#fe02ff"
      }
    ]
  }
]
```

**createEssay($student_code, $theme_id, $assessment_id, $request_correction, $school_correction, $image_url, $comments_required)**

```php
<?php
require_once  '/path/to/vendor/autoload.php';
use ApiClient\Imaginie;

$Imaginie = new Imaginie('your@login.com', 'your-password');
try
{
    $Imaginie->createEssay(24765, 399, 743, true, false, 'http://www.google.com', true);
}
catch (Exception $ex)
{
    die($ex->getMessage());
}
```

response:

```json
{
  "id": 334575,
  "author": 24765,
  "theme": 399,
  "assessment": 743,
  "font_size": null,
  "text": null,
  "request_correction": true,
  "ready_to_correction": false,
  "image_url": "http://www.google.com",
  "uuid_str": "7a5b2f99-7a43-11e7-b0b1-14109fe485f7",
  "created": "2017-08-06T01:06:21.724551",
  "finished": null,
  "comments_required": false
}
```

## Samples

There is a **samples** folder with many examples

## API Docs

* [Imaginie API v3 doc](https://imaginiev3.docs.apiary.io) - Doc of our last API version
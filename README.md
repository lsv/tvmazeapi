TV Maze API &ndash; [![Build Status](https://travis-ci.org/lsv/rejseplan-php-api.svg?branch=master)](https://travis-ci.org/lsv/rejseplan-php-api) [![codecov](https://codecov.io/gh/lsv/rejseplan-php-api/branch/master/graph/badge.svg)](https://codecov.io/gh/lsv/rejseplan-php-api) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/babcfce8-7f31-45b4-999f-b78f7ab56960/mini.png)](https://insight.sensiolabs.com/projects/babcfce8-7f31-45b4-999f-b78f7ab56960) [![StyleCI](https://styleci.io/repos/67995566/shield)](https://styleci.io/repos/67995566)

=================

PHP wrapper for tvmaze.com API

### Install

`composer require lsv/tvmazeapi`

or add it to your `composer.json` file

```json
"require": {
    "lsv/tvmazeapi": "^1.0"
}
```

### Usage

```php
use Lsv\TvmazeApi\Api\Show;

// Search for a show
$results = Show::getInstance()->search($query);
// $results = Lsv\TvmazeApi\Response\ShowResponse[]

// Search for a single show
$result = Show::getInstance()->singleSearch($query, true, true);
// $result = Lsv\TvmazeApi\Response\ShowResponse
// first true = Embed episodes
// second true = Embed next episode

// Find by tvmaze ID
$result = Show::getInstance()->findById($id, true, true);
// $result = Lsv\TvmazeApi\Response\ShowResponse
// first true = Embed episodes
// second true = Embed next episode

// Find by another sites ID
// Following methods can be used: lookupFromTvrage, lookupFromThetvdb or lookupFromImdb
$result = Show::getInstance()->lookupFromImdb($id);
// $result = Lsv\TvmazeApi\Response\ShowResponse
// first true = Embed episodes
// second true = Embed next episode
```

### What and what not

| Endpoints | Covered |
| --- | --- |
| Show search | **yes** |
| Show single search | **yes** |
| Show Lookup | **yes** |
| Show main information | **yes**
| People search | no |
| Schedule | no |
| Full schedule | no
| Show episode list | **yes**
| Episode by number | no
| Episodes by date | no
| Show seasons | no
| Show cast | no
| Show crew | no
| Show AKA's | no
| Show index | no
| Person main information | no
| Person cast credits | no
| Person crew credits | no
| Show updates | no 
  

### License

The MIT License (MIT)

Copyright (c) 2016 Martin Aarhof martin.aarhof@gmail.com

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

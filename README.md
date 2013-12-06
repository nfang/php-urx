# Usage

## Instantiation

Instantiate URL/URN instance by invoking factory method with valid URI string representation.

```php
$url = Uri::create('http://www.example.com/test.html?name=john&age=28&gender=male#page1');

$urn = Uri::create('urn:isbn:0451450523');
```
## Access parts

Access URL/URN parts through a series of get methods. Returned values are URL encoded.

```php
$url = Uri::create('http://www.example.com/test.html?name=john duncan&age=28&gender=male#page1');

$url->getScheme();

$url->getQueryParams()['name']; // john+duncan
```

## Resolve relative URL

Take a relative URL, and resolve it based on the current instance.

```php
$baseUrl = Uri::create('http://www.example.com/parent/child/index.html');

$baseUrl->resolve('rela.html'); // http://www.example.com/parent/child/rela.html

$baseUrl->resolve('../main.html'); // http://www.example.com/parent/main.html

// Supports chaining
$baseUrl->resolve('../main.html')->resolve('rela.html'); // http://www.example.com/parent/rela.html
```
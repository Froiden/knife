# Knife

Knife is an extension for Laravel's Blade template engine to support some handy directives that are not included in default blade syntax.
## Supported Directives
- **@css** - Include a Javascript library CSS. For example, if you want to include font-awesome on page, you just write: *@css("font-awesome")*
- **@script** - Include a Javascript library JS. For example, if you want to load jquery on page, simply write: *@script("jquery")*

This is first version of library. More directives will be added soon.

## Installation
1. First add library using composer:

   **For Laravel >5.1:**
   
   `composer require froiden/knife:~5.1.0`

   **For Laravel 4.2 - 5.0:**
   
   `composer require froiden/knife:~4.2`

2. Add service provider to `app.php`:

    **For Laravel >5.1:**
    ```php
    Froiden\Knife\KnifeServiceProvider::class
    ```

    **For Laravel 4.2 - 5.0:**
    ```php
    'Froiden\Knife\KnifeServiceProvider'
    ```

## Some examples
```php
@css("font-awesome", "bootstrap", "jquery")
<!--

Document code

-->
@script("bootstrap", "jquery")
```

## Update Libraries List
We are adding new libraries as fast as possible. If you want to update libraries list, instead of running composer update everytime, just run:

`php artisan knife:update`

## License
The MIT License (MIT)

Copyright (c) 2015 - Froiden

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

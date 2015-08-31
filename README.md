# Knife

Knife is an extension for Laravel's Blade template engine to support some handy directives that are not included in default blade syntax.

## Supported Directives
- **@datetime**, **@date**, **@time**  - Display date-time, date and time as string respectively. 
Directives accepts all valid dates/objects that can be parsed by [Carbon's](http://carbon.nesbot.com) parse 
method. You can use **config file** for knife to define date-time format to be used.
- **@use** - Import a class from a different namespace and use it in code without always specifying full 
class path.
- **@nl2br** - Display text with new lines replaced by ```<br/>``` tag.
- **@escape** - Display text by escaping quotes and other characters. It basically used ```addslashes()``` method. 
Its very useful when outputting text in JavaScript string.
- **@breakpoint** - Add an **xdebug** breakpoint at the specified place. Helps in debugging generated views.
- **@set** - Define a new variable.


This is first version of library. More directives will be added soon.

## Installation

**Note:** Knife is only supported on **Laravel 5.1** or later.

1. First add library using composer:
   
   `composer require froiden/knife:~5.1`
   
2. Add service provider to `app.php`:

    ```php
    Froiden\Knife\KnifeServiceProvider::class
    ```

## Configuration

You can specify date-time formats to be used by in Knife's config file. To use this, export the config file as follows:

`php artisan vendor:publish`

The config file with name **knife.php** will be created in the config folder where all other configs are.

## Some examples

```php
@use('Carbon\Carbon') // Observe that we have used only Carbon below instead of \Carbon\Carbon

@datetime('now') // 28th August 2015
@date('now') // 9:37 am
@time('yesterday') // 27th August 2015, 12:00 am

@set($count, 1)
{{ $count++ }} // 1
{{ $count++ }} // 2

@set($new)
{{ $new }}
{{ Carbon::now() }} // 2015-08-28 09:37:38
```
## Suggestions

We are open to suggestions. Please send your suggestions and feedback to develop the plugin further to: 
shashank@froiden.com or create an issue here on GitHub.

## License
The MIT License (MIT)

Copyright (c) 2015 - [Froiden](http://www.froiden.com/)

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
FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

SagePHP - INI File Component
==============================

This component reads and writes ini files properly. unlike php functions the values are not automagically converted (Off to 0, etc)

Features
--------
The features you would expect to work with ini files.

It also preserves comments both line comments and after the value, so both
```
; line comment
key = value ; bla bla
```
will be preserved

Usage
-----
```
use SagePHP\Component\Parser\Ini\Ini as IniParser;

$ini = new IniParser(file_get_contents('/path/to/file'));

if ($ini->hasSection('php')) {
    echo 'php section found';
}

if ($ini->hasKey('version', 'php')) {
    echo 'php version:' . $ini-get('version', 'php');
}

$ini->set($key = 'bar', $value = 'zed', $section = 'section', $comment = 'just a test');

$ini->remove($key = 'bar', $section = 'section');

file_put_contents('/path/to/file', $ini);
```

# Carbon Extension to calculate German Holidays

### Installation

Install the library using composer:

`composer require fgits/carbon-german-holidays`

### Usage

General usage by example:

```
<?php
require_once 'vendor/autoload.php';

use Fgits\CarbonGermanHolidays\CarbonGermanHolidays;

// Now you can Use CarbonGermanHolidays like Carbon
// eg.: CarbonGermanHolidays::instance() etc.

// Create some instance
$instance1 = CarbonGermanHolidays::createFromDate(2019, 01, 01);
$instance2 = CarbonGermanHolidays::createFromDate(2018, 12, 24);

// Check if the instance is a German Holiday
echo $instance1->isGermanHoliday(); // true 
echo $instance2->isGermanHoliday(); // false

echo $instance2->isGermanHoliday(CarbonGermanHolidays::ALL_STATES_ALL_DAYS); // true, cause ALL_STATES_ALL_DAYS includes some more special days

// Get holiday names for instance
echo $instance1->getGermanHolidaysForDay(); // array('Neujahr') 
echo $instance2->getGermanHolidaysForDay(); // array() 

echo $instance2->getGermanHolidaysForDay(CarbonGermanHolidays::ALL_STATES_ALL_DAYS); // array('Heiligabend'), cause ALL_STATES_ALL_DAYS includes some more special days
```

Getting holidays for specific German states:

```
<?php
// import class etc, see above.

// Create some instance
$instance1 = CarbonGermanHolidays::createFromDate(2019, 11, 01);

// Check if the instance is a German Holiday
echo $instance1->isGermanHoliday(CarbonGermanHolidays::BRANDENBURG); // true 

// Get holiday names for instance
echo $instance1->getGermanHolidaysForDay(CarbonGermanHolidays::BRANDENBURG); // array('Reformationstag') 
```

Support for some other special days:

In Germany, eg. the 24th of December is not a public holiday. But in my opinion its a special day, you may want to check for. For this case, the class offers some additions to the German states: 

```
<?php
// import class etc, see above.

// Create some instance
$instance1 = CarbonGermanHolidays::createFromDate(2018, 03, 29); // which is "Gründonnerstag"

// Check if the instance is a German Holiday
echo $instance1->isGermanHoliday(CarbonGermanHolidays::SPECIAL_DAYS_2); // true 

// Get holiday names for instance
echo $instance1->getGermanHolidaysForDay(CarbonGermanHolidays::SPECIAL_DAYS_2); // array('Gründonnerstag') 
```

For all supported days have a look at the constants in the `CarbonGermanHolidays` class and the function `CarbonGermanHolidays::getHolidays`


### License

Licensed under MIT-License:

Copyright (c) 2018 Fabian Golle

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE

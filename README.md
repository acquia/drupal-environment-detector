Acquia Drupal Environment Detector
====

This package provides a common static class and methods for detecting the current Acquia Cloud environment.

It can report several characteristics of the current environment, including:
- Hosting provider (Acquia or non-Acquia)
- Hosting type (ACE, ACSF)
- Hosting realm (prod, devcloud, gardens, etc)
- Environment stage (dev, stage, prod)
- Environment type (IDE, ODE/CDE)
- Common site properties (name, file path)

See all available methods in [src/AcquiaDrupalEnvironmentDetector.php](src/AcquiaDrupalEnvironmentDetector.php).

## Installation and usage

In your project, require the plugin with Composer:

`composer require acquia/drupal-environment-detector`

# License

Copyright (C) 2020 Acquia, Inc.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License version 2 as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

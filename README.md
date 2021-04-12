Acquia Drupal Environment Detector
====

This package provides a static class that your application can use to **detect** various characteristics of the **current** hosting environment.

It also provides static **helper** classes that provide canonical information about **any** arbitrary environment.

## Detector class

Scans environment variables and settings files to determine several characteristics of the current hosting environment, including:
- Hosting provider (Acquia or non-Acquia)
- Hosting type (ACE, ACSF)
- Hosting realm (prod, devcloud, gardens, etc)
- Environment stage (dev, stage, prod)
- Environment type (IDE, ODE/CDE)
- Common site properties (name, file path)

See all available methods in [src/AcquiaDrupalEnvironmentDetector.php](src/AcquiaDrupalEnvironmentDetector.php).

## Helper classes

The additional static classes allow you to predict the characteristics of any Acquia hosting environment given the site group and environment name, including:
- A mapping of Acquia environment names (e.g. `01test`, `stg`, `live`) to human-readable standard names (`dev`, `stage`, `prod`)
- A set of standard filesystem paths for things like the private files directory or `sites.json` file on ACSF.

## Installation and usage

In your project, require the plugin with Composer:

`composer require acquia/drupal-environment-detector`

# License

Copyright (C) 2020 Acquia, Inc.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License version 2 as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

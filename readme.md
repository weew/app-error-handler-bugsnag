# Bugsnag error handler

[![Build Status](https://img.shields.io/travis/weew/php-app-error-handler-bugsnag.svg)](https://travis-ci.org/weew/php-app-error-handler-bugsnag)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/php-app-error-handler-bugsnag.svg)](https://scrutinizer-ci.com/g/weew/php-app-error-handler-bugsnag)
[![Test Coverage](https://img.shields.io/coveralls/weew/php-app-error-handler-bugsnag.svg)](https://coveralls.io/github/weew/php-app-error-handler-bugsnag)
[![Version](https://img.shields.io/packagist/v/weew/php-app-error-handler-bugsnag.svg)](https://packagist.org/packages/weew/php-app-error-handler-bugsnag)
[![Licence](https://img.shields.io/packagist/l/weew/php-app-error-handler-bugsnag.svg)](https://packagist.org/packages/weew/php-app-error-handler-bugsnag)

## Table of contents

- [Installation](#installation)
- [Introduction](#introduction)
- [Usage](#usage)
- [Example config](#example-config)

## Installation

`composer require weew/php-app-error-handler-bugsnag`

## Introduction

This package integrates [Bugsnag](https://bugsnag.com) with the [weew/php-app-error-handler](https://github.com/weew/php-app-error-handler) package.

## Usage

To enable this provider simply register it on the kernel.

```php
$app->getKernel()->addProviders([
    BugsnagProvider::class,
]);
```

## Example config

This is how the config might look like in yaml:

```yaml
env: "dev"
bugsnag:
    client_id: "client_id"
    enabled_environments: ["dev", "stage", "prod"]
    type: "service"
    metadata:
        some: data
    auto_notify: true
    filters: ["password", "credit_card"]
    send_code: true
    project_root: "path/to/root/directory"
    hostname: "hostname"
```

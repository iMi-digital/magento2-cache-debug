# IMI_CacheDebug

This module lets you enable full page cache debug headers in production mode.

## Prerequesites

This module requires PHP 8.1 and at least Magento 2.4.4.

## Installation

### Via Composer (recommended)

1. Require the package:
```bash
composer require imi/magento2-cache-debug
```
2. Enable the module:
```bash
bin/magento module:enable IMI_CacheDebug
bin/magento setup:upgrade
```
3. Enable it the configuration:
   1. Via CLI:
   ```bash
   bin/magento config:set system/full_page_cache/production_logging_enabled 1 
   ```
   2. Or in the adminpanel under *Stores > Settings > Configuration > Advanced > System > Full Page Cache > Enable Logging in Production*
4. Flush config cache:
```bash
bin/magento cache:flush config
```

### Manual Download

Download this repository and extract it under *app/code/IMI/CacheDebug*, then follow steps 2.- 4. of the installation via composer.
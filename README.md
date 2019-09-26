# Research Data Services

Listing research data services provided by the University of Helsinki with Drupal 8.

## Environments

Env | Branch | Drush alias | URL
--- | ------ | ----------- | ---
development | * | - | https://datasupport.docker.sh/
testing | dev | @testing | https://datasupport-test.it.helsinki.fi/
production | master | @production | https://datasupport.helsinki.fi/

## Requirements

You need to have these applications installed to operate on all environments:

- [Docker](https://github.com/druidfi/guidelines/blob/master/docs/docker.md)
- [Stonehenge](https://github.com/druidfi/stonehenge)
- For the new person: Your SSH public key needs to be added to servers

## Create and start the environment

Start up the environment with:

```
$ make fresh
```

Ready! Now go to https://datasupport.docker.sh/ to see your site.

## Login to Drupal container

This will log you inside the Drupal Docker container and in the `public` folder:

```
$ make shell
```

COMPOSER_MEMORY_LIMIT=-1 composer req webflo/drupal-core-require-dev:^8.7.6 --ignore-platform-reqs

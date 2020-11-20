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
- Tunnelblick VPN connection with valid HY user account

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

## Deploying

Deploy to testing:

```
$ make deploy USERNAME=your_username
```

Deploy to production:

```
$ make deploy ENV=production USERNAME=your_username
```

## SSO in testing

For testing order form, there is test IdP setup with following credentials:

```
teppotutkija:tutkija
```

## Provisioning servers

See instructions [here](ansible/readme.md)

## Servers

You can access server(s) with:

```
$ make shell-test|shell-prod
```

### Sudo in servers

Some operations on the server need root, you can login as root with:

```
$ sudo su - root
```

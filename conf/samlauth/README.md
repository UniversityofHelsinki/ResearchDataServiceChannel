# Certs for development & testing IdP

Created with

```
$ openssl req -new -x509 -nodes -newkey rsa:4096 -keyout sp.key -days 3650 -subj '/CN=datasupport-test.it.helsinki.fi.helsinki.fi' -out sp.crt
```

Added to SP in https://sp-registry.it.helsinki.fi/summary/926/

## Uri Parser Api (UPA) 

### Instalation

```
git clone git@github.com:nexGN/uri-parser-rest-api.git
cd uri-parser-rest-api
composer install
```

### How to run

```
php -S localhost:8082 web/index.php
```

### How to use

```
curl \
    -H "Content-Type: application/json" \
    -X POST -d '{"uri_string":"ldap://ldap.example.com:636/cn=Jan%20Kowalski,dc=example,dc=com?cn,mail,telephoneNumber"}' \
    http://localhost:8082/uris
```

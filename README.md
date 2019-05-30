# autconfig

Creates autoconfig for automatic configuration of thunderbird.

## Requirements
Needs a running webserver serving the `/var/www/autoconfig/autoconfig.php` script for all requests.
Also a running php-fpm setup.

## Role Variables

| Name                         | Required/Default   | Description                               |
|------------------------------|:------------------:|-------------------------------------------|
| `autoconfig_server`          | :heavy_check_mark: | Ldap URI for the ldap server.             |
| `autoconfig_user_dn`         | :heavy_check_mark: | User DN for the binding user.             |
| `autoconfig_password`        | :heavy_check_mark: | Password for binding dn user.             |
| `autoconfig_tree`            | :heavy_check_mark: | Base DN for binding.                      |
| `autoconfig_domain`          | :heavy_check_mark: | The domain for autoconfig                 |
| `autoconfig_name`            | :heavy_check_mark: | Name of the configuration                 |
| `autoconfig_short_name`      | :heavy_check_mark: | Short name of the configuration           |
| `autoconfig_incoming_server` | `[]`               | List of [list of dicts](#incoming-server) |
| `autoconfig_outgoing_server` | `[]`               | List of [list of dicts](#outgoing-server) |
| `autoconfig_documentation`   | `[]`               | List of [list of dicts](#documentation)   |

### incoming-server

| Name             | Required/Default   | Description                                                                    |
|------------------|:------------------:|--------------------------------------------------------------------------------|
| `hostname`       | :heavy_check_mark: | Hostname for the imap server.                                                  |
| `port`           | :heavy_check_mark: | Port for the imap server.                                                      |
| `socketType`     | :heavy_check_mark: | SocketType for the imap server (`STARTTLS`, `SSL` ...)                         |
| `authentication` | :heavy_check_mark: | Authentication for imap server (`password-encrypted, password-cleartext` ...). |

### outgoing-server

| Name             | Required/Default   | Description                                                                    |
|------------------|:------------------:|--------------------------------------------------------------------------------|
| `hostname`       | :heavy_check_mark: | Hostname for the smtp server.                                                  |
| `port`           | :heavy_check_mark: | Port for the smtp server.                                                      |
| `socketType`     | :heavy_check_mark: | SocketType for the smtp server (`STARTTLS`, `SSL` ...)                         |
| `authentication` | :heavy_check_mark: | Authentication for smtp server (`password-encrypted, password-cleartext` ...). |

### documentation

| Name  | Required/Default   | Description                  |
|-------|:------------------:|------------------------------|
| `url` | :heavy_check_mark: | URL for the documentation    |
| `de`  | :heavy_check_mark: | German documentation string  |
| `en`  | :heavy_check_mark: | English documentation string |

## Example

```yml
autoconfig_server: 'ldaps://ldap.examle.de/';
autoconfig_user_dn: uid=myuser,ou=people,dc=example,dc=de"
autoconfig_password: "mypassword"
autoconfig_tree: dc=base,dc=de
php_fpm_pools:
  - name: autoconfig
    listen: /run/php/php-fpm-autoconfig.sock
    user: www-data
    group: www-data
    listen_owner: www-data
    pm: static
    pm_max_children: 20
    error_log: syslog
served_domains:
  - domains:
    - autoconfig.stuvus.uni-stuttgart.de.
    privkey_path: /etc/ssl/autoconfig_privkey.pem
    fullchain_path: /etc/ssl/autoconfig_fullchain.pem
    default_server: false
    allowed_ip_ranges:
      - 129.69.139.0/25
    https: true
    crypto: true
    root: /var/www/autoconfig
    locations:
      - condition: /
        content: |
          include fastcgi_params;
          fastcgi_param SCRIPT_FILENAME $document_root/autoconfig.php;
          fastcgi_intercept_errors on;
          fastcgi_pass unix:/run/php/php-fpm-autoconfig.sock;
    index_files:
      - autoconfig.php
```

## License

This work is licensed under a [Creative Commons Attribution-ShareAlike 4.0 International License](https://creativecommons.org/licenses/by-sa/4.0/).

## Author Information

- [Fritz Otlinghaus (Scriptkiddi)](https://github.com/Scriptkiddi) _fritz.otlinghaus@stuvus.uni-stuttgart.de_

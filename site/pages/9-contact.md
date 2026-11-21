---
title: Contact
cached: false
---

# Contact

Use the form below to send a message. It is protected by a CSRF token and an ALTCHA
captcha; submissions are sent by email to the address configured in
`site/config/main.php`.

The contact values live in `site/config/main.php`, which is generated from
`site/config/main.dist.php`. On deployment the CI workflow fills in the recipient,
SMTP credentials and fresh CSRF/captcha secrets from repository secrets.

{{ contact() }}

Questions about Herbie Website Starter itself? Browse {{ link_page('features', 'the feature list') }}
or {{ link_page('getting-started', 'the getting-started guide') }} first.

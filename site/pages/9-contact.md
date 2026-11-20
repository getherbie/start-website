---
title: Contact
cached: false
---

# Contact

Use the form below to send a message. It is protected by a CSRF token and an ALTCHA
captcha; submissions are sent by email to the address configured in
`site/config/main.php`.

For local development the recipient is `blackhole@example.com` and the secrets are
placeholders. Set `HERBIE_CONTACT_RECIPIENT`, `HERBIE_CONTACT_CSRF_SECRET` and
`HERBIE_CONTACT_CAPTCHA_SECRET` before deploying.

{{ contact() }}

Questions about the kickstarter itself? Browse {{ link_page('features', 'the feature list') }}
or {{ link_page('getting-started', 'the getting-started guide') }} first.

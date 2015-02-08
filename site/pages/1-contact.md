---
title: Contact
noCache: 1
simplecontact:
    subject: "Contact your request Herbie site!"
    recipient: "blackhole@example.com"
    fields:
      name:
        label: "Your Name"
        placeholder:
      email:
        label: "Your E-Mail"
        placeholder:
      message:
        label: "Your Message"
        placeholder:
      antispam:
        label: "Antispam"
        placeholder:
      submit:
        label: "Submit Form"
    messages:
      success: "Many Thanks! Your message has been sent."
      error: "Oops! There's a problem. Please complete the form below and try it again."
      fail: "Oops! Something has gone wrong. The message could not be delivered."
    errors:
      emptyField: "This is a required field"
      invalidEmail: "The entered email is not valid"
---

#Contact

{{ simplecontact() }}


--- sidebar ---

### Street Address

Hans Muster  
Musterstrasse 43  
3020 Mustern

<mail@hansmuster.com>  
<http://www.hansmuster.com>  

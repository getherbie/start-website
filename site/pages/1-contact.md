---
title: Contact
nocache: 1
simplecontact:
    subject: "Contact form"
    recipient: "blackhole@example.com"
    fields:
      name:
        label: "Your name"
        placeholder:
      email:
        label: "Your email"
        placeholder:
      message:
        label: "Your message"
        placeholder:
      antispam:
        label: "Antispam"
        placeholder:
      submit:
        label: "Send form"
    messages:
      success: "Thank you! Your message was sent."
      error: "Uups! There was a problem. Please complete form and try again."
      fail: "Uups! There was a problem. The email couln't be sent."
    errors:
      empty_field: "This is a required field"
      invalid_email: "The given email is invalid"
---

<h1>Contact</h1>

{{ simplecontact() }}

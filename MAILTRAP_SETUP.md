# Mailtrap Setup Guide

## Step 1: Get Mailtrap Credentials

1. Go to [Mailtrap.io](https://mailtrap.io)
2. Sign up or log in to your account
3. Create a new inbox or use an existing one
4. Go to the inbox settings
5. Click on "SMTP Settings"
6. Select "Laravel" from the integrations dropdown

## Step 2: Configure .env File

Add the following configuration to your `.env` file:

```env
# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username_here
MAIL_PASSWORD=your_mailtrap_password_here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourpharmacy.com
MAIL_FROM_NAME="Your Pharmacy Name"
```

Replace `your_mailtrap_username_here` and `your_mailtrap_password_here` with the actual credentials from your Mailtrap inbox.

## Step 3: Test the Configuration

Run the following command to test your email configuration:

```bash
php artisan test:email your-email@example.com
```

This will send a test OTP email to verify that everything is working correctly.

## Step 4: Check Mailtrap Inbox

After running the test command, check your Mailtrap inbox to see if the email was received. You should see:
- The email with the subject "Password Reset OTP"
- A 6-digit OTP code
- A nicely formatted HTML email

## Troubleshooting

### Common Issues:

1. **"Failed to send email" error:**
   - Check your Mailtrap credentials
   - Ensure the port is correct (2525 for TLS)
   - Verify the encryption is set to "tls"

2. **"Connection timeout" error:**
   - Check your internet connection
   - Verify the Mailtrap host is correct (smtp.mailtrap.io)

3. **"Authentication failed" error:**
   - Double-check your username and password
   - Make sure you're using the correct inbox credentials

### Verification Commands:

```bash
# Clear config cache
php artisan config:clear

# Cache config
php artisan config:cache

# Test email again
php artisan test:email your-email@example.com
```

## Production Setup

When moving to production, replace Mailtrap with your actual email service provider:

- **Gmail SMTP:**
  ```env
  MAIL_HOST=smtp.gmail.com
  MAIL_PORT=587
  MAIL_USERNAME=your-email@gmail.com
  MAIL_PASSWORD=your-app-password
  ```

- **SendGrid:**
  ```env
  MAIL_HOST=smtp.sendgrid.net
  MAIL_PORT=587
  MAIL_USERNAME=apikey
  MAIL_PASSWORD=your-sendgrid-api-key
  ```

- **Amazon SES:**
  ```env
  MAIL_HOST=email-smtp.us-east-1.amazonaws.com
  MAIL_PORT=587
  MAIL_USERNAME=your-ses-username
  MAIL_PASSWORD=your-ses-password
  ```

Remember to update the `MAIL_FROM_ADDRESS` and `MAIL_FROM_NAME` to match your production domain and business name. 
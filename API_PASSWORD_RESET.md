# Password Reset API Documentation

This document describes the password reset functionality using OTP (One-Time Password) sent via email.

## Configuration

### Mailtrap Setup
Add the following to your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourpharmacy.com
MAIL_FROM_NAME="Your Pharmacy"
```

## API Endpoints

### 1. Send Password Reset OTP

**Endpoint:** `POST /api/password/send-otp`

**Description:** Sends a 6-digit OTP to the user's email address for password reset.

**Request Body:**
```json
{
    "email": "user@example.com"
}
```

**Response (Success - 200):**
```json
{
    "message": "Password reset OTP sent successfully",
    "email": "user@example.com"
}
```

**Response (Error - 404):**
```json
{
    "message": "User not found"
}
```

**Response (Error - 500):**
```json
{
    "message": "Failed to send OTP. Please try again later."
}
```

### 2. Verify OTP

**Endpoint:** `POST /api/password/verify-otp`

**Description:** Verifies the OTP without resetting the password.

**Request Body:**
```json
{
    "email": "user@example.com",
    "otp": "123456"
}
```

**Response (Success - 200):**
```json
{
    "message": "OTP verified successfully"
}
```

**Response (Error - 400):**
```json
{
    "message": "Invalid OTP"
}
```

or

```json
{
    "message": "OTP has expired"
}
```

### 3. Reset Password

**Endpoint:** `POST /api/password/reset`

**Description:** Resets the user's password using the verified OTP.

**Request Body:**
```json
{
    "email": "user@example.com",
    "otp": "123456",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Response (Success - 200):**
```json
{
    "message": "Password reset successfully"
}
```

**Response (Error - 400):**
```json
{
    "message": "Invalid OTP"
}
```

or

```json
{
    "message": "OTP has expired"
}
```

## OTP Features

- **6-digit numeric OTP**
- **10-minute expiration time**
- **Single-use only** (marked as used after password reset)
- **Automatic cleanup** of expired/unused OTPs

## Security Features

- OTPs are automatically deleted when a new one is generated for the same email
- All user tokens are revoked after password reset (force logout from all devices)
- OTPs expire after 10 minutes
- OTPs can only be used once

## Testing

### Test Email Functionality

Use the artisan command to test email sending:

```bash
php artisan test:email user@example.com
```

This will send a test OTP email to verify your Mailtrap configuration.

### API Testing

You can test the endpoints using tools like Postman or curl:

1. **Send OTP:**
```bash
curl -X POST http://your-domain/api/password/send-otp \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com"}'
```

2. **Verify OTP:**
```bash
curl -X POST http://your-domain/api/password/verify-otp \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com", "otp": "123456"}'
```

3. **Reset Password:**
```bash
curl -X POST http://your-domain/api/password/reset \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com", "otp": "123456", "password": "newpassword123", "password_confirmation": "newpassword123"}'
```

## Error Handling

The API includes comprehensive error handling for:
- Invalid email addresses
- Non-existent users
- Invalid or expired OTPs
- Email sending failures
- Password validation errors

## Notes

- Make sure to configure your Mailtrap credentials in the `.env` file
- The email template is located at `resources/views/emails/password-reset-otp.blade.php`
- OTPs are stored in the `password_reset_otps` table
- All password reset operations are logged for security purposes 
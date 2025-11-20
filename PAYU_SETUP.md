# PayU Payment Gateway Setup Guide

This website includes a complete PayU payment integration. Follow these steps to enable live payments:

## Step 1: Get PayU Merchant Account

1. Visit [PayU India](https://payu.in) or your regional PayU website
2. Sign up for a merchant account
3. Complete the KYC verification process
4. Once approved, access your PayU dashboard

## Step 2: Get Your Credentials

From your PayU dashboard, obtain:
- **Merchant Key** (also called API Key)
- **Salt Key** (used for hash generation)

## Step 3: Configure Environment Variables

Add these secrets to your Replit project:

```
PAYU_MERCHANT_KEY=your_actual_merchant_key_here
PAYU_SALT=your_actual_salt_key_here
PAYU_MODE=test   # Use 'live' for production
```

To add secrets in Replit:
1. Go to the Tools panel
2. Click on "Secrets"
3. Add each environment variable with its value

## Step 4: Testing

### Test Mode
- When `PAYU_MODE=test`, payments will use PayU's test environment
- Use PayU's test card details for testing
- No real money is charged

### Test Cards (PayU Test Environment)
- **Success:** Card: 5123456789012346, CVV: 123, Expiry: Any future date
- **Failure:** Card: 4012001037141112, CVV: 123, Expiry: Any future date

## Step 5: Go Live

1. Set `PAYU_MODE=live` in your environment variables
2. Verify your PayU account is fully approved for live transactions
3. Test with a small real transaction
4. Monitor the success/failure callbacks

## How It Works

1. **Server-Side Price Validation**: Prices are enforced server-side (in `includes/config.php`) to prevent tampering
2. **Hash Generation**: Payment requests include a SHA-512 hash for security
3. **Hash Verification**: Success/failure callbacks verify PayU's response hash
4. **Secure Callbacks**: Only verified PayU responses are accepted

## Security Features

✓ Server-side price validation (prevents client-side tampering)
✓ SHA-512 hash signing for all payment requests
✓ Hash verification on payment callbacks
✓ XSS protection with htmlspecialchars()
✓ SQL injection protection with prepared statements

## File Structure

- `includes/config.php` - Payment configuration and hash functions
- `payment/process.php` - Generates payment request and hash
- `payment/success.php` - Handles successful payments (verifies hash)
- `payment/failure.php` - Handles failed/cancelled payments

## Demo Mode

Without PayU credentials, the system runs in demo mode:
- Shows a "Simulate Payment" button
- Demonstrates the payment flow
- Doesn't charge real money
- Perfect for testing the UI/UX

## Support

For PayU-specific issues:
- PayU Documentation: https://docs.payu.in/
- PayU Support: Contact through your merchant dashboard

For website integration issues:
- Check the browser console for errors
- Verify environment variables are set correctly
- Ensure callback URLs are accessible

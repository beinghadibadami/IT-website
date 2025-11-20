# TechVista - IT Company Website

## Overview
A professional IT company website built with core PHP, HTML, CSS, and JavaScript. Features stunning UI with modern gradients, animations, and PayU payment integration.

## Project Structure
- `index.php` - Main entry point with routing
- `pages/` - Individual page content (home, services, about, contact)
- `includes/` - Reusable components (header, footer, database connection)
- `assets/css/` - Custom CSS with modern design
- `assets/js/` - JavaScript for interactivity and animations
- `payment/` - PayU payment integration files

## Features
- Landing page with animated hero section
- Services page with PayU payment integration
- About page with company info and team
- Contact form with PostgreSQL database storage
- Fully responsive design
- Custom animations and micro-interactions

## Database
Uses PostgreSQL with a `contacts` table to store form submissions:
- id (serial primary key)
- name, email, phone, message
- created_at timestamp

## PayU Integration
Complete production-ready PayU integration with:
- Server-side price validation (prevents tampering)
- SHA-512 hash generation and verification
- Support for additionalCharges field
- Hash verification on both success and failure callbacks
- Environment variable configuration
- Demo mode when credentials not set

To enable live payments:
1. Sign up at payu.in for merchant account
2. Add environment variables:
   - PAYU_MERCHANT_KEY
   - PAYU_SALT
   - PAYU_MODE (test or live)
3. See PAYU_SETUP.md for complete instructions

## Recent Changes (2024-11-19)
- Initial project setup
- Created all pages and components
- Implemented stunning UI with gradients and animations
- Set up PayU payment flow
- Configured contact form with database storage

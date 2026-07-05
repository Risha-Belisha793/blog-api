# Blog API Documentation

## Authentication Endpoints

### Register User
**POST** `/api/register`

**Request Body:**
```json
{
    "name": "string (required)",
    "email": "string (required, email)",
    "password": "string (required, min: 6)",
    "password_confirmation": "string (required)"
}
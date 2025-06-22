# Category API Endpoints

This document describes the API endpoints for managing categories in the pharmacy management system.

## Authentication

All endpoints require authentication using Laravel Sanctum. Include the Bearer token in the Authorization header:

```
Authorization: Bearer {your_token}
```

## Endpoints

### 1. Get All Categories

**GET** `/api/categories`

Returns all active categories with their medication counts.

**Response:**
```json
{
  "categories": [
    {
      "id": 1,
      "name": "Antibiotics",
      "svg_logo": "antibiotics.svg",
      "svg_logo_url": "http://example.com/storage/categories/antibiotics.svg",
      "is_active": true,
      "medications_count": 15,
      "created_at": "2025-01-01T00:00:00.000000Z",
      "updated_at": "2025-01-01T00:00:00.000000Z"
    }
  ]
}
```

### 2. Get Category Details

**GET** `/api/categories/{category_id}`

Returns detailed information about a specific category including its medications.

**Response:**
```json
{
  "category": {
    "id": 1,
    "name": "Antibiotics",
    "svg_logo": "antibiotics.svg",
    "svg_logo_url": "http://example.com/storage/categories/antibiotics.svg",
    "is_active": true,
    "medications_count": 15,
    "medications": [
      {
        "id": 1,
        "name": "Amoxicillin",
        "generic_name": "Amoxicillin",
        "price": 10.50,
        "quantity": 100,
        "pharmacy_id": 1,
        "category_id": 1
      }
    ],
    "created_at": "2025-01-01T00:00:00.000000Z",
    "updated_at": "2025-01-01T00:00:00.000000Z"
  }
}
```

### 3. Get Categories for Specific Pharmacy

**GET** `/api/categories/pharmacy/{pharmacy_id}`

Returns categories with medication counts specific to a pharmacy (only medications with quantity > 0).

**Response:**
```json
{
  "categories": [
    {
      "id": 1,
      "name": "Antibiotics",
      "svg_logo": "antibiotics.svg",
      "svg_logo_url": "http://example.com/storage/categories/antibiotics.svg",
      "is_active": true,
      "medications_count": 5,
      "created_at": "2025-01-01T00:00:00.000000Z",
      "updated_at": "2025-01-01T00:00:00.000000Z"
    }
  ]
}
```

## Notes

- Categories are system-wide and predefined, not user-created
- Only active categories are returned
- Medication counts only include medications with quantity > 0
- SVG logos are stored in `/storage/app/categories/` directory
- Categories are ordered alphabetically by name

## Error Responses

### 404 Not Found
```json
{
  "message": "Category not found"
}
```

### 401 Unauthorized
```json
{
  "message": "Unauthenticated"
}
``` 
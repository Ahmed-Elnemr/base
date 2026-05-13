# 📋 API Endpoints Summary - Nine Application

## 🔐 Authentication Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/api/v1/auth/register` | Register new user | ❌ |
| POST | `/api/v1/auth/login` | Login user | ❌ |
| GET | `/api/v1/auth/me` | Get current user profile | ✅ |
| POST | `/api/v1/auth/profile/update` | Update user profile | ✅ |
| POST | `/api/v1/auth/logout` | Logout user | ✅ |

---

## 🔔 Notifications Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/v1/notifications` | Get all notifications (marks as read) | ✅ |
| GET | `/api/v1/notifications/unread` | Get unread notifications only | ✅ |
| GET | `/api/v1/notifications/unread-count` | Get count of unread notifications | ✅ |
| DELETE | `/api/v1/notifications/{uuid}` | Delete specific notification | ✅ |
| DELETE | `/api/v1/notifications` | Delete all notifications | ✅ |

### Notifications Response Example:
```json
{
  "success": true,
  "message": "Notifications loaded successfully.",
  "data": {
    "notifications": {
      "data": [
        {
          "id": "uuid-here",
          "title": "عنوان الإشعار",
          "message": "محتوى الإشعار",
          "type": "new_user",
          "model_id": 123,
          "read_at": null,
          "created_at": "2026-02-07T23:00:00.000000Z"
        }
      ],
      "current_page": 1,
      "per_page": 10,
      "total": 25
    }
  }
}
```

---

## ⚙️ Settings Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/v1/all-settings` | Get all settings | ❌ |
| GET | `/api/v1/settings/{key}` | Get specific setting by key | ❌ |

### Available Setting Keys:
- `logo_ar` - Arabic Logo (Image URL)
- `logo_en` - English Logo (Image URL)
- `privacy_policy` - Privacy Policy (Rich Text, Translated)
- `terms_conditions` - Terms & Conditions (Rich Text, Translated)
- `social_facebook` - Facebook Link (URL)
- `social_twitter` - Twitter/X Link (URL)
- `social_instagram` - Instagram Link (URL)
- `social_snapchat` - Snapchat Link (URL)
- `social_tiktok` - TikTok Link (URL)

### Settings Response Example:
```json
{
  "success": true,
  "message": "Settings loaded successfully",
  "data": [
    {
      "id": 1,
      "key": "logo_ar",
      "type": "IMAGE",
      "value": "http://domain.com/storage/logo.png"
    },
    {
      "id": 3,
      "key": "privacy_policy",
      "type": "RICH_TEXT",
      "value": "سياسة الخصوصية بالعربي..."
    },
    {
      "id": 5,
      "key": "social_facebook",
      "type": "URL",
      "value": "https://facebook.com/yourpage"
    }
  ]
}
```

---

## 📝 Important Notes

### Language Support
All endpoints support language switching via the `Accept-Language` header:
- `Accept-Language: ar` - Arabic
- `Accept-Language: en` - English

### Authentication
Protected endpoints require Bearer token:
```
Authorization: Bearer {your-token-here}
```

### Pagination
List endpoints (notifications) support pagination:
- Default: 10 items per page
- Query params: `?page=2`

---

## 📦 Postman Collection

Import the Postman collection from:
```
postman/Nine_API.postman_collection.json
```

### Environment Variables:
- `base_url`: Your API base URL (e.g., `http://localhost:8000`)
- `token`: Your authentication token (auto-filled after login)

---

## 🎯 Quick Start

1. **Register/Login** to get authentication token
2. **Get Settings** to load app configuration
3. **Get Notifications** to show user notifications
4. **Get Unread Count** to display notification badge

---

**Last Updated:** 2026-02-07  
**API Version:** v1

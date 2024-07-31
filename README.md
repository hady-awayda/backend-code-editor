# API Documentation

## Authentication Routes

### Register User

-   **URL**: `/api/auth/register`
-   **Method**: `POST`
-   **Request Body**:

```json
{
    "name": "string (required, max: 255)",
    "email": "string (required, email, max: 255, unique)",
    "password": "string (required, min: 6)"
}
```

### Login User

-   **URL**: `/api/auth/login`
-   **Method**: `POST`
-   **Request Body**:

```json
{
    "email": "string (required, email)",
    "password": "string (required)"
}
```

### Logout User

-   **URL**: `/api/auth/logout`
-   **Method**: `POST`

### Refresh Token

-   **URL**: `/api/auth/refresh`
-   **Method**: `POST`

## User Routes

### Get User by ID

-   **URL**: `/api/users/{id}`
-   **Method**: `GET`

### Update User

-   **URL**: `/api/users/{id}`
-   **Method**: `PUT`
-   **Request Body**:

```json
{
    "name": "string (optional, max: 255)",
    "email": "string (optional, email, max: 255, unique)",
    "password": "string (optional, min: 6)"
}
```

### Delete User

-   **URL**: `/api/users/{id}`
-   **Method**: `DELETE`

## Source Code Routes

### Get Source Codes by User ID

-   **URL**: `/api/source_codes/{user_id}`
-   **Method**: `GET`

### Create Source Code

-   **URL**: `/api/source_codes`
-   **Method**: `POST`
-   **Request Body**:

```json
{
    "user_id": "int (required, exists:users,id)",
    "title": "string (required, max: 255)",
    "code": "string (required)"
}
```

### Update Source Code

-   **URL**: `/api/source_codes/{id}`
-   **Method**: `PUT`
-   **Request Body**:

```json
{
    "user_id": "int (required, exists:users,id)",
    "code": "string (required)"
}
```

### Delete Source Code

-   **URL**: `/api/source_codes/{id}`
-   **Method**: `DELETE`

## Message Routes

### Get Messages Between Users

-   **URL**: `/api/messages/{user_id_1}/{user_id_2}`
-   **Method**: `GET`

### Add Message to Conversation

-   **URL**: `/api/messages`
-   **Method**: `POST`
-   **Request Body**:

```json
{
    "sender_id": "int (required, exists:users,id)",
    "receiver_id": "int (required, exists:users,id)",
    "message": "string (required)"
}
```

## Conversation Routes

### Get User Conversations

-   **URL**: `/api/conversations/{user_id}`
-   **Method**: `GET`

## Search Routes

### Search Users by Username

-   **URL**: `/api/search/users/{username}`
-   **Method**: `GET`

## Admin Routes

### Get All Users

-   **URL**: `/api/admin`
-   **Method**: `GET`

### Import Users

-   **URL**: `/api/admin/import`
-   **Method**: `POST`
-   **Request**: Multipart/form-data with a file input

# Nyuci Dimana API
# API Documentation
## Authentication & Authorization
### Login
#### POST `/api/auth/login`
#### Request Body
| Name     | Data type |
|----------|-----------|
| email    | string    |
| password | string    |
---
### Register
#### POST `/api/auth/register`
#### Request Body
| Name     | Data type |
|----------|-----------|
| name     | string    |
| email    | string    |
| password | string    |
| role     | integer   |
---
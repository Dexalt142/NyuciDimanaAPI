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
### Me
#### GET `/api/auth/me`
#### Authorization
```
    Bearer token 
```
---
### Logout
#### POST `/api/auth/logout`
#### Authorization
```
    Bearer token
```

## Laundromat
### Get All Laundromats
#### GET `/api/laundromat`
#### Authorization
```
    Bearer token
```
---
### Get User's Laundromat
#### GET `/api/laundromat/my`
#### Authorization
```
    Bearer token
```
---
### Get Laundromat by ID
#### GET `/api/laundromat/{id}`
#### Request Parameter
| Name     | Data type |
|----------|-----------|
| id       | integer   |
#### Authorization
```
    Bearer token 
```
---
### Create Laundromat
#### POST `/api/laundromat/create`
#### Request Body
| Name      | Data type |
|-----------|-----------|
| name      | string    |
| address   | string    |
| latitude  | float     |
| longitude | float     |
#### Authorization
```
    Bearer token
```

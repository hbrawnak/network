# network

### Installation Process

`composer install`

`cp .env.example .env`

update the credentials of database and redis.

RUN 

`php artisan key:generate`

`php artisan jwt:secret`

`php artisan migrate`

And RUN  
`php artisan serve`

On the other tab of your terminal run   
`php artisan queue:listen`  

Application should run `http://127.0.0.1:8000`

Published API URL:

Registration: `POST` `/api/auth/register`   
`BODY` 
```
{
  "first_name": "Habibur",
  "last_name": "Rahman",
  "email": "habib@gmail.com",
  "password": "1234567",
  "password_confirmation": "1234567"
}
```

Registration: `POST` `/api/auth/login`  
`BODY`
```
{
  "email": "habib@gmail.com",
  "password": "1234567"
}
```

Logout: `GET` `/api/auth/logout`  
`Header`
```
Authorization: Bearer {token}
```

Create Page: `POST` `api/page/create`   
`Header`
```
Authorization: Bearer {token}
```
`Body`
```
{
  "name": "Page Name"
}
```

Follow Person: `GET` `/api/follow/person/{personId}`  
`Header`
```
Authorization: Bearer {token}
```


Follow Page: `GET` `/api/follow/page/{pageId}`  
`Header`
```
Authorization: Bearer {token}
```

Person Attach Post: `POST` `/api/person/attach-post`  
`Header`
```
Authorization: Bearer {token}
```
`Body`
```
{
   "text": "Person Post"
}
```


Page Attach Post: `POST` `/api/page/{pageId}/attach-post`  
`Header`
```
Authorization: Bearer {token}
```
`Body`
```
{
   "text": "Page Post"
}
```


Person Feed: `POST` `/api/person/feed?limit=10&page=1`  
`Header`
```
Authorization: Bearer {token}
```

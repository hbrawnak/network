# network

### Overview
I have tried to get a better output in this short time. I have used redis and queue mechanism to make the system better. I think it's not the best still. There are a lot of rooms to improve. Feed query can be optimized and more test for other cases.

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

### Published API URL:

1: Registration: `POST` `/api/auth/register`   
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


2: Login: `POST` `/api/auth/login`  
`BODY`
```
{
  "email": "habib@gmail.com",
  "password": "1234567"
}
```


3: Logout: `GET` `/api/auth/logout`  
`Header`
```
Authorization: Bearer {token}
```


4: Create Page: `POST` `api/page/create`   
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


5: Follow Person: `GET` `/api/follow/person/{personId}`  
`Header`
```
Authorization: Bearer {token}
```


6: Follow Page: `GET` `/api/follow/page/{pageId}`  
`Header`
```
Authorization: Bearer {token}
```


7: Person Attach Post: `POST` `/api/person/attach-post`  
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


8: Page Attach Post: `POST` `/api/page/{pageId}/attach-post`  
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


9: Person Feed: `POST` `/api/person/feed?limit=10&page=1`  
`Header`
```
Authorization: Bearer {token}
```


### Test
`php artisan db:seed`   

`php artisan test`

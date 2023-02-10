
# CineHall Api

These are the api used in CineHall application, they're created with php with a jwt authentication and a good routing using an mvc architecture

## API Reference

#### Admin Login

```http
  POST /CineHall/authenticate
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `string` | **Required**. Your API key |
| `password` | `string` | **Required**. Your API key |

#### User Login

```http
  POST /CineHall/authenticate
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Key` | `string` | **Required**. Your API key |


#### Add Hall

```http
  POST /CineHall/halls/createHalls
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `id`      | `Integer` | **Required**. Id of Hall |
| `name`      | `string` | **Required**. Name of hall |
| `capacity`      | `Integer` | **Required**. capacity of hall |

#### Get All halls

```http
  GET /CineHall/halls
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of hall |
| `name`      | `string` | **Required**. Name of hall |
| `capacity`      | `integer` | **Required**. capacity of hall |

#### Update hall

```http
  PUT /CineHall/halls/updateHall
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of hall |
| `name`      | `string` | **Required**. Name of hall |
| `capacity`      | `integer` | **Required**. capacity of hall |

#### Delete hall

```http
  DELETE /CineHall/halls/deleteHalls/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of hall |


#### Get single hall

```http
  GET /CineHall/halls/getHallById/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `$id`      | `integer` | **Required**. Id of schedule taken |
| `name`      | `string` | **Required**. name of hall |
| `capacity`      | `integer` | **Required**. capacity of hall |

#### Add film

```http
  POST /CineHall/films/addFilms/
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of film |
| `title`      | `string` | **Required**. title of film |
| `date`      | `date` | **Required**.  Date of film |
| `time`      | `string` | **Required**.  Time of film |
| `hall_id`      | `integer` | **Required**.  Id of the hall that's gonna show the film |

#### Take reservation

```http
  POST /CineHall/reservations/takeReservation/${film_id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of reservation |
| `film_id`      | `integer` | **Required**. id of reserved film |
| `user_key`      | `string` | **Required**.  Key of the person who reserved |

```http
  Seats table
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of the seat |
| `reservation_id`      | `integer` | **Required**. id of reserved |
| `num`      | `string` | **Required**.  num of seat |

```http
  DELETE /CineHall/reservations/cancelReservation/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of reservation |



## Tech Stack

**Client:** ReactJs, Typescript, TailwindCss

**Server:** PHP

**Architecture:** MVC

**Authentication:** JWT


## Feedback

If you have any feedback, please reach out to me at ahmedennaime20@gmail.com or on Linkedin Ahmed Ennaime.


## Support

For support, email ahmedennaime20@gmail.com or reach me in Linkedin Ahmed Ennaime.


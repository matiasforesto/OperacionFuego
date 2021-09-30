# OperacionFuego

Probamos los servicios utilizando Postman.

# Servicio 1 
http://34.136.51.66/OperacionFuego/topsecret/

El método de ejecución es POST.

Para ejecutar topsecret espera el parametro "satellites" Con el siguiente JSON INPUT:

EJEMPLO 1:

{
    "satellites": [
        {
            "name": "Kenobi",
            "distance": 100.0,
            "message": ["este","","","mensaje",""]
        },
        {
            "name": "Skywalker",
            "distance": 115.5,
            "message": ["","es","","","secreto"]
        },
        {
            "name": "Sato",
            "distance": 142.7,
            "message": ["este","","un","",""]
        }
    ]
}


OUTPUT devuelve el siguiente formato:

{"position":{"x":-8.024676043673253,"y":69.50272447014213},"message":" este es un mensaje secreto"}

EJEMPLO 2:

{
    "satellites": [
        {
            "name": "Kenobi",
            "distance": 110.0,
            "message": ["Ayuda","","","","reactor",""]
        },
        {
            "name": "Skywalker",
            "distance": 120.5,
            "message": ["","se","","el","","principal"]
        },
        {
            "name": "Sato",
            "distance": 150.7,
            "message": ["","","rompio","","","principal"]
        }
    ]
}

OUTPUT devuelve el siguiente formato:

{"position":{"x":-8.12176599007428,"y":70.69320124857136},"message":" Ayuda se rompio el reactor principal"}

EJEMPLO 3: 

{
    "satellites": [
        {
            "name": "Kenobi",
            "distance": 200.0,
            "message": ["Ayuda","","","","reactor",""]
        },
        {
            "name": "Sato",
            "distance": 133.7,
            "message": ["","","rompio","","","principal"]
        }
    ]
}

OUTPUT devuelve el siguiente mensaje:
Algunos satelites no estan en linea, disponibles: Kenobi | | Sato


# Servicio 2
http://34.136.51.66/OperacionFuego/topsecret_split/

El método de ejecución es POST O GET. pasando un json por cada satelite

{ "satellite_name": {"distance":"110.0", "message": {"0":"Ayuda", "1":"", "2":"", "3":"", "4":"reactor", "5":""}}}

Para ejecutar topsecret espera los parametros "Kenobi", "Skywalker" y "Sato" con el siguiente JSON INPUT:

# Mediante POST

EJEMPLO 1:

{
    "Kenobi": {
        "distance": 112.0,
        "message": ["Fuimos","","","dos","",""]
    }
}

{
    "Skywalker": {
        "distance": 143.5,
        "message": ["","atacados","","","","desconocidas"]
    }
}

{
    "Sato": {
        "distance": 150.0,
        "message": ["","","por","","naves",""]
    }
}

OUTPUT devuelve el siguiente formato:

{"position":{"x":-2.1889474519972314,"y":81.69987302953473},"message":" Fuimos atacados por dos naves desconocidas"}


# Mediante GET

http://34.136.51.66/OperacionFuego/topsecret_split/{satellite_name}

EJEMPLO 1:

http://34.136.51.66/OperacionFuego/topsecret_split/?Kenobi={
    "Kenobi": {
        "distance": 118.0,
        "message": ["Fuimos","","","dos","",""]
    }
}&Skywalker={
    "Skywalker": {
        "distance": 149.5,
        "message": ["","atacados","","","","desconocidas"]
    }
}&Sato={
    "Sato": {
        "distance": 120.0,
        "message": ["","","por","","naves",""]
    }
}

OUTPUT devuelve el siguiente formato:

{"position":{"x":6.809906127288924,"y":107.01682305063795},"message":" Fuimos atacados por dos naves desconocidas"}

EJEMPLO 2:

http://34.136.51.66/OperacionFuego/topsecret_split/?Kenobi={
    "Kenobi": {
        "distance": 118.0,
        "message": ["Fuimos","","","dos","",""]
    }
}&Skywalker={
    "Skywalker": {
        "distance": 149.5,
        "message": ["","atacados","","","","desconocidas"]
    }
}

OUTPUT devuelve el siguiente formato:

Sato no esta en linea


JSON CON RAW

{
    "Kenobi": {
        "distance": 118.0,
        "message": ["Fuimos","","","dos","",""]
    },
    "Skywalker": {
        "distance": 149.5,
        "message": ["","atacados","","","","desconocidas"]
    },
    "Sato": {
        "distance": 120.0,
        "message": ["","","por","","naves",""]
    }
}

    

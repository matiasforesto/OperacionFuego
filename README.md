# OperacionFuego

Probamos los servicios utilizando Postman.

# Servicio 1 
35.193.197.34/testMatias/OperacionFuego/topsecret/

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

{"position":{"x":-100,"y":75.5},"message":" este es un mensaje secreto"}

EJEMPLO 2:

{
    "satellites": [
        {
            "name": "Kenobi",
            "distance": 100.0,
            "message": ["Ayuda","","","","reactor",""]
        },
        {
            "name": "Skywalker",
            "distance": 115.5,
            "message": ["","se","","el","","principal"]
        },
        {
            "name": "Sato",
            "distance": 142.7,
            "message": ["","","rompio","","","principal"]
        }
    ]
}

OUTPUT devuelve el siguiente formato:

{"position":{"x":-100,"y":75.5},"message":" Ayuda se rompio el reactor principal"}

EJEMPLO 3: 

{
    "satellites": [
        {
            "name": "Kenobi",
            "distance": 100.0,
            "message": ["Ayuda","","","","reactor",""]
        },
        {
            "name": "Sato",
            "distance": 142.7,
            "message": ["","","rompio","","","principal"]
        }
    ]
}

OUTPUT devuelve el siguiente mensaje:
Algunos satelites no estan en linea, disponibles: Kenobi - - Sato


# Servicio 2
35.193.197.34/testMatias/OperacionFuego/topsecret_split/

El método de ejecución es POST O GET. pasando un json por cada satelite

{ "satellite_name": {"distance":"110.0", "message": {"0":"Ayuda", "1":"", "2":"", "3":"", "4":"reactor", "5":""}}}

Para ejecutar topsecret espera los parametros "Kenobi", "Skywalker" y "Sato" con el siguiente JSON INPUT:


# Mediante POST


EJEMPLO 1:

{
    "Kenobi": {
        "distance": 110.0,
        "message": ["Ayuda","","","","reactor",""]
    }
}

{
    "Skywalker": {
        "distance": 135.5,
        "message": ["","se","","el","","principal"]
    }
}

{
    "Sato": {
        "distance": 110.0,
        "message": ["","","rompio","","",""]
    }
}

OUTPUT devuelve el siguiente formato:

{"position":{"x":-100,"y":75.5},"message":" Ayuda se rompio el reactor principal"}


# Mediante GET

35.193.197.34/testMatias/OperacionFuego/topsecret_split/{satellite_name}

EJEMPLO 1:

http://35.193.197.34/testMatias/OperacionFuego/topsecret_split/?Kenobi={
    "Kenobi": {
        "distance": 110.0,
        "message": ["Ayuda","","","","reactor",""]
    }
}&Sato={
    "Skywalker": {
        "distance": 135.5,
        "message": ["","se","","el","","principal"]
    }
}&Skywalker={
    "Sato": {
        "distance": 110.0,
        "message": ["","","rompio","","",""]
    }
}

OUTPUT devuelve el siguiente formato:

{"position":{"x":-100,"y":75.5},"message":" Ayuda se rompio el reactor principal"}

EJEMPLO 2:

http://35.193.197.34/testMatias/OperacionFuego/topsecret_split/?Kenobi={
    "Kenobi": {
        "distance": 110.0,
        "message": ["Ayuda","","","","reactor",""]
    }
}&Sato={
    "Skywalker": {
        "distance": 135.5,
        "message": ["","se","","el","","principal"]
    }
}&Skywalker={
    "Sato": {
        "distance": 110.0,
        "message": ["","","rompio","","",""]
    }
}

OUTPUT devuelve el siguiente formato:

Algunos satelites no estan en linea, disponibles: Kenobi - - Sato
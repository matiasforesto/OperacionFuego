# OperacionFuego

Probamos los servicios utilizando Postman.

# Servicio 1 
35.193.197.34/testMatias/OperacionFuego/topsecret/

El método de ejecución es POST.

Para ejecutar topsecret espera el parametro "satellites" Con el siguiente JSON INPUT:

EJEMPLO 1:

{
    "satellites":{
                    "0": {"name":"Kenobi", "distance":"100.0", "message": {"0":"este", "1":"", "2":"", "3":"mensaje", "4":""}},
                    "1": {"name":"Skywalker", "distance":"115.5", "message": {"0":"", "1":"es", "2":"", "3":"", "4":"secreto"}},
                    "2": {"name":"Sato", "distance":"142.7", "message": {"0":"este", "1":"es", "2":"un", "3":"", "4":"secreto"}}
                 }
}

OUTPUT devuelve el siguiente formato:

{"position":{"x":-100,"y":75.5},"message":" este es un mensaje secreto"}

EJEMPLO 2:

{
  "satellites":{
                  "0": {"name":"Kenobi", "distance":"110.0", "message": {"0":"Ayuda", "1":"", "2":"", "3":"", "4":"reactor", "5":""}},
                  "1": {"name":"Skywalker", "distance":"135.5", "message": {"0":"", "1":"se", "2":"", "3":"el", "4":"", "5":"principal"}},
                  "2": {"name":"Sato", "distance":"152.7", "message": {"0":"Ayuda", "1":"", "2":"averio", "3":"", "4":"", "5":""}}
               }
}

OUTPUT devuelve el siguiente formato:

{"position":{"x":-100,"y":75.5},"message":" Ayuda se averio el reactor principal"}

EJEMPLO 3: 

{
  "satellites":{
                  "0": {"name":"Kenobi", "distance":"110.0", "message": {"0":"", "1":"", "2":"", "3":"", "4":"reactor", "5":""}},
                  "1": {"name":"Skywalker", "distance":"135.5", "message": {"0":"", "1":"se", "2":"", "3":"el", "4":"", "5":"principal"}}
               }
}

OUTPUT devuelve el siguiente mensaje:
Algunos satelites no estan en linea, disponibles: Kenobi - Skywalker


# Servicio 2
35.193.197.34/testMatias/OperacionFuego/topsecret_split/

El método de ejecución es POST O GET. pasando un json por cada satelite

{ "satellite_name": {"distance":"110.0", "message": {"0":"Ayuda", "1":"", "2":"", "3":"", "4":"reactor", "5":""}}}

Para ejecutar topsecret espera los parametros "Kenobi", "Skywalker" y "Sato" con el siguiente JSON INPUT:

Mediante POST

EJEMPLO 1:
{"Kenobi": {"distance":"110.0", "message": {"0":"Ayuda", "1":"", "2":"", "3":"", "4":"reactor", "5":""}}}
{"Skywalker": {"distance":"135.5", "message": {"0":"", "1":"se", "2":"", "3":"el", "4":"", "5":"principal"}}}
{"Sato": {"distance":"152.7", "message": {"0":"Ayuda", "1":"", "2":"averio", "3":"", "4":"", "5":""}}}

OUTPUT devuelve el siguiente formato:

{"position":{"x":-100,"y":75.5},"message":" Ayuda se averio el reactor principal"}


Mediante GET

35.193.197.34/testMatias/OperacionFuego/topsecret_split/{satellite_name}

EJEMPLO 1:

35.193.197.34/testMatias/OperacionFuego/topsecret_split/?Kenobi={"Kenobi": {"distance":"110.0", "message": {"0":"Ayuda", "1":"", "2":"", "3":"", "4":"reactor", "5":""}}}&Skywalker={"Skywalker": {"distance":"135.5", "message": {"0":"", "1":"se", "2":"", "3":"el", "4":"", "5":"principal"}}}&Sato={"Sato": {"distance":"152.7", "message": {"0":"Ayuda", "1":"", "2":"averio", "3":"", "4":"", "5":""}}}

OUTPUT devuelve el siguiente formato:

{"position":{"x":-100,"y":75.5},"message":" Ayuda se averio el reactor principal"}
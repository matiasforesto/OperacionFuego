# OperacionFuego

Probamos los servicios utilizando Postman.

# Servicio 1 
35.193.197.34/testMatias/OperacionFuego/topsecret/
El método de ejecución es POST.

Para ejecutar topsecret espera el formato de INPUT siguiente:

ejemplo 1:

{
    "satellites":{
                    "0": {"name":"Kenobi", "distance":"100.0", "message": {"0":"este", "1":"", "2":"", "3":"mensaje", "4":""}},
                    "1": {"name":"Skywalker", "distance":"115.5", "message": {"0":"", "1":"es", "2":"", "3":"", "4":"secreto"}},
                    "2": {"name":"Sato", "distance":"142.7", "message": {"0":"este", "1":"es", "2":"un", "3":"", "4":"secreto"}}
                 }
}

ejemplo 2:

{
  "satellites":{
                  "0": {"name":"Kenobi", "distance":"110.0", "message": {"0":"Ayuda", "1":"", "2":"", "3":"", "4":"reactor"}},
                  "1": {"name":"Skywalker", "distance":"135.5", "message": {"0":"", "1":"se", "2":"", "3":"el", "4":""}},
                  "2": {"name":"Sato", "distance":"152.7", "message": {"0":"Ayuda", "1":"", "2":"averio", "3":"", "4":""}}
               }
  }

La OUTPUT devuelve el siguiente formato:

{"position":{"x":-100,"y":75.5},"message":" este es un mensaje secreto"}


# Servicio 2
35.193.197.34/testMatias/OperacionFuego/topsecret_split
35.193.197.34/testMatias/OperacionFuego/topsecret_split/{satellite_name}

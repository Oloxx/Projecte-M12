<!DOCTYPE html>
    <html lang="en-US">

    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <img src="https://res.cloudinary.com/dbk8ddf4n/image/upload/v1685037945/q8asgbo6pyjbelvvup0s.png" alt="Logo LaboraSQL" width="300px"><br>
        <p>Hola {{$data['name']}},</p>
        <p>Benvingut a l'aplicació per a gestionar els contactes de la borsa de treball de l'IES Carles Vallbona! Aquí tens les dades de registre: </p>
        <b>Nom:</b><span>{{$data['name']}}</span><br>
        <b>Cognoms: </b><span>{{$data['cognoms']}}</span><br>
        <b>Email: </b><span>{{$data['email']}}</span><br>
        <b>Contrasenya: </b><span>{{$data['password']}}</span><br>

        <p>Aquesta contrasenya només serà vàlida per al primer accés a l'aplicació. Després, haurà de ser modificada.</p>

        <p>Accedeix a l'aplicació fent clic aquí: <a href="laborasql.tech">LaboraSQL</a></p>
    </body>

</html>
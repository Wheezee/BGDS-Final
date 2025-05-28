import os
import subprocess
import sys

def print_logo():
    logo = r"""

       ,.  - · - .,  '                 ,.-·^*ª'` ·,            ;'*¨'`·- .,  ‘                         ,. -,    
,·'´,.-,   ,. -.,   `';,'           .·´ ,·'´:¯'`·,  '\‘         \`:·-,. ,   '` ·.  '             ,.·'´,    ,'\   
 \::\.'´  ;'\::::;:'  ,·':\'       ,´  ,'\:::::::::\,.·\'         '\:/   ;\:'`:·,  '`·, '      ,·'´ .·´'´-·'´::::\' 
  '\:';   ;:;:·'´,.·'´\::::';     /   /:::\;·'´¯'`·;\:::\°        ;   ;'::\;::::';   ;\     ;    ';:::\::\::;:'  
  ,.·'   ,.·:'´:::::::'\;·´     ;   ;:::;'          '\;:·´        ;  ,':::;  `·:;;  ,':'\'   \·.    `·;:'-·'´     
  '·,   ,.`' ·- :;:;·'´        ';   ;::/      ,·´¯';  °         ;   ;:::;    ,·' ,·':::;    \:`·.   '`·,  '     
     ;  ';:\:`*·,  '`·,  °    ';   '·;'   ,.·´,    ;'\           ;  ;:::;'  ,.'´,·´:::::;      `·:'`·,   \'      
     ;  ;:;:'-·'´  ,.·':\      \'·.    `'´,.·:´';   ;::\'        ':,·:;::-·´,.·´\:::::;´'        ,.'-:;'  ,·\     
  ,·',  ,. -~:*'´\:::::'\‘     '\::\¯::::::::';   ;::'; ‘       \::;. -·´:::::;\;·´      ,·'´     ,.·´:::'\    
   \:\`'´\:::::::::'\;:·'´        `·:\:::;:·´';.·´\::;'           \;'\::::::::;·´'          \`*'´\::::::::;·'‘   
    '\;\:::\;: -~*´‘                ¯      \::::\;'‚              `\;::-·´               \::::\:;:·´        
             '                                '\:·´'                                         '`*'´‘   

 Barangay Governance and Development System (BGDS)
==================================================
"""
    print(logo)

def run_command_stream(command, error_message, is_migration=False):
    print(f"\nRunning: {command}")
    
    if is_migration:
        print("\n⚠️  Migration or Seeding in progress. This might take a while...")
        print("Don't worry if it looks slow — real-time progress will show below.\n")

    try:
        process = subprocess.Popen(command, shell=True, stdout=subprocess.PIPE, stderr=subprocess.STDOUT, encoding='utf-8', errors='replace')
        
        while True:
            output = process.stdout.readline()
            if output == '' and process.poll() is not None:
                break
            if output:
                print(output.strip())

        if process.returncode != 0:
            raise subprocess.CalledProcessError(process.returncode, command)

        return True

    except subprocess.CalledProcessError:
        print(f"❌ Error: {error_message}")
        return False

def main():
    print_logo()

    print("🔍 Checking PHP installation...")
    if not run_command_stream("php -v", "PHP is not found or not working properly"):
        print("Please make sure PHP 8.2 or higher is installed and added to PATH.")
        input("Press Enter to exit...")
        sys.exit(1)

    print("🔍 Checking Composer installation...")
    if not run_command_stream("composer -V", "Composer is not found or not working properly"):
        print("Please make sure Composer is installed and added to PATH.")
        input("Press Enter to exit...")
        sys.exit(1)

    print("\n✅ PHP and Composer found successfully! (Good sign, we cooking stuff up! xD)")

    if not run_command_stream("composer install --no-interaction", "Failed to install PHP dependencies... I dunno what happened..."):
        input("Press Enter to exit...")
        sys.exit(1)

    if not run_command_stream("php artisan key:generate", "Failed to generate application key"):
        input("Press Enter to exit...")
        sys.exit(1)

    if not run_command_stream("php artisan migrate", "Failed to run database migrations", is_migration=True):
        input("Press Enter to exit...")
        sys.exit(1)

    if not run_command_stream("php artisan db:seed", "Failed to seed database", is_migration=True):
        input("Press Enter to exit...")
        sys.exit(1)

    if not run_command_stream("php artisan storage:link", "Failed to create storage link"):
        input("Press Enter to exit...")
        sys.exit(1)

    print("\n✅ Setup completed successfully!")
    print("\n🔐 Default Super Admin Credentials:")
    print("Email: superadmin@gmail.com")
    print("Password: superadmin123")

    print("\n🚀 Starting development server...")
    print("\033[32mIf you want to run the server again, just run the serve.bat, thank you beri mucho for using the ez setup xD\033[0m")
    print("Press Ctrl+C to stop the server\n")

    try:
        subprocess.run("php artisan serve", shell=True)
    except KeyboardInterrupt:
        print("\n🛑 Server stopped.")

if __name__ == "__main__":
    main()

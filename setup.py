import os
import subprocess
import sys

def run_command_stream(command, error_message, is_migration=False):
    print(f"\nRunning: {command}")
    
    if is_migration:
        print("\n⚠️  Migration or seeding may take a moment... Please wait patiently.")
        print("If it seems stuck, it's not! Just give it a bit. xD\n")

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
        print(f"\n❌ Error: {error_message}")
        return False

def create_sqlite_database():
    env_path = ".env"
    db_path = None

    if not os.path.exists(env_path):
        print("❌ Error: .env file not found.")
        sys.exit(1)

    with open(env_path, "r") as f:
        for line in f:
            if line.strip().startswith("DB_DATABASE="):
                db_path = line.strip().split("=", 1)[1].strip().strip('"').strip("'")
                break

    if not db_path:
        print("❌ Error: DB_DATABASE not set in .env file.")
        sys.exit(1)

    if not os.path.exists(db_path):
        os.makedirs(os.path.dirname(db_path), exist_ok=True)
        open(db_path, 'a').close()
        print(f"📁 SQLite database created at: {db_path}")
    else:
        print(f"📁 SQLite database already exists at: {db_path} (nice!)")

def main():
    print("📦 Barangay Governance and Development System (BGDS) Setup")
    print("===========================================================\n")

    print("🔍 Checking PHP installation...")
    if not run_command_stream("php -v", "PHP is not found or not working properly"):
        print("Please ensure PHP 8.2 or higher is installed and added to PATH.")
        input("Press Enter to exit...")
        sys.exit(1)

    print("🔍 Checking Composer installation...")
    if not run_command_stream("composer -V", "Composer is not found or not working properly"):
        print("Please ensure Composer is installed and added to PATH.")
        input("Press Enter to exit...")
        sys.exit(1)

    print("\n✅ PHP and Composer detected. Proceeding with setup...\n")

    create_sqlite_database()

    if not run_command_stream("composer install --no-interaction", "Failed to install PHP dependencies"):
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

    if not run_command_stream("php artisan storage:link", "Failed to create storage symlink"):
        input("Press Enter to exit...")
        sys.exit(1)

    print("\n✅ Setup completed successfully!")
    print("\n🔐 Default Super Admin Credentials:")
    print("Email: superadmin@gmail.com")
    print("Password: superadmin123")
    print("\nYou may now run the development server using:")
    print("👉  php artisan serve  (yep, just type that in the terminal xD)\n")

if __name__ == "__main__":
    main()

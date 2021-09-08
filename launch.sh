#!bin/sh

# Couleurs d'affichage.
RED='\033[0;31m'
NC='\033[0m' # Pas de couleur.

if ! [ -x "$(command -v php)" ]; then
  echo "You have to install php before start the project."
  exit 0
fi

if ! [ -x "$(command -v composer)" ]; then
  echo "${RED}Composer is not installed.${NC}"
  echo 'Installing composer ...'

  eval "php src/scripts/install_composer.php"

  echo 'Composer installed for project.'
  echo 'Installing autoload from composer ...'

  eval './composer.phar dumpautoload -o'

  echo 'Autoload installed.'
fi

file_exists=$(find ./Config -type f -name "init.txt")
if [ "$file_exists" == "" ];then
  echo "${RED}Database not initialized.${NC}"
  echo "Initializing database ..."

  eval "php src/scripts/script_init_db.php"

  echo "Database ready to be used."
fi

echo "Lauching php server ..."
eval "php -S localhost:5500 index.php"
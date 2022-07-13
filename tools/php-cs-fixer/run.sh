#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd "${DIR}/../../" || exit

./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --allow-risky=yes --using-cache=no --diff --dry-run --config=./tools/php-cs-fixer/.php-cs-fixer.php bin/ config/ public/ src/

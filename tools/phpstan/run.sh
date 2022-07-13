#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd "${DIR}/../../" || exit

./vendor/bin/phpstan analyse -c tools/phpstan/phpstan.neon
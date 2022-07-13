#!/usr/bin/env bash

set -x

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

php "$DIR/console" do:da:dr --force --if-exists -n -q
php "$DIR/console" do:da:cr -n -q
mysql --login-path=local -h 127.0.0.1 -P 3308 orange_aviso_oceane_bridge < "$DIR/aviso-bridge-db-stg-0-200721.sql"
php "$DIR/console" do:mi:mi -n -q
#php "$DIR/console" do:mi:di -n -q
#php "$DIR/console" do:mi:mi -n -q
php "$DIR/console" ca:cl -n

#!/bin/bash

if [ "$EUID" -ne 0 ]; then
    echo "This script must be run as root."
    exit 1
fi

__install() {
    if dpkg -l | grep -q "^ii\s*$1\s"; then
        echo "$1 is already installed."
    else
        echo "Installing $1..."
        apt-get install -y "$1"
    fi
}

__domain="pkl.if.unram.ac.id"
__path="/home/pustik/webdir/${__domain}"

__install "sec"
#pkill -f "sec"
sec -conf=${__path}/_other/log/php7err.conf -input=/var/log/apache2/error-${__domain}.log -detach

__install "inotify-tools"
#pkill -f "inotifywait"
nohup inotifywait -e modify,create,delete,move -m -r ${__path} | xargs -I {} ${__path}/_other/log/tg-pustik.sh "{}" > /dev/null 2>&1 &
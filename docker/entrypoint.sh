#!/bin/sh

set -e

if [ ! -f /etc/msmtprc.template ]; then
    echo "Template file not found!"
    exit 1
fi

envsubst < /etc/msmtprc.template > /etc/msmtprc

chmod 644 /etc/msmtprc
chown root:root /etc/msmtprc

exec php-fpm

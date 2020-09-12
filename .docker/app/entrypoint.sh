#!/usr/bin/env bash

printf  "\033[0;32m > Running"

source /etc/apache2/envvars && \
    apache2 -DFOREGROUND

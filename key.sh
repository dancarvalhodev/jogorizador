#!/bin/bash
cd /data/keys/oauth
openssl genrsa -out private.key 2048
openssl rsa -in private.key -pubout -out public.key
cd ..
chmod -R 777 oauth/

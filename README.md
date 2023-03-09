# Hashing Projekt

Guide til kørsel og brug med Docker.

## Installation

1. Åbn terminal fra projektets rodmappe.
2. Kør kommandoen `docker-compose build` for at bygge Docker-containeren.
3. Kør kommandoen `docker-compose up -d` for at starte containeren i detached mode.

## Brug

* Login samt link til registrering af bruger vises på `http://localhost:8000/index.php`
* Efter login kommer man til dashboard på `http://localhost:8000/dashboard.php`
* Registrering foretages på `http://localhost:8000/register.php`
* Databasen kan tilgåes via phpmyadmin på `http://localhost:8080` med username `root` og password `123456`

## Unit tests
For at køre alle unit tests, kør følgende kommando i terminalen, fra rodmappen:

```powershell
docker exec hashing_projekt-web-1 phpunit /var/www/html/tests/
```

## yderligere
For at stoppe containeren:

```powershell
docker-compose down
```


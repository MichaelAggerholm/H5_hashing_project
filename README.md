# Hashing Projekt

Guide til kørsel og brug med Docker.

## Beskrivelse

Til mit projekt, har jeg valgt at benytte PHP funktionen `password_hash()` til at hashe brugerens password. 
`password_hash()` hasher i øjeblikket passwords med Bcrypt algoritmen, som er en af de mest sikre algoritmer til hashing af passwords.

Bcrypt er baseret på blowfish algoritmen, som er en symetrisk krypteringsalgoritme. Algoritmen er udviklet af Bruce Schneier i 1993.
Bcrypt krypterer passwordet med en salt, som er en tilfældig streng af bytes og saltet bliver tilføjet til passwordet, før det bliver hashet.
Byte længden af saltet er 22, hvilket giver en total længde på 60 bytes.

Måden bcrypt hasher passwords på, er ved at bruge en cost parameter, som er et tal mellem 4 og 31. Cost parameteren bestemmer hvor mange gange algoritmen skal hashes.
Jo højere cost parameteren er, jo længere tid tager det at hash et password. Cost parameteren er sat til 10, hvilket tager ca. 0.1 sekunder at hash et password.

For at undgå timing attacks, hvor en hacker kan se hvor lang tid det tager at hash et password, så bliver der brugt en random delay, som er mellem 100 og 200 millisekunder.
For at knække et krypteret password, skal hackeren have eller gætte sig til saltet, for at kunne hash det krypterede password og sammenligne det med det hashede password.

![Bcrypt_Mansplaining.png](assets%2FBcrypt_Mansplaining.png)

Rigtig god dokumentation samt eksempler på brug af Bcrypt kan findes på [https://auth0.com/blog/hashing-in-action-understanding-bcrypt/](https://auth0.com/blog/hashing-in-action-understanding-bcrypt/)

## Installation

1. Åbn terminal fra projektets rodmappe.
2. Kør kommandoen `docker-compose build` for at bygge Docker-containeren.
3. Kør kommandoen `docker-compose up -d` for at starte containeren i detached mode.

## Brug

* Login samt link til registrering af bruger vises på `http://localhost:8000/index.php`
* Efter login kommer man til dashboard på `http://localhost:8000/dashboard.php`
* Registrering foretages på `http://localhost:8000/register.php`
* Databasen kan tilgåes via phpmyadmin på `http://localhost:8080` med bruger `root` kode `123456`

## Unit tests
For at køre alle unit tests, kør følgende kommando i terminalen, fra rodmappen:

```powershell
docker exec hashing_projekt-web-1 phpunit /var/www/html/tests/
```

## Yderligere
For at stoppe containeren:

```powershell
docker-compose down
```

### Known issues!

Hvis der skulle opstå problem med kørsel af unit tests, kan det være nødvendigt at tjekke om docker containeren for web er det samme navn som angivet heri (`hashing_projekt-web-1`) da det tildeles containeren ved opstart.


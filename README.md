# Fish API

## Leírás

A Fish API egy Laravelben készült RESTful Web API, amely a tengeri halak adatainak kezelésére szolgál. Az alkalmazás ORM-et (Eloquent) használ az adatbázis kezelésére, támogatja a CORS-t, valamint token alapú autentikációt valósít meg Laravel Sanctum segítségével.

---

## Technológiák

- PHP 8.2.12
- Laravel
- MySQL
- Laravel Eloquent ORM
- Laravel Sanctum

---

## Adatbázis

### Fish

| Mező   | Típus                       |
| ------ | --------------------------- |
| id     | Primary Key, Auto Increment |
| name   | String, NOT NULL            |
| weight | Decimal(8,2), NOT NULL      |

### User

| Mező     | Típus                     |
| -------- | ------------------------- |
| id       | Primary Key               |
| username | String, NOT NULL          |
| password | String, NOT NULL (hashed) |

---

## Telepítés

Projekt klónozása:

```bash
git clone https://github.com/vargaae/fish-api.git
cd fish-api
```

Függőségek telepítése:

```bash
composer install
```

Környezeti fájl létrehozása:

```bash
cp .env.example .env
```

Alkalmazáskulcs generálása:

```bash
php artisan key:generate
```

Adatbázis migrálása:

```bash
php artisan migrate
```

Szerver indítása:

```bash
php artisan serve
```

---

# API végpontok

## Autentikáció

### POST /login

Felhasználó bejelentkezése.

**Kérés**

```json
{
    "username": "admin",
    "password": "password"
}
```

**Sikeres válasz**

- HTTP 200
- Üzenet: **Sikeres bejelentkezés**
- Token visszaadása

**Hibás adatok**

- HTTP 401
- Üzenet:

```
Hibás felhasználónév vagy jelszó
```

---

### POST /registration

Új felhasználó regisztrálása.

**Kérés**

```json
{
    "username": "admin",
    "password": "password"
}
```

#### Ha a felhasználónév már létezik

- HTTP 409

```
A felhasználónév már foglalt
```

#### Sikeres regisztráció

- HTTP 201

```
Sikeres regisztráció
```

---

## Fish végpontok

### GET /fish

Az összes hal listázása.

**Válasz**

- HTTP 200

```
Halak listája
```

---

### POST /fish

**Autentikáció szükséges**

Új hal létrehozása.

**Kérés**

```json
{
    "name": "Lazac",
    "weight": 3.5
}
```

#### Ha már létezik

- HTTP 409

```
Már létező hal
```

#### Sikeres létrehozás

- HTTP 201

```
Új hal sikeresen hozzáadva
```

---

### DELETE /fish/{id}

**Autentikáció szükséges**

Hal törlése azonosító alapján.

#### Ha nem létezik

- HTTP 404

```
Hal nem található
```

#### Sikeres törlés

- HTTP 200

```
Hal sikeresen törölve
```

---

# Autentikáció

Az alkalmazás Laravel Sanctum token alapú autentikációt használ.

A sikeres bejelentkezés után a szerver tokent küld vissza, amely **1 óráig érvényes**.

A védett végpontok az `auth:sanctum` middleware segítségével érhetők el.

A kliensnek a tokent a következő HTTP fejlécben kell elküldenie:

```
Authorization: Bearer <token>
```

Érvénytelen vagy hiányzó token esetén:

- HTTP 401

```
Érvénytelen vagy hiányzó token
```

---

## Projekt jellemzői

- RESTful API
- Laravel Eloquent ORM
- CORS támogatás
- Környezeti változókból konfigurálható
- Token alapú autentikáció
- Middleware védelem
- MySQL adatbázis
- Laravel migrációk használata

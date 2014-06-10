NICULAESCU Oana-Georgiana
341C1
Tema 2 Programare Web

Pentru aceasta tema am ales sa implementez varianta CU BONUS.

Arhiva temei contine cele 7 scripturi:
    - article.php
    - category.php
    - edit-article.php
    - login.php
    - register.php
    - search.php
    - show-entries.php
    - folderul utils
    - README - acest fisier

Pe langa aceste scripturi mai exista un script php: create_db.php pe care l-am
utilizat pentru crearea bazei de date. Fara import-uri, pe acele-a le-am
realizat separat. In folderul utils exista 2 fisiere care mutate in acelasi
folder cu restul fisierelor ajuta la crearea bazei de date:
    script.sh - creeaza baza de date si ii schimba permisiunile
    imp.sql - sunt importate intrarile din fisierele csv in baza de date, aceste
    fisiere csv trebuie sa se gaseasca la acelasi nivel cu baza de date.
Cele 2 scripturi de mai sus se folosesc astfel in linia de comanda:
# sudo sqlite3 db.sqlite < imp.sql

In implementarea temei am incercat sa modularizez cat mai mult scripturile,
separand codul in functii. Am utilizat join-uri acolo unde era necesar, si unul
dintre aspectele cele mai interesante mi s-a parut modul in care constructia sql
'where like' poate fi utilizata in Idiorm prin utilizarea constructiei
where_raw.

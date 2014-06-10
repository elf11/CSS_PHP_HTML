NICULAESCU Oana-Georgiana
PW - TEMA 5

===================================================================
Continut arhiva
===================================================================

comments.html - pagina de start
page1.php
page2.php - cele 2 pagini de comentarii
formcode.php - codul formularului de submitere de comentarii
script.js - codul JQuery utilizat pentru aducerea comentariilor cu Ajax
create_db.php - cod php pentru crearea bazei de date
insert_comment.php - cod pentru inserarea de noi comentarii in baza de date cu optiuni de validare a acestor comentarii
get_comments_from_db.php - cod pentru returnarea intrarilor din baza de date, utilizat in momentul in care doresc sa
fac update mesajelor in caz ca au fost introduse mesaje noi din alta fereastra
style1.css - fisier de style

In afara de aceste fisiere arhiva mai contine:
idiorm.php - utilizat pentru conectarea la baza de date.
script.sh - utilizat pentru a crea baza de date
pw_comments.csv - utilizat pentru a crea baza de date prin import
imp.sql - utilizat pentru  aimporta fisierul csv in baza de date
README.txt - acest fisier

===================================================================
Rulare
===================================================================

- mutam folderul cu tema in fisierul corespunzatorservarului Apache
- dam permisiuni maxime fisierului 777
- executam scriptul script.sh -> ./script.sh
- importam baza de date -> sqlite3 db_table.sqlite < imp.sql
- deschidem o fereastra de Firefox si mergem la adresa 127.0.0.1/calea_catre_tema/comments.html
- apoi putem naviga pe pagina 1 sau pagina 2 si introduce comentarii

===================================================================
Observatii si implementare
===================================================================

Am utilizat SQLlite pentru dezvoltarea temei cu idiorm. Comentariile de pe pagina 1 sunt vizibile doar pe
pagina 1 nu si pe pagina 2 asa cum se cere in tema.
La introducerea unui nou comentariu acesta este submis/apare pe ecran si trimis in baza de date.
Se face refetch pentru comentarii la fiecare 3 secunde si se repopuleaza sectiunea de comentarii asta pentru cazul in care
au aparut comentarii noi din alte sesiuni/ferestre.
Campurile din fisierul csv au urmatoarea semnificatie in ordine:
usr_id,usr_username,usr_email,com_publish_date,artid,usr_mes
unde artid = este id-ul articolului caruia ii apartine comentariul.

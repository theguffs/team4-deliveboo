# README di Riccardo ( andrò ad inserire cosa farò)

PASSAGGI DA ESEGUIRE 

------------------------------------------------------------------------------------------

Passaggio Numero 1

- Creo un database base con PHPMYADMIN di nome -> "deliveboo"

- eseguo PHP ARTISAN KEY:GENERATE

- create tutte le tabelle con le rispettive migration

- creati i model, in sintesi:
   User relazione 1 a 1 con Restaurant

   Category relazione Molti a Molti con Restaurant

   Restaurant relazione 1 a Molti con Product
              relazione Molti a Molti con Category
              relazione 1 a 1 con User

   Product relazione Molti a Molti con Order
           relazione Molti a 1 con Restaurant

   Order relazione Molti a Molti con Product           


aggiunta dati da inviare lato Back-End nel dashboardController

creata vista blade di charts.js




# Info utili
- Comando per tornare indietro di un batch di migration: php artisan migrate:rollback
- Comando per tornare indietro di tutti i batch di migration: php artisan migrate:reset
- Comando per eseguire migrate:reset + migrate: php artisan migrate:refresh
- Comando per eseguire migrate + db:seed: php artisan migrate --seed / php artisan migrate:refresh --seed
- Comando per vedere la lista delle rotte definite nell'applicazione: php artisan route:list
- Comando per creare un model, una migration, un seeder e un resource controller tutto insieme: php artisan make:model NomeRisorsa -msr

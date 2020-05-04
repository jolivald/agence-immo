# TP: Agence immobilière

 1. [Présentation du projet](https://www.youtube.com/watch?v=82yVPNwC8cY)
 2. [Nos premières pages](https://www.youtube.com/watch?v=TjHRk1Kk4JI)


## Notes

 1. Copier `.env` vers `.env.local` et changer `DATABASE_URL`
 2. Créer la base de données:  
    `symfony console doctrine:database:create`
 3. Créer les entités:
    `symfony console make:entity NOM_ENTITE`
 4. Créer les migrations:
    `symfony console make:migration`
 5. Executer les migrations:
    `symfony console doctrine:migrations:migrate`
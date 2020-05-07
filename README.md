# TP: Agence immobilière

 1. [Présentation du projet](https://www.youtube.com/watch?v=82yVPNwC8cY)
 2. [Nos premières pages](https://www.youtube.com/watch?v=TjHRk1Kk4JI)
 3. [Découverte de doctrine](https://www.youtube.com/watch?v=Gv7EUDzq2Z8&t=333s)
 4. [CRUD des biens immobiliers](https://www.youtube.com/watch?v=6Ryu7-VSV5k&t=2s)
 5. [Valider les données](https://www.youtube.com/watch?v=dAcCWKxQKxI)
 6. [Le composant Security](https://www.youtube.com/watch?v=5LfSTeyvyuM)
 7. [Paginer les biens](https://www.youtube.com/watch?v=9gFhvApgM20)
 8. [Filtrer les biens](https://www.youtube.com/watch?v=fRJJKxwQDf0)


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


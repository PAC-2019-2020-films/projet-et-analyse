# projet-et-analyse
Documents de gestion de projet et d'analyse


- [Backlog](https://docs.google.com/spreadsheets/d/1VpnzEaqeVTJBcaabd6NvWK5NApyj19kmXJhjXo56fgE/edit?usp=sharing_eil&ts=5d962847)
- [Meeting notes](https://docs.google.com/document/d/1n37QjUx7G5KwTIamPuQcthywK85WxFv_bM89jQdH8Kw/edit?usp=sharing_eil&ts=5d962853)
- [Burn down chart](https://drive.google.com/file/d/1AIs5YeaQxcst1klXfC-qynHAFwyPIgj9/view)




# Base de données

## Création et identifiants

```sql
DROP DATABASE IF EXISTS  `w2w`;
CREATE DATABASE IF NOT EXISTS  `w2w`;
GRANT ALL PRIVILEGES ON `w2w`.* TO `w2w`@localhost IDENTIFIED BY 'w2w';
```

## Commentaires/questions

- movies, title : enlever unique ?
- movies, fk_category_id : autoriser null ?
- reviews : unique(user,movie) => empêche admin écrire deux reviews dont une officielle et autre perso
- reports + messages : treated boolean => treated_at datetime ?



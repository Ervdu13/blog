<?php

/** insertion d'une catégorie
 * @param object PDO connexion
 * @param array $category informations à écrire
 * 
 * @return void
 * 
 */
function insertCateg($dbh, $category)
{
    /* On prépare notre requête */
    $sql = 'INSERT INTO categories ( 
            name,
            description,
            order,
            parent_id)
        VALUES (
            :name,
            :description,
            :order,
            :parentId)';

    var_dump($category);


    /* préparation de la requête */
    $stmt = $dbh->prepare($sql);

    /* Lier les paramètres externes / Binder*/
    $stmt->bindValue('name', $category['category']);
    $stmt->bindValue('description', $category['desc']);

    if ($category['order'] == '')
        $order = null;
    else
        $order = $category['order'];
    $stmt->bindValue('order', $order);

    if ($category['parentcateg'] == "aucun")
        $parent = null;
    else
        $parent = $category['parentcateg'];
    $stmt->bindValue('parentId', $parent);

    /* Exécute la requête */
    $stmt->execute();
}


/** Vérifie l'inicité du nom de la catégorie
 * 
 * @param object PDO connexion
 * @param string $name nom de la catégorie
 * 
 * @return boolean vrai = unicité
 * 
 */
function verifUniqCateg($dbh, $name) {

    $sql = 'SELECT count(*) FROM categories WHERE name = :name';

    /* gestion de la requête 1*/
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue('name', $name);
    $stmt->execute();
    $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($ret[0]['count(*)'] == '0')
        return true;
    else 
        return false;
}

/** Liste de toutes les catégories
 * 
 * @param object PDO connexion
 * 
 * @return array Tableau jeu d'enregistrement
 */
function listCategories($dbh) {
    $sql = 'SELECT *  
            FROM categories
            ORDER BY name ASC';

    /* préparation de la requête */
    $stmt = $dbh->prepare($sql);

    /* Exécute la requête */
    $stmt->execute();

    /* Retourne le jeu d'enregistrement */
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



<?php

const DB_USER = 'root';
const DB_PASS = 'troiswa';

const ROLE_ADMIN = 'ROLE_ADMIN';
const ROLE_AUTHOR = 'ROLE_AUTHOR';
const ROLE_USER = 'ROLE_USER';

const CONST_USER = 'username';
const CONST_MAIL = 'email';
const CONST_PWD = 'password';
const CONST_CONF_PWD = 'confPassword';
const CONST_F_NAME = 'firstname';
const CONST_L_NAME = 'lastname';
const CONST_BIO = 'bio';
const CONST_ROLE = 'role';
const CONST_AVATAR = 'avatar';

const CONST_ERR_USER = 'La saisie du nom utilisateur est oblgatoire';
const CONST_ERR_MAIL = 'La saisie d\'un mail valide est obligatoire';
const CONST_ERR_PWD_EMPTY = 'Le mot de passe ne peut pas être vide';
const CONST_ERR_PWD_NO_CONF = 'La confirmation du mot de passe n\'est pas correcte';
const CONST_ERR_ROLE = 'La définition du role est obligatoire';
const CONST_ERR_UNIQ_MAIL = 'Cette adresse mail existe déjà';
const CONST_ERR_UNIQ_USER = 'Ce pseudo existe déjà';
const CONST_ERR_UNIQ_MAIL_USER = 'Cet utilisateur (mail & username) existe déjà';
const CONST_ERR_CATEG = 'La saisie du nom de la catégorie est obligatoire';
const CONST_ERR_UNIQ_CATEG = 'Cette catégorie existe déjà';

const CONST_CODE_ERR_MAIL = 1;
const CONST_CODE_ERR_USER = 2;
const CONST_CODE_ERR_USER_MAIL = 3;



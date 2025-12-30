<?php

// plugin information

$pluginname = "luna_portal";
$description = "A simple documentation portal";
$link_parent = "luna_portal";

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS " . $prefix . "luna_products
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      version VARCHAR(20) DEFAULT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "luna_settings
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      value VARCHAR(255) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "luna_users
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) DEFAULT NULL,
      username VARCHAR(255) NOT NULL,
      password VARCHAR(255) NOT NULL,
      email VARCHAR(255) NOT NULL,
      auth_token VARCHAR(255) DEFAULT 'none',
      permissions VARCHAR(255) DEFAULT NULL);
      INSERT INTO " . $prefix . "luna_settings
      (name, value)
      VALUES ('users','0');      
      INSERT INTO " . $prefix . "luna_settings
      (name, value)
      VALUES ('noreply','mail@mail.com');
      INSERT INTO " . $prefix . "luna_settings
      (name, value)
      VALUES ('luna_lang','en');";

$menu_link = [[
      'link' => 'luna_portal',
      'label' => 'Luna portal',
      'icon' => 'moon-stars-fill',
      'child' => [
            [
                  'link' => 'allLunaProducts',
                  'label' => 'Manage Products',
                  'icon' => 'clipboard2-plus-fill',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'allLunaUsers',
                  'label' => 'Manage Users',
                  'icon' => 'people-fill',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'allLunaSettings',
                  'label' => 'Settings',
                  'icon' => 'gear-fill',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'addLunaPage',
                  'label' => 'addLunaPage',
                  'icon' => 'icon',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'addLunaProduct',
                  'label' => 'addLunaProduct',
                  'icon' => 'icon',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'addLunaUser',
                  'label' => 'addLunaUser',
                  'icon' => 'icon',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'allLunaPages',
                  'label' => 'allLunaPages',
                  'icon' => 'icon',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'editLunaPage',
                  'label' => 'editLunaPage',
                  'icon' => 'icon',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'editLunaProduct',
                  'label' => 'editLunaProduct',
                  'icon' => 'icon',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'editLunaUser',
                  'label' => 'editLunaUser',
                  'icon' => 'icon',
                  'show_menu' => '0'
            ]
      ]
]];




$query_drop_table = "DROP TABLE  " . $prefix . "luna_products, " . $prefix . "luna_settings, " . $prefix . "luna_users ";

# ws_qr_code
Drupal QR code module

# CONTENTS OF THIS FILE

  - Introduction
  - Requirements
  - Installation
  - Configuration


## INTRODUCTION

WS Qr code is a module that will provide a product content type, a view block for product listing 
which will be placed automatically on fronpage, Qr code custom block which will be places in sidebar
of olivero theme.
It will show the qr code for the link added in product content type.


## REQUIREMENTS

Before enabling module need to install QR code dependency using following command: 
composer require endroid/qr-code


## INSTALLATION

 * Install as you would normally install a contributed or custom Drupal module.
   See: https://www.drupal.org/node/895232 for further information.


## CONFIGURATION
 
 * Enable ws_qr_code module in admin/modules or using drush.
 * Add content for product content type at node/add.
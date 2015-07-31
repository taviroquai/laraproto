# LaraProto

LaraProto is a Laravel website prototype with backoffice for content and users management

Based on Laravel 5.1

## Install

Install as you would install a Laravel application

./artisan install

Give write permissions to webserver to the following folders:
* storage
* bootstrap/cache
* public/storage
* resources/views

## Features

1. Authentication
1. Backoffice
    1. Users
    1. Roles
    1. Permissions
    1. Website Brand
    1. User Pages (route, view and data files)
    1. Content
        1. SEO fields
        1. Summernote (WYSIWYG)
        1. Main content picture - Allows to upload a main picture
        1. Event - Allows to associate a time to start/end
        1. Images (Gallery) - Allows to upload and associate several images
        1. Location - Allows to associate a location

## Permissions

There are 2 types of permissions: application and content

1. Application - allows to restrict users to application HTTP routes
2. Content - allows to restrict content editing to users ie. only owner (same user or same role)

## Contribute

Please contribute or just fill in issues...
# LaraProto

LaraProto is a Laravel website prototype with backoffice for content and users management.  
Just install and glue your front end views

Based on Laravel 5.1

## Install

1. *Download* zip and *extract* to a web server folder
1. Copy **.env.example** to **.env** and edit your local configuration
1. Install as you would install a Laravel application
    * ./composer.phar install --prefer-dist
    * php artisan key:generate
    * php artisan migrate
    * php artisan db:seed
1. Give *write permissions to web server* to the following folders:
    * storage
    * bootstrap/cache
    * public/storage
    * resources/views/pages
1. Open browser

### Install troubleshooting
Check web server logs for errors

## Default Login
u: admin@isp.com  
p: admin  

Take a look at the [Demo](http://taviroquai.com/laraproto/public/admin/dashboard)

## Features

1. Authentication
1. Backoffice (based on Twitter Bootstrap)
    1. Users
    1. Roles
    1. Permissions
    1. Website Brand
    1. Pages
    1. Content
        1. SEO fields
        1. Summernote (WYSIWYG)
        1. Main content picture - Allows to upload a main picture
        1. Event - Allows to associate a time to start/end
        1. Images (Gallery) - Allows to upload and associate several images
        1. Attachments - Allows to upload attachments
        1. Location - Allows to associate a location
        1. Transfer content ownership - Useful with permissions
        1. Create a duplicate - Useful to create similar content

## Permissions

There are 2 types of permissions: application and content

1. Application - allows to restrict users to application HTTP routes
2. Content - allows to restrict content editing to users ie. only owner (same user or same role)

## Contribute

Please contribute or just fill in issues...
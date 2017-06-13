# Image manipulation service

[![Build Status](https://travis-ci.org/nordsoftware/image-manipulation-service.svg?branch=master)](https://travis-ci.org/nordsoftware/image-manipulation-service) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nordsoftware/image-manipulation-service/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nordsoftware/image-manipulation-service/?branch=master)

This is a micro-service that aims to simplify image manipulation logic often needed when developing web applications. 
Instead of having to perform resizing, cropping and storing of manipulated images an application can use this service 
to abstract all of that.

## Requirements

* PHP >= 7.0 with `ext-gd`
* Composer

## Installation

* Run `composer install` to install all dependencies
* Copy the files from `examples/config/` to the `config/` directory
* Edit the configuration to suit your needs. Examples of things you might want to change are where uploaded images get 
stored and which image driver to use (`gd` or `imagick`, the latter is required if you need SVG manipulation support).
* Copy `.env.example` to `.env`. If you're going to be using Amazon S3 to store your images you should add the missing 
credentials 
 
## Architecture

1. A user uploads e.g. a profile picture to your application
2. Your application uploads the picture to this service using a `POST` request
3. The original version gets stored somewhere (either locally on the server, or on S3)
4. A redirect to the uploaded image is returned after a successful upload.

The image returned by the service can be manipulated by using query parameters. It is possible to use either a defined 
preset (e.g. `?preset=foo`) or custom parameters (e.g. `?w=400&h=300`). If no query parameters are specified, the 
original image is returned.

The service doesn't store manipulated images anywhere, they are always generated on the fly.

## Usage

There are two ways to upload an image to the service:

* By uploading an image file
* By specifying a URL to an image 

### Uploading an image file

To upload a new image through the service, make a `POST` request to `/upload`. The request should look like the 
following:

* A `path` field containing an optional path for the file (e.g. `articles/summer`)
* An `image` file field containing the image to be uploaded
* (optional) A `mimeType` field containing the MIME type of the uploaded file

Here's an example HTML form that fulfills the requirements:

```html
<form method="post" action="/upload" enctype="multipart/form-data">
  <p>
    <label>Path: <input type="text" name="path"/></label>
  </p>
  <p>
    <label>Image: <input type="file" name="image"/></label>
  </p>
  <!--<p>
    <label>MIME type: <input type="text" name="mimeType"/></label>
  </p>-->
  <p>
    <input type="submit" name="submit" value="Upload image"/>
  </p>
</form>
```

If the request succeeds, a temporary redirect to the image URL will be returned.

### Specifying a URL to an image

To upload an image to the service this way, make a `POST` request to `/uploadFromUrl`. The request should look like the 
following:

* A `path` field containing an optional path for the file (e.g. `articles/summer`)
* A `url` field containing the URL to the image
* (optional) A `mimeType` field containing the MIME type of the image

Here's an example HTML form that fulfills the requirements:

```html
<form method="post" action="/upload">
  <p>
    <label>Path: <input type="text" name="path"/></label>
  </p>
  <p>
    <label>Image: <input type="file" name="image"/></label>
  </p>
  <!--<p>
    <label>MIME type: <input type="text" name="mimeType"/></label>
  </p>-->
  <p>
    <input type="submit" name="submit" value="Upload image"/>
  </p>
</form>
```

### Authenticating upload requests

By default the service allows anyone to upload images. You can restrict this by configuring a username and 
password in your `.env` file and enabling upload authentication:

```
UPLOAD_AUTHENTICATION_ENABLED=true
UPLOAD_USERNAME=username
UPLOAD_PASSWORD=password
```

### Authenticating image retrieval requests

If you have placed a CDN in front of the service, you may want to restrict image retrieval access to just the CDN. 
This can be done by specifying a list of required custom headers that must be present in requests.

The required headers are configured in `config/app.php`, like this:

```php
<?php

return [
    // Request headers that must be present when requesting images
    'required_custom_headers' => [
        'X-Cdn-Authentication' => 'some secret value',
    ],
];
```

## Development

You can easily test the service by running `php -S localhost:8080 -t public/ public/index.php` from the project root 
directory and browsing to `http://localhost:8080/`.

### Testing

You can run the tests by running `vendor/bin/phpunit`. If you have XDebug installed you can see the code coverage 
report on by opening `public/coverage/index.html` locally in your browser.

You can also use the supplied Postman collection to test image upload requests. Just import the collection and add the 
following variables to your environment:

* `baseUrl` the base URL to the service, e.g. `http://image-manipulation-service.example.com`

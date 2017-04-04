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
stored.
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

To upload a new image through the service, make a `POST` request to `/upload`. The request should the following:

* A `path` field containing an optional path for the file (e.g. `articles/summer`)
* An `image` file field containing the image to be uploaded

Here's an example HTML form that fulfills the requirements:

```html
<form method="post" action="/upload" enctype="multipart/form-data">
  <p>
    <label>Path: <input type="text" name="path"/></label>
  </p>
  <p>
    <label>Image: <input type="file" name="image"/></label>
  </p>
  <p>
    <input type="submit" name="submit" value="Upload image"/>
  </p>
</form>
```

If the request succeeds, a temporary redirect to the image URL will be returned.

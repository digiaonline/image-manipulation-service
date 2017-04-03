# Image manipulation service

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
 
## Architecture

1. A user uploads a profile picture to your application
2. Your application uploads the picture to this service using a `POST` request
3. The original version gets stored somewhere (either locally on the server, or on S3)
4. A redirect to the uploaded image is returned after a successful upload.

The image returned by the service can be manipulated by using query parameters. It is possible to use either a defined 
preset (e.g. `?preset=foo`) or custom parameters (e.g. `?w=400&h=300`). If no query parameters are specified, the 
original image is returned.

The service doesn't store manipulated images anywhere, they are always generated on the fly.

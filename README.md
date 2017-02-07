# Dude.fi
## Website redesign

This is a working copy of the website for [Digitoimisto Dude Oy](https://github.com/digitoimistodude) *(simply "Dude" * a Finnish digital agency)*.

## Table of contents

1. [Background story](#background-story)
  1. [Before GitHub](#before-github)
  2. [What's ignored](#whats-ignored)
2. [Features overview](#features-overview)
3. [Tools and building blocks used](#tools-and-building-blocks-used)
4. [Building instructions](#building-instructions)

![Screenshot](https://dl.dropboxusercontent.com/u/18447700/dude16-optimized2.gif "Screenshot")

## Background story

Dude built their first website when the company was formed in 2013. It was quite simple, but we needed it fast. Next, careful design we released after one year. And it was awesome. However, when things changed and there were suddendly 4 dudes instead of 2 in late 2015, so we started to plan redesigning our website in early 2016.

We made quite a lot of planning in the spring and during the summer we started to work on the redesign. Summer died fast, so obviously got a bit stuck in the fall. When christmas holidays finally came, we continued with the site. Full blast in January, and boom! * the site was finally ready for the public to see.

### Before GitHub

Before releasing the dude.fi code in GitHub, we had a development version in Bitbucket's private repository. This is simply because we were just figuring out the content and all the other stuff so didn't want to have all that lorem ipsum to be viewed in public. Not that it would matter much, but for the cleaner outcome we decided to release the repository *as is*, as soon as the overall package would be ready.

Themes and sites before this version are forever resting in Bitbucket.

### What's ignored?

We have some stuff in [`.gitignore`](https://github.com/digitoimistodude/dude.fi/blob/master/.gitignore), although most of the lines are directly from [dudestack](https://github.com/digitoimistodude/dudestack).

* `.env`, in other words: credentials. All API keys, passwords and other sensitive information are hidden from the world and not included in the repository
* Fonts. We have purchased fonts for about 500 EUR so obviously those and lisences are ignored
* NPM building blocks. Dependencies should not be in upstream so those are ignored.
* Composer dependencies. WordPress and plugin installation files as well as custom-plugin dependencies are ignored in therepository.
* Paid plugins that do not have a composer repo (at least [WP-Rocket](https://wp-rocket.me))

## Features overview

* SASS, HTML, jQuery in the front end
* PHP, WordPress, Vue.js and WP-REST API the in back end
* Carefully selected fonts, responsive typography with viewport units with px fallback
* Built accessibility in mind
* All logos, icons and illustrations are SVGs + optimized with svgo

## Tools and building blocks used

**Dude.fi is based on:**

* [air](https://github.com/digitoimistodude/air) (WordPress starter theme)
  * Sass (SCSS), vanilla JS, jQuery in front end
  * PHP and WordPress in back end
* [dudestack](https://github.com/digitoimistodude/dudestack) (WordPress and composer stack)
 * Composer handling PHP dependencies
 * Passwords, wp-config essentials and salts in .env file
 * Development, staging and production environment settings for WordPress
 * Capistrano templates for deployment in staging and production
* [marlin-vagrant](https://github.com/digitoimistodude/marlin-vagrant) (Local development server)
 * Latest nginx for webserver
 * HHVM with php7 and php5.6 fallback
 * FastCGI
 * Optimizations for local development
* [devpackages](https://github.com/digitoimistodude/devpackages)
 * Gulpfile.js for automated tasks for
  * Compiling, compressing and optimizing SCSS to CSS
  * Compiling JS
  * Syncing browsers and devices with BrowserSync

**On top of these, Dude.fi uses**

* Vue.js
* WP REST API
* BEM-like syntax for CSS
* Viewport units for responsive typography

## Building instructions

Dude.fi is a personal view of the digital agency Dude, but if for some reason you'd want to contribute, here's the building instructions:

1. Clone/fork the repo
2. Run `composer install`
3. Run `npm install`
4. Run `gulp watch`
5. Make changes and send a pull request

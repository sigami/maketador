# Maketador #

WordPress theme based on [underscore.me](http://underscores.me/) and [Bootstrap 3](http://getbootstrap.com).

## What makes it different ? ##

### Principles ###

- Use WordPress filters in favor of less or js
- Use one theme for multiple Bootstrap header types
- Use customizer not theme options page
- Do not try to hide WordPress (use plugins for that)
- Only 2 widget areas (add more with code or plugins)
- Do not reinvent the wheel
- Lightweight

This theme is hosted by [DraooMedia](https://draoomedia.com) it will get auto updated.

### Specifications ##

- Customizer options
  - Header :
    - Header types: Fixed, Static, Normal and Normal Fixed 
    - Logo upload
  - Layout :
    - Types: sidebar-content, content-sidebar, no-sidebar
    - Content and Sidebar size options
    - Full with class
  - Footer : 
    - Footer text
  - Core : 
    - Header Image
    - Display Site Title and Tagline
    - Background Image
- Works with **JetPack Infinite Scroll**    
- Page templates : 
  - FullWidth
  - Inverse Layout  
  - Blank (no title)
  - Blank No Container
- Widget areas : 
  - Sidebar
  - Footer
- Extra image sizes
  - maketador_featured 880x430 px
  - maketador_banner 1200x500 px
- All options are accessible on customizer and saved on theme_mod 
- Child Theme for replacing all files   
- Right to left support [bootstrap-rtl](http://github.com/morteza)
  

## Developer guide ##

To get the juice out of this code you will need to have [Node.js](https://nodejs.org/en/) installed on your system.

Also bower and grunt-cli installed globally.

### Building the theme ###

1. Go to the theme path `maketador/`
1. Run `npm install && bower install `
1. Modify `inc/less/_botswatch.less` to your needs
1. Add extra scripts if necessary on `inc/js` add them to the grunt file to concatenate on the right order
1. Run `grunt build`

Use `grunt watch` to watch changes on files and auto reload browser very useful if your are developing on a local server.

### Font Awesome ###

To include the font library simply create a variables.json and set fa_include to true just like in the examples below

``````json
{
    "test_dir" : "/full-path/to/localhost/wp-content/themes/maketador/",
    "fa_include" : true
}
``````

The test dir is a folder on your computer where the complete theme will get stored if you use the command `grunt dev` 
on every change it will copy the theme with only the important files

Use `grunt zip` to create a zip file with only the essential. Use that file to upload the theme via wp-admin.
  
  
### Created for Child Themes ###

Why create new themes all the time if child themes exists since year 1.

Create a child theme using grunt

`grunt child --slug=my_theme --name="My Theme"`

this will create a new child theme with grunt already installed.

use `grunt clean:dev` to remove the bower_components and node_modules folder.  

## Contribute ##

Create a pull request to the master branch.

## Changelog ##

### 1.0.5 09/08/2016 ###
- Improved css
- Improved template files
- New screenshot

### 1.0.4 31/07/2016 ###
- Stopped trying to upload this theme to the official repo.
- Added custom update api.

### 1.0.3 19/07/2016 ###
- Improved functionality with infinite scroll
- New screenshot


### 1.0.2 14/07/2016 ###
- added with:auto to aliginone class
- screenshot update

### 1.0.1 13/07/2016 ###
- Bug fixes, hard testing, sweat and blood.

### 1.0.0 08/06/2016 ###
- Birth
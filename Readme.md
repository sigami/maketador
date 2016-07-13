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

### Specs ##

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
- All options accessible on customizer and saved on theme_mod 
- Child Theme for replacing all files   
- Right to left support [bootstrap-rtl](http://github.com/morteza)
  

## Developer guide ##

To get the juice out of this code you will need to have [Node.js](https://nodejs.org/en/) installed on your system.

Also bower and grunt-cli installed globally.

Using grunt is just mind blowing. 

If you are not using it, you are missing out on some incredible powers.


### Builder settings ###

1. Go to builder path `cd maketador/`
2. Run `npm install`
3. Run `bower install`
4. Modify `inc/less/main.less` or `inc/less/botswatch.less` to your needs
5. Add extra scripts if necessary on `inc/js`
6. Run `grunt build`

Use `grunt watch` to watch changes on files and auto reload browser very useful if your are developing on a local server.

To automatically copy your changes to a test folder or add font awesome to your theme first create a **variables.json** file like this:

``````json
{
    "test_dir" : "/full-path/to/localhost/wp-content/themes/maketador/",
    "fa_include" : true
}
``````

Then ese `grunt dev` copy all changed files to your test folder and reload the browser

Use `grunt zip` to create a zip file with only the essential. Use that file to upload the theme via wp-admin.
  
  
### Created for Child Themes ###

Why create new themes all the time if child themes exists since year 0.

Create a child theme using grunt

`grunt child --slug=my_theme --name="My Theme"`

this will create a new child theme with grunt already installed.

use `grunt clean:dev` to remove the bower_components and node_modules folder.  

## Contribute ##

Create a pull request to the master branch.

## Changelog ##

### 1.0.1 13/07/2016 ###
- Bug fixes, hard testing, sweat and blood.

### 1.0.0 08/06/2016 ###
- Birth
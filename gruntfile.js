'use strict';
module.exports = function (grunt) {
    var child_slug = grunt.option('slug') || 'maketador_child';
    var child_name = grunt.option('name') || child_slug;
    var child_path = grunt.option('path') || '../';
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        vars: grunt.file.readJSON('variables.json'),
        jshint: {
            options: {
                jshintrc: '.jshintrc'
            },
            all: [
                'bower_components/bootstrap/js/*.js',
                'inc/js/*.js'
            ]
        },
        less: {
            dist: {
                files: {
                    'dist/css/main.min.css': [
                        'inc/less/main.less'
                    ]
                },
                options: {
                    compress: true,
                    sourceMap: true,
                    outputSourceFiles: true
                }
            }
        },
        concat: {
            options: {
                separator: ';\n',
                sourceMap: true
            },
            dist: {
                src: [
                    'bower_components/bootstrap/dist/js/bootstrap.js',
                    'inc/js/skip-link-focus-fix.js',
                    'inc/js/maketador.js'
                ],
                dest: 'dist/js/main.js'
            }
        },
        uglify: {
            dist: {
                files: {
                    'dist/js/main.min.js': ['dist/js/main.js']
                },
                options: {
                    sourceMap: false
                }
            }
        },
        watch: {
            less: {
                files: [
                    'bower_components/bootstrap/less/*.less',
                    //'bower_components/font-awesome/less/*.less',
                    'inc/less/*.less'
                ],
                tasks: ['less']
            },
            js: {
                files: [
                    '<%= jshint.all %>'
                ],
                tasks: ['jshint', 'concat', 'uglify']
            },
            livereload: {
                options: {
                    livereload: true
                },
                files: [
                    'dist/**',
                    '*.php',
                    'inc/js/*.js',
                    'inc/*.php'
                ]
            }
        },
        copy: {
            options: {force: true},
            rtl: {
                src: 'bower_components/bootstrap-rtl/dist/css/bootstrap-rtl.min.css',
                dest: 'rtl.css'
            },
            bs_fonts: {
                expand: true,
                flatten: true,
                nonull: true,
                src: ['bower_components/bootstrap/fonts/*'],
                dest: 'dist/fonts/'
            },
            test: {
                dest: '<%= vars.test_dir %>',
                expand: true,
                //nonull: true,
                //cwd: '<%= pkg.name %>/',
                src: [
                    '**',
                    '!node_modules/**',
                    '!bower_components/**',
                    '!svn/**',
                    '!.gitignore',
                    '!.git'
                ]
            },
            child: {
                dest: child_path + child_slug + '/',
                expand: true,
                //cwd: '../../',
                src: [
                    'inc/js/**',
                    'inc/less/**',
                    'dist/**',
                    'bower_components/**',
                    'node_modules/**',
                    '!svn/**',
                    'languages',
                    '.gitignore',
                    'bower.json',
                    'gruntfile.js',
                    'package.json',
                    'variables.json'
                ]
            },
            //TODO change slug on bower,gruntfile,package,variables
            child_functions: {
                src: 'functions.php',
                dest: child_path + child_slug + '/',
                expand: true,
                flatten: true,
                nonull: true,
                options: {
                    process: function () {
                        return "" +
                            "<?php" + "\n" +
                            "/* Enqueue scripts and styles */" + "\n" +
                            "function maketador_child_scripts() {" + "\n" +
                            "   wp_dequeue_style('maketador-style');" + "\n" +
                            "   wp_dequeue_script('maketador-script');" + "\n" +
                            "   wp_enqueue_style( '" + child_slug + "-style', get_stylesheet_directory_uri() . '/main.min.css'  );" + "\n" +
                            "   wp_enqueue_script( '" + child_slug + "-script', get_stylesheet_directory_uri() . '/js/main.min.js',array('jquery'),'1.0');" + "\n" +
                            "}" + "\n" +
                            "add_action( 'wp_enqueue_scripts', 'maketador_child_scripts',11 );\n";
                    }
                }
            },
            child_style: {
                src: 'style.css',
                dest: child_path + child_slug + '/',
                options: {
                    process: function () {
                        return "" +
                            "/*" + "\n" +
                            "Theme Name: " + child_name + "\n" +
                            "Theme URI: \n" +
                            "Author: \n" +
                            "Author URI: \n" +
                            "Description: \n" +
                            "Version: 1.0 \n" +
                            "Template: maketador " + "\n" +
                            "Text Domain: " + child_slug + "\n" +
                            "*/\n";
                    }

                }
            }
        },
        clean: {
            options: {force: true},
            dist: [
                'dist/fonts/*',
                'dist/css/*',
                'dist/js/*'
            ],
            js_css: [
                'dist/css/*',
                'dist/js/*'
            ],
            rtl: [ 'rtl.css' ],
            child: [
                '../' + child_slug + '/**'
            ],
            dev: [
                'bower_components/**',
                'node_modules/**',
                'svn/**'
            ],
            zip: ['../<%= pkg.name %>.zip'],
            test: [
                '<%= vars.test_dir %>'
            ]
        },
        makepot: {
            target: {
                options: {
                    domainPath: 'languages',                   // Where to save the POT file.
                    exclude: ['node_modules', '.sass-cache', 'bower_components', 'svn'],// List of files or directories to ignore.
                    include: [],                      // List of files or directories to include.
                    mainFile: 'style.css',                     // Main project file.
                    potComments: '',                  // The copyright at the beginning of the POT file.
                    potFilename: '<%= pkg.name %>.pot',                  // Name of the POT file.
                    potHeaders: {
                        poedit: true,                 // Includes common Poedit headers.
                        'x-poedit-keywordslist': true, // Include a list of all possible gettext functions.
                        'last-translator': '<%= pkg.author %>',
                        'language-team': '<%= pkg.author %>',
                        'X-Poedit-Basepath': '..',
                        'X-Poedit-SearchPathExcluded-0': '*.js',
                        'X-Poedit-WPHeader': 'style.css'
                    },                                // Headers to add to the generated POT file.
                    processPot: null,                 // A callback function for manipulating the POT file.
                    type: 'wp-theme',                // Type of project (wp-plugin or wp-theme).
                    updateTimestamp: false,            // Whether the POT-Creation-Date should be updated without other changes.
                    updatePoFiles: false              // Whether to update PO files in the same directory as the POT file.
                }
            }
        },

        compress: {
            theme: {
                options: {
                    archive: '../<%= pkg.name %>.zip'
                },
                expand: true,
                dest: '<%= pkg.name %>/',
                src: [
                    '**',
                    '!.gitignore',
                    '!.git/**',
                    '!bower_components/**',
                    '!node_modules/**',
                    '!svn/**'
                ]
            }
        }
    });

    // Load tasks
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-wp-i18n');
    grunt.loadNpmTasks('grunt-contrib-concat');

    grunt.loadNpmTasks('grunt-contrib-compress');

    var fa_include = grunt.config.get('vars.fa_include');

    if (fa_include) {
        grunt.config.set('less.dist.files', {
            'dist/css/main.min.css': [
                'inc/less/main.less',
                'bower_components/font-awesome/less/font-awesome.less'
            ]
        });
        grunt.config.set('copy.bs_fonts.src',
            [
                'bower_components/bootstrap/fonts/*',
                'bower_components/font-awesome/fonts/*'
            ]
        );
    }

    // Register tasks
    grunt.registerTask('default', [
        'clean:js_css',
        'less',
        'concat',
        'uglify',
        'makepot'
    ]);

    grunt.registerTask('build', [
        'clean:dist',
        'clean:rtl',
        'less',
        'concat',
        'uglify',
        'copy:rtl',
        'copy:bs_fonts',
        'makepot'
    ]);

    grunt.registerTask('dev',function(){

        var live = grunt.config.get('watch.livereload');
        grunt.config.set('watch',{
            test: {
                files: ['<%= copy.test.src  %>'],
                tasks: ['copy:test']
            },
            livereload: live
        });

        grunt.task.run(['clean:test','copy:test','watch']);

    });

    grunt.registerTask('zip', [
        'build',
        'clean:zip',
        'compress'
    ]);

    grunt.registerTask('child', [
        'clean:child',
        'copy:child',
        'copy:child_style',
        'copy:child_functions'
    ]);
};

var grunt = require('grunt'),
    dotenv = require('dotenv'),
    btoa = require('btoa');

module.exports = function() {

  dotenv.load();

  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-jade');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-angular-templates');

  var vendor_js = [
    'bower_components/angular/angular.js',
    'bower_components/angular-resource/angular-resource.js',
    'bower_components/angular-route/angular-route.js'
  ];

  grunt.initConfig({

    clean: {
      all: [
        'obj', 
        'public/js', 
        'public/css', 
        'public/index.html',
      ]
    },

    coffee: {
      src: {
        options: {
          bare: true,
          join: true
        },
        files: {
          'obj/js/app.js': [
            'src/coffee/module.coffee', 
            'src/coffee/**/*.coffee'
          ]
        }
      }
    },

    jade: {
      index: {
        files: {
          'public/index.html': 'src/jade/index.jade'
        }
      },
      release: {
        options: { 
          data: {
            release: true
          },
        },
        files: {
          'public/index.html': 'src/jade/index.jade'
        }
      },
      templates: {
        files: [{
          src: "**/*.jade",
          dest: "obj/html",
          expand: true,
          ext: ".html",
          cwd: "src/jade"
        }]
      }
    },

    ngtemplates: {
      build: {
        src: ['obj/html/directives/*.html', 'obj/html/views/*.html'],
        dest: 'obj/js/templates.js',
        options: {
          module: 'djh',
          url: function(url) { 
            return url.replace(/^obj\/html\/(.*)\/(.*)\.html$/,'$1.$2');
          }
        }
      }
    },

    concat: {
      options: {
        separator: ';',
      },
      dist: {
        src: vendor_js.concat([
          'obj/js/app.js', 
          'obj/js/**/*.js'
        ]),
        dest: 'public/js/app.js'
      }
    },

    copy: {
      svg: {
        expand: true,
        cwd: 'src/svg',
        src: '**/*.svg',
        dest: 'public/svg'
      },
      index: {
        files: [{
          expand: true,
          cwd: 'obj/html',
          src: 'index.html',
          dest: 'public/'
        }]
      }
    },

    watch: {
      svg: {
        files: ['src/svg/*.svg'],
        tasks: ['copy:svg']
      },
      scripts: {
        files: ['src/coffee/**/*.coffee'],
        tasks: ['js']
      },
      index: {
        files: ['src/jade/index.jade'],
        tasks: ['jade:index']
      },
      templates: {
        files: ['src/jade/**/*.jade'],
        tasks: ['js']
      },
      sass: {
        files: ['src/sass/**/*.sass'],
        tasks: ['sass']
      }
    },

    sass: {
      build: {
        options: {
          loadPath: require('node-neat').includePaths
        },
        files: {
          'public/css/app.css': 'src/sass/app.sass'
        }
      }
    },

    uglify: {
      release: {
        files: {
          'public/js/app.min.js': ['public/js/app.js']
        }
      }
    }

  });
  
  grunt.registerTask('js', ['coffee', 'jade:templates', 'ngtemplates', 'concat']);
  grunt.registerTask('css', ['sass']);
  grunt.registerTask('default', ['css', 'coffee', 'js', 'css', 'copy']);
  grunt.registerTask('release', ['default', 'jade:release', 'uglify']);

}

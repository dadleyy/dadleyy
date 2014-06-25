var grunt = require('grunt');

module.exports = function() {

  var task_packages = [
    'grunt-contrib-sass',
    'grunt-contrib-watch',
    'grunt-contrib-coffee',
    'grunt-contrib-concat',
    'grunt-contrib-clean',
    'grunt-contrib-jade',
    'grunt-angular-templates'
  ];

  for(var i = 0; i < task_packages.length; i++) {
    grunt.loadNpmTasks(task_packages[i]);
  }

  function jadeFiles(srcdir, destdir, wildcard) {
    var path = require('path'),
        files = {};

    grunt.file.expand({cwd: srcdir}, wildcard).forEach(function(relpath) {
      destname = relpath.replace(/\.jade$/ig,'.html');
      files[path.join(destdir, destname)] = path.join(srcdir, relpath);
    });

    return files;
  }

  grunt.initConfig({

    clean: {
      obj: ['assets/obj'],
      dist: ['public/js', 'public/css']
    },

    sass: {
      build: {
        options: {
          loadPath: require('node-neat').includePaths
        },
        files: {
          'public/css/application.css': 'assets/sass/app.sass'
        }
      }
    },

    jade: {
      debug: {
        files: jadeFiles('assets/jade', 'assets/obj/html', '**/*.jade')
      }
    },

    ngtemplates: {
      build: {
        src: ['assets/obj/html/directives/**/*.html', 'assets/obj/html/views/*.html'],
        dest: 'assets/obj/js/templates.js',
        options: {
          module: 'djh',
          url: function(url) { 
            return url.replace(/^assets\/obj\/html\/(.*)\.html$/,'$1').replace(/\//g, '.');
          }
        }
      }
    },

    coffee: {
      src: {
        options: {
          bare: true,
          join: true
        },
        files: {
          'assets/obj/js/app.js': ['assets/coffee/module.coffee', 'assets/coffee/**/*.coffee']
        }
      }
    },

    concat: {
      dist: {
        src: [
          'bower_components/angular/angular.js', 
          'bower_components/angular-route/angular-route.js', 
          'bower_components/angular-resource/angular-resource.js', 
          'bower_components/d3/d3.js', 
          'assets/obj/js/app.js', 
          'assets/obj/js/templates.js'
        ],
        dest: 'public/js/application.js',
      },
    },

    watch: {
      style: {
        files: ['assets/**/*.sass'],
        tasks: ['sass']
      },
      scripts: {
        files: ['assets/**/*.coffee'],
        tasks: ['coffee', 'concat']
      },
      html: {
        files: ['assets/**/*.jade'],
        tasks: ['jade', 'ngtemplates', 'concat']
      }
    }

  });

  grunt.registerTask('default', ['clean','coffee','jade', 'ngtemplates','concat','sass']);

}

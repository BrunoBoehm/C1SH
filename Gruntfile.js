// Load Grunt
module.exports = function (grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
               
        // Tasks

        /**
         * Sass
         */
        sass: {
            dev: {
                options: {
                    style: 'expanded',
                    sourcemap: 'none',
                },
                files: {
                    'compiled/style-human.css': 'sass/style.scss'
                            // target                   // source
                }
            },
            dist: {
                options: {
                    style: 'compressed',
                    sourcemap: 'none',
                },
                files: {
                    'compiled/style.css': 'sass/style.scss'
                }
            }		  
        },

        /**
         * Postcss + Autoprefixer
         */
        postcss: { 
            // Begin Post CSS Plugin
            options: {
              map: false,
              processors: [
                  require('autoprefixer')({ browsers: ['last 2 versions'] })
              ]
            },
            // prefix all files
            multiple_files: {
                expand: true,
                flatten: true,
                src: 'compiled/*.css',
                dest: ''
            }
          },
          
        /**
         * Watch
         */
        watch: {
            css: {
                files: '**/*.scss',
                tasks: ['sass', 'postcss']
            }
        },

    });
    
	// Load Grunt plugins
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-contrib-watch');
    //  grunt.loadNpmTasks('grunt-contrib-cssmin');
    //  grunt.loadNpmTasks('grunt-contrib-uglify');

	// Register Grunt tasks
	grunt.registerTask('default', ['watch']);
};

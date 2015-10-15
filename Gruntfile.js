module.exports = function(grunt) {

  grunt.loadNpmTasks("grunt-contrib-watch");
  grunt.loadNpmTasks("grunt-contrib-compass");
  grunt.loadNpmTasks("grunt-autoprefixer");

  grunt.initConfig({

    autoprefixer: {
      css: {
        src: './**/*.css'
      }
    },

    compass: {
      dev: {
        options: {
          config: 'config.rb'
        }
      }
    },


    watch: {
      options: {
        livereload: true
      },
      
      sass: {
        files: ['sass/**/*.scss'],
        tasks: ['compass:dev', 'autoprefixer:css'] 
      },

      php: {
        files: ['**/*.php'],
        options: {
          livereload: 35729
        }
      },
    
    } // watch

  }); // initConfig
  
  grunt.registerTask('compile-sass', ['compass:dev']);
  grunt.registerTask('default', ['watch']);

}; // exports


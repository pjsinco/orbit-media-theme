module.exports = function(grunt) {

  grunt.loadNpmTasks("grunt-contrib-watch");
  grunt.loadNpmTasks("grunt-contrib-compass");
  grunt.loadNpmTasks("grunt-autoprefixer");
  grunt.loadNpmTasks("grunt-notify");

  grunt.initConfig({
    notify: {
        sass: {
            options: {
                title: 'Sass',
                message: 'Sassed!'
            } 
        },
    },

    autoprefixer: {
      css: {
        src: './**/*.css'
      }
    },

    compass: {
      dev: {
        options: {
          config: 'config.rb',
          specify: ['sass/default.scss', 'sass/layout.scss']
        }
      }
    },


    watch: {
        sass: {
            files: ['sass/**/*.scss'],
            tasks: ['compass:dev', 'autoprefixer:css', 'notify:sass'] 
        },
    },


  }); // initConfig
  
  grunt.registerTask('compile-sass', ['compass:dev']);
  grunt.registerTask('default', ['watch']);

}; // exports


module.exports = function(grunt) {
	grunt.initConfig({
		less: {
			development: {
				options: {
					paths: ["static/css"]
				},
				files: {
				}
			},
			production: {
				options: {
					paths: ["static/css"],
					cleancss: true
				},
				files: {
					"public/resource/css/common.css": "public/resource/css/less/common.less",
					"public/resource/css/common-tablet.css": "public/resource/css/less/common-tablet.less",
					"public/resource/css/common-sphone.css": "public/resource/css/less/common-sphone.less",
					"public/resource/css/top.css": "public/resource/css/less/top.less",
					"public/resource/css/top-tablet.css": "public/resource/css/less/top-tablet.less",
					"public/resource/css/top-sphone.css": "public/resource/css/less/top-sphone.less",
				}
			},
		},
		concat: {
			options: {
			},
			dist: {
			},
		},
		clean: {
			build: {
			}
		},
	});
	grunt.loadNpmTasks("grunt-contrib-less");
	grunt.loadNpmTasks("grunt-contrib-concat");
	grunt.loadNpmTasks("grunt-contrib-clean");
	grunt.registerTask("default", ["less", "concat", "clean"]);
};

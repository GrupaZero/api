var gulp = require('gulp'),
    apidoc = require('gulp-apidoc');

gulp.task('apidoc', apidoc.exec({
    src: "src/",
    dest: "docs/"
}));

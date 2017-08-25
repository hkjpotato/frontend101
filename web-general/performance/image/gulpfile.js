const gulp = require('gulp');
const imagemin = require('gulp-imagemin');
 
gulp.task('default', () =>
    gulp.src('src/*')
        .pipe(imagemin())
        .pipe(gulp.dest('dist'))
);
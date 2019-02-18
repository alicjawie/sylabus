var gulp = require('gulp');
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var sassFiles = 'src/AppBundle/Resources/app/scss/*.scss';
var cssDest = 'src/AppBundle/Resources/public/css/';

gulp.task('sass', function(){
  return gulp.src(sassFiles)
    .pipe(sass())
    .pipe(gulp.dest(cssDest));
});

gulp.task('watch',function() {
    gulp.watch(sassFiles,['sass']);
});
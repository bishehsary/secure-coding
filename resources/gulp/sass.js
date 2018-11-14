const gulp = require('gulp');
const sass = require('gulp-sass');
const map = require('gulp-sourcemaps');

module.exports = function (dir, setting) {

    gulp.task('sass:compile', function () {
        let stream = gulp.src([`${dir.src}/scss/app.scss`]),
            genMap = !setting.production;
        if (genMap) stream = stream.pipe(map.init());
        stream = stream.pipe(sass()).on('error', setting.error);
        if (genMap) stream = stream.pipe(map.write());
        return stream.pipe(gulp.dest(`${dir.build}/css`));
    });

    gulp.task('sass:watch', function () {
        return gulp.watch(dir.src + '/scss/**/*.scss', ['sass:compile']);
    });

    return {
        tasks: ['sass:compile'],
        watch: ['sass:watch']
    };
};
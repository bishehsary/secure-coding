const gulp = require('gulp');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');

module.exports = function (dir, setting) {

    gulp.task('asset:lib', function () {
        let libs = [
            `${dir.npm}/jquery/dist/jquery.js`,
            `${dir.npm}/bootstrap/dist/js/bootstrap.js`,
            `${dir.src}/highlight/highlight.pack.js`
        ];
        let stream = gulp.src(libs).pipe(concat('lib.js'));
        if (setting.production) {
            stream = stream.pipe(uglify());
        }
        return stream.pipe(gulp.dest(dir.build + '/js/'));
    });
    gulp.task('asset:js', function () {
        return gulp.src([
            `${dir.src}/scripts/**/*.js`
        ]).pipe(concat('app.js'))
            .pipe(gulp.dest(dir.build + '/js'));
    });
    gulp.task('asset:css', function () {
        return gulp.src([
            `${dir.npm}/bootstrap/dist/css/bootstrap.css`,
            `${dir.npm}/bootstrap/dist/css/bootstrap-theme.css`
        ]).pipe(concat('lib.css'))
            .pipe(gulp.dest(dir.build + '/css'));
    });
    gulp.task('asset:font', ['asset:css'], function () {
        return gulp.src([
            `${dir.npm}/bootstrap/dist/fonts/*`,
            `${dir.src}/fonts/**/*`
        ])
            .pipe(gulp.dest(dir.build + '/fonts'));
    });

    gulp.task('asset:image', function () {
        gulp.src(dir.src + '/images/**/*')
            .pipe(gulp.dest(dir.build + '/img'));
    });

    gulp.task('asset:watch', function () {
        gulp.watch([`${dir.src}/images/**/*`], ['asset:image']);
        gulp.watch([`${dir.src}/scripts/**/*.js`], ['asset:js']);
    });

    return {
        watch: ['asset:watch'],
        tasks: ['asset:lib', 'asset:font', 'asset:image', 'asset:js']
    };
};
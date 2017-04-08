let gulp = require('gulp'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    postCss = require('gulp-postcss'),
    autoPrefixer = require('autoprefixer'),
    csswring = require('csswring'),
    mqpacker = require('css-mqpacker'),
    reporter = require('postcss-reporter'),
    stylelint = require('stylelint'),
    doiuse = require('doiuse');

module.exports = function (dir, setting) {

    let tmpDirectory = setting.production ? dir.build + '/tmp/css' : dir.build + '/css';

    gulp.task('sass:compile', function () {
        let stream = gulp.src([dir.src + '/scss/app.scss']),
            genMap = !setting.production;
        if (genMap) stream = stream.pipe(sourcemaps.init());
        stream = stream.pipe(sass()).on('error', setting.error);
        if (genMap) stream = stream.pipe(sourcemaps.write());
        return stream.pipe(gulp.dest(tmpDirectory));
    });

    let browsersToSupport = [
        'last 2 version',
        'iOS >= 7',
        'Android >= 4',
        'Explorer >= 10',
        'ExplorerMobile >= 11'];

    gulp.task('sass:postCss', ['sass:compile'], function () {
        let preprocessors = [autoPrefixer({browsers: browsersToSupport})];
        if (setting.production) {
            preprocessors.push(mqpacker);
            preprocessors.push(csswring);
            return gulp.src(tmpDirectory + '/*.css')
                .pipe(postCss(preprocessors))
                .on('error', setting.error)
                .pipe(gulp.dest(dir.build + '/css'))
        }
    });

    gulp.task('sass:analyse', ['sass:compile'], function () {
        let preprocessors = [
            autoPrefixer({browsers: browsersToSupport}),
            stylelint(),
            doiuse({browsers: browsersToSupport}),
            reporter()
        ];

        return gulp.src(tmpDirectory + '/!*.css')
            .pipe(postCss(preprocessors))
            .on('error', setting.error)
            .pipe(gulp.dest(tmpDirectory + '/analyze'))
    });

    gulp.task('sass:watch', function () {
        return gulp.watch(dir.src + '/scss/**/*.scss', ['sass:postCss']);
    });

    return {
        tasks: ['sass:postCss'],
        watch: ['sass:watch']
    };
};
let gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    // htmlmin = require('gulp-htmlmin'),
    // imageop = require('gulp-image-optimization'),
    fse = require('fs-extra');

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

    // gulp.task('asset:image:optimize', function () {
    //     let stream = gulp.src(dir.src + '/images/**/*');
    //     if (setting.production) {
    //         stream = stream.pipe(imageop({
    //             optimizationLevel: 5,
    //             progressive: true,
    //             interlaced: true
    //         })).on('error', setting.error);
    //     }
    //     return stream.pipe(gulp.dest(tmpDirectory));
    // });

    gulp.task('asset:watch', function () {
        gulp.watch([dir.src + '/images/**/*'], ['asset:image']);
    });

    return {
        watch: ['asset:watch'],
        tasks: ['asset:lib', 'asset:font', 'asset:image']
    };

    function minifyHtml(stream) {
        return stream.pipe(htmlmin({
            removeComments: true,
            collapseWhitespace: true,
            conservativeCollapse: true,
            collapseBooleanAttributes: true,
            keepClosingSlash: true
        }))
    }

    function findInFileAndReplace(file, search, replace) {
        try {
            if (!fse.existsSync(file)) return;
            let content = fse.readFileSync(file, {encoding: 'utf8'});
            content = content.replace(search, replace);
            fse.writeFileSync(file, content);
        } catch (e) {
            console.error(e.message);
        }
    }

    function getDate() {
        let d = new Date();
        return `${d.getFullYear()}/${d.getMonth() + 1}/${d.getDate()} ${d.getHours()}:${d.getMinutes()}`;
    }
};
let gulp = require('gulp');
let php = require('gulp-connect-php');
let browserSync = require('browser-sync');
let path = require('path');

const root = path.join(__dirname, '../..');
const delay = 1000;
let reload = browserSync.reload;
let timer;

gulp.task('php', function () {
    php.server({base: root, port: 8010, keepalive: true});
});

gulp.task('browser-sync', ['php'], function () {
    browserSync({
        proxy: 'sc.io:8010',
        host: 'sc.io',
        https: true,
        port: 443,
        open: true,
        notify: false
    });
});

gulp.task('reload', () => {
    clearTimeout(timer);
    timer = setTimeout(reload, delay);
});

gulp.task('default', ['browser-sync'], function () {
    gulp.watch(['../../App/**/*', '!../../App/asset/**/*', '../../asset/**/*'], ['reload']);
});
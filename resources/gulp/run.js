let gulp = require('gulp');
let php = require('gulp-connect-php');
let browserSync = require('browser-sync');
let path = require('path');
let reload = browserSync.reload;
const root = path.join(__dirname, '../..');
const delay = 1000;
let timer;

gulp.task('php', function () {
    php.server({base: root, port: 8010, keepalive: true});
});

gulp.task('browser-sync', ['php'], function () {
    browserSync({
        proxy: '127.0.0.1:8010',
        port: 8088,
        open: true,
        notify: false
    });
});

gulp.task('reload', () => {
    clearTimeout(timer);
    timer = setTimeout(reload, delay);
});

gulp.task('default', ['browser-sync'], function () {
    gulp.watch(['../../App/**/*', '../../asset/**/*'], ['reload']);
});
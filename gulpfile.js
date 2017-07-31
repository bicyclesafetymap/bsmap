var gulp        = require("gulp");
var loadPlugins = require('gulp-load-plugins');
var $           = loadPlugins();
var browserSync = require("browser-sync");
var del         = require('del');
var gutil       = require('gulp-util');

// base config
var paths = {
    vhost:   "bs-bicyclemap",
    db:      "bs_bicyclemap_db",
    port:     1060,
    rootDir: "htdocs/",
    cmnDir:  "htdocs/cmn/",
    //cmnDir: "htdocs/wp-content/themes/fusion/cmn/", //Wordpressテーマ時cmn
    viewDir: "fuel/app/views/**/*.php",
    classDir: "fuel/app/classes/**/*.php",
    html:    "htdocs/**/*.html",
    php:     "htdocs/**/*.php"
};

// base src
var src = {
    scss:       paths.cmnDir + "scss/**/*.scss",
    js:         paths.cmnDir + "js/*.js",
    jsDev:      paths.cmnDir + "js/dev/*.js",
    jsConcat:   paths.cmnDir + "js/dev-concat/*.js",
    img:        paths.cmnDir + "img/**/*",
    css:        paths.cmnDir + "css/*.css",
    cssMap:     paths.cmnDir + "css/*.map",
    mapJs:      paths.cmnDir + "map/js/*.js"
};

// setting prefix browsers
var prefixBrowsers = [
    'ie >= 8',
    'ie_mob >= 8',
    'ff >= 30',
    'chrome >= 34',
    'safari >= 7',
    'opera >= 23',
    'ios >= 6',
    'android >= 4.4',
    'bb >= 10'
];

var WordPressWatchConfig = [
    "!" + paths.rootDir + "wp-content/**/*",
    "!" + paths.rootDir + "wp-admin/**/*",
    "!" + paths.rootDir + "wp-includes/**/*",
    "!" + paths.rootDir + "wp-*.php",
    "!" + paths.rootDir + "readme.html",
    paths.rootDir + "wp-content/themes/**/*",
    paths.rootDir + "wp-config.php"
];

// browser-sync option
function bsinit(path, port, open, uiport){
    path = path || paths.vhost;
    port = port || paths.port;
    open = open || false;

    browserSync.init({
        proxy:  path,
        port:   port, // Port 1024 ~ 65535
        logPrefix: paths.vhost,// Console logging prefix
        open:   open, // Option : true, false, "external", "tunnel"
        reloadOnRestart: true,
        snippetOptions: {
          //ignorePaths: "fuel/app/logs/**/*.php",
        },
        //startPath: "/history/",// base open directory
        ui: false,
        notify: false, //popup delete
        scrollProportionally: false, // Sync viewports to TOP position
        ghostMode: {
            // clicks: false,f
            // forms: false,
            scroll: false
        }
    });
}

// setting local server
gulp.task("bs-init", function(){
    bsinit();
});

gulp.task("bs-init-live", function(){
    bsinit('192.168.67.21', '1065');
});

// error notify
function notify(){
    return $.notify.onError({
        message: 'Error: <%= error.message %>',
        title:   'Error running something',
        sound:   'Glass'
    });
}

// browser sync
gulp.task("bs-reload", function() {
    browserSync.reload();
});

// file cached
function cached(task){ return $.cached(task);}

// gulp-using
function using(){ return $.using();}

// Sass
gulp.task('sass', function() {
    return gulp.src(src.scss)
    .pipe($.sourcemaps.init())
    .pipe($.sass({
        outputStyle: 'compact' // Values: nested, expanded, compact, compressed
    }))
    .on("error", notify())
    .pipe($.autoprefixer({
        autoprefixer: { browsers: prefixBrowsers}
    }))
    .pipe($.sourcemaps.write("./"))
    .pipe(gulp.dest(paths.cmnDir + "css"))
    // .pipe(browserSync.stream());
});

// sass-dev
gulp.task('sass-dev', function() {
    return gulp.src(src.scss)
    .pipe($.sourcemaps.init())
    .pipe($.sass({
        outputStyle: 'compact' // Values: nested, expanded, compact, compressed
    }))
    .on("error", notify())
    .pipe($.autoprefixer({
        autoprefixer: { browsers: prefixBrowsers}
    }))
    .pipe($.sourcemaps.write("./"))
    .pipe(gulp.dest(paths.cmnDir + "css"))
    // .pipe(browserSync.stream());
});

// Js Mini
gulp.task('jsmin', function() {
    return gulp.src(src.jsDev)
    .on("error", notify())
    .pipe($.uglify())
    .pipe(gulp.dest(paths.cmnDir +'js'));
});

// jsmin-concat
gulp.task('jsmin-concat', function() {
  return gulp.src(src.jsConcat)
  .on("error", notify())
    .pipe($.uglify())
    .pipe($.concat('map-plugin.js'))
    .pipe(gulp.dest(paths.cmnDir +'js'));
});

// Directory watch
gulp.task('watch', function () {
    gulp.watch(src.scss, ["sass"]);
    gulp.watch(src.jsDev, ['jsmin']);
    gulp.watch(src.jsConcat, ['jsmin-concat']);
    gulp.watch([paths.html, paths.php, src.css, src.js, src.img, WordPressWatchConfig] ,['bs-reload']);
});

// Directory watch
gulp.task('watch-dev', function () {
    gulp.watch(src.scss, ["sass-dev"]);
    gulp.watch(src.jsDev, ['jsmin']);
    gulp.watch(src.jsConcat, ['jsmin-concat']);
    gulp.watch([paths.html, paths.php, paths.viewDir, paths.classDir, src.js, src.mapJs, src.img, src.css, WordPressWatchConfig] ,['bs-reload']);
});

// gulpfile watch
var spawn = require('child_process').spawn;
    gulp.task('default', function() {
        var process;
        function restart() {
            if (process) {
              process.kill();
            }
            process = spawn('gulp', ['default-task'], {stdio: 'inherit'});
        }
    gulp.watch('gulpfile.js', restart);
    restart();
});

// gulpfile watch
var spawn = require('child_process').spawn;
    gulp.task('dev', function() {
        var process;
        function restart() {
            if (process) {
              process.kill();
            }
            process = spawn('gulp', ['dev-task'], {stdio: 'inherit'});
        }
    gulp.watch('gulpfile.js', restart);
    restart();
});

gulp.task('gulp-start', function () {
    $.run('echo Gulp Start').exec()
    .pipe($.notify({
        message: 'Gulp Start',
        sound: 'Glass'
    }));
});


gulp.task('db-dump', function () {
    $.run('mysqldump -h 127.0.0.1 -u root -plocal ' + paths.db + ' > sql/' + paths.db + '_`date +%Y-%m-%d`.sql').exec();
});


// clean
gulp.task('clean', del.bind(null,
    [
        src.cssMap
    ]
));

// default task
gulp.task("default-task", [
    "gulp-start",
    "clean",
    "sass",
    "jsmin",
    "bs-init",
    "watch"
]);

// dev task
gulp.task("dev-task", [
    "gulp-start",
    "clean",
    "sass-dev",
    "bs-init",
    "watch-dev"
]);

// dev task
gulp.task("live", [
    "gulp-start",
    "clean",
    "sass-dev",
    "bs-init-live",
    "watch-dev"
]);

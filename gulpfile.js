var postcss = require("gulp-postcss");
var gulp = require("gulp");
var autoprefixer = require("autoprefixer");
var cssnano = require("gulp-cssnano");
var rename = require("gulp-rename");
var concat = require("gulp-concat");
var uglify = require("gulp-uglify");
var sass = require("gulp-sass");
var sourcemaps = require("gulp-sourcemaps");
var browserSync = require("browser-sync").create();

gulp.task("postcss", function () {
  return gulp
    .src("./style.css")
    .pipe(sourcemaps.init())
    .pipe(postcss([autoprefixer(
      "last 2 version",
      "safari 5",
      "ie 8",
      "ie 9",
      "opera 12.1",
      "ios 6",
      "android 4"
    )]))
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest("."));
});

gulp.task("sass", function () {
  return gulp
    .src("./sass/style.scss")
    .pipe(sourcemaps.init())
    .pipe(sass().on("error", sass.logError))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest("./"));
});

gulp.task("browser-sync", function () {
  browserSync.init(["./style.css", "./js/*.js"], {
    proxy: "http://localhost/wordpress"
  });
});

gulp.task("cssnano", function () {
  return gulp
    .src("./style.css")
    .pipe(cssnano())
    .pipe(
      rename({
        suffix: ".min"
      })
    )
    .pipe(gulp.dest("./"));
});

gulp.task("combine-js", function () {
  return gulp
    .src(["./js/**/*.js"])
    .pipe(concat("bundle.js"))
    .pipe(gulp.dest("./js"))
    .pipe(
      uglify({
        mangle: true
      })
    )
    .pipe(rename("bundle.min.js"))
    .pipe(gulp.dest("./js"));
});

gulp.task("default", ["sass", "browser-sync"], function () {
  gulp.watch("./sass/**/*.scss", ["sass"]);
  gulp.watch("index.php").on("change", browserSync.reload);
  gulp.watch("./**/*.php").on("change", browserSync.reload);
  gulp.watch("./js/**/*.js").on("change", browserSync.reload);
});

gulp.task("production", ["postcss", "cssnano", "combine-js"]);
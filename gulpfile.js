/*!
 * gulp
 * $ npm install del gulp-autoprefixer gulp-cache gulp-concat gulp-imagemin gulp-insert gulp-jshint gulp-livereload gulp-load-plugins gulp-minify-css gulp-notify gulp-plumber gulp-pxtorem gulp-rename gulp-replace gulp-sass gulp-sourcemaps gulp-uglify gulp-util mathsass --save-dev
 */
 
// Load plugins
var gulp = require('gulp'),
    del = require('del'),
    autoprefixer = require('gulp-autoprefixer'),
    cache = require('gulp-cache'),
    concat = require('gulp-concat'),
    imagemin = require('gulp-imagemin'),
    insert = require('gulp-insert'),
    jshint = require('gulp-jshint'),
    livereload = require('gulp-livereload'),
    minifycss = require('gulp-minify-css'),
    notify = require('gulp-notify'),
    plumber = require('gulp-plumber'),
    pxtorem = require('gulp-pxtorem'), 
    rename = require('gulp-rename'),
    replace = require('gulp-replace'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    uglify = require('gulp-uglify');   

// --- [DEV TASKS] ---
		
// Styles
gulp.task('styles', function() {

	var properties = [
		'font',
		'font-size',
		'line-height',
		'letter-spacing',
		'max-width',    
		'min-width',    
		'min-heigth',    
		'max-heigth',    
		'width',
		'height',
		'margin',
		'margin-top',
		'margin-bottom',
		'margin-left',
		'margin-right',        
		'padding',
		'padding-top',
		'padding-bottom',
		'padding-left',
		'padding-right'
	];
    
	return gulp.src('_dev/css/sass/*.scss')
		.pipe(sourcemaps.init())
		.pipe(plumber())
		.pipe(sass())  
		.pipe(pxtorem({
			root_value: 10,
			prop_white_list: properties
		}))
		
		//.pipe(gulp.dest('css'))
		//.pipe(notify({ message: 'Styles task complete' })); 
		//.pipe(autoprefixer('last 2 version'))
		//.pipe(gulp.dest('_dev/css'))
		//.pipe(minifycss())
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('css'))
		.pipe(notify({ message: 'New styles complete' }));		
});		 


gulp.task('styles-ie', ['styles'], function() {    
  return gulp.src('_dev/css/sass/ie.scss')
    .pipe(plumber())
    .pipe(sass())  
    .pipe(autoprefixer('last 2 version'))
    .pipe(gulp.dest('_dev/css'))
    .pipe(minifycss())
    .pipe(gulp.dest('css'))
    .pipe(notify({ message: 'Styles-ie task complete' }));      
    
});


// Scripts
gulp.task('scripts', function() {
  return gulp.src('./_dev/js/*.js')

  .pipe(jshint())
  .pipe(jshint.reporter('default'))
  
    .pipe(concat('scripts.js'))
    //.pipe(uglify())
    .pipe(gulp.dest('js'))
    .pipe(notify({ message: 'Scripts task complete' }));
});
 
// Images
gulp.task('images', function() {
  return gulp.src('_dev/images/**/*')
    .pipe(cache(imagemin({ 
      optimizationLevel: 3, 
      progressive: true, 
      interlaced: true 
  })))
	.pipe(gulp.dest('images'))
	.pipe(notify({ message: 'Images task complete' }));
});
 
// Clean
gulp.task('clean', function(cb) {
    del(['css', 'js', 'images'], cb)
});
 
// Default task
gulp.task('default', ['clean'], function() {
    gulp.start('styles', 'images');
});
 
// Watch
gulp.task('watch', function() {

  // Create LiveReload server
  livereload.listen();
	
  // Watch .scssfiles
 // gulp.watch('_dev/css/sass/**/*.scss', ['styles', 'styles-ie']);
  gulp.watch('_dev/css/sass/**/*.scss', ['styles'])
		.on('change', livereload.changed)
	;
 
  // Watch .js files
  gulp.watch('_dev/js/**/*.js', ['scripts']);
 
  // Watch image files
  gulp.watch('_dev/images/**/*', ['images']);
 

 
  // Watch any files in dist/, reload on change
  //gulp.watch(['**']).on('change', livereload.changed);
 
});

// --- [BUILD TASKS] ---

gulp.task('build-css', function() {
	return gulp.src('_dev/css/*.css')
		.pipe(autoprefixer('last 2 version'))
		.pipe(minifycss())
		.pipe(gulp.dest('css'))
		.pipe(notify({ message: 'Build complete' }));    
});  

// --- [TABULA RASA] ---

gulp.task('tr-js', function() {
		
		del(['js/*.js', '!js/customizer.js']);

});

gulp.task('tr-move', ['tr-js'], function() {
 
    gulp.src('inc/*.php')
		.pipe(gulp.dest('./inc/_s'));
		

});

gulp.task('tr-functions', ['tr-move'], function() {
 
    return gulp.src('functions.php')
		.pipe(replace('/inc/', '/inc/_s/'))
		.pipe(replace('add_action( \'wp_enqueue_scripts', '\/\/add_action( \'wp_enqueue_scripts'))
		.pipe(rename('functions-_s.php'))
		.pipe(gulp.dest('./inc'))
		del(['functions.php']);
 
});

gulp.task('tr-footer', ['tr-functions'], function() {
 
    return gulp.src('footer.php')
		.pipe(replace('http://underscores.me/', 'http://www.third-law.com/'))
		.pipe(replace('Underscores.me', 'Third Law Web Design'))
		.pipe(gulp.dest(''))
 
});

gulp.task('tr-del', ['tr-footer'], function() {
 
    del(['inc/*.php', '!inc/functions-_s.php']);
 
});
		
gulp.task('tr-style', ['tr-del'], function() {
 
    gulp.src('style.css')
		.pipe(replace(/\*\/[\s\S]*/, '\*\/'))
		.pipe(rename('style.css'))
		.pipe(gulp.dest(''));
});
		
gulp.task('tr-bigmove', ['tr-style'], function() {
 
    gulp.src('../../../../_tabula-rasa_overwrite_files/**/*')
    .pipe(gulp.dest(''));
    
});
		
gulp.task('tr-del-2', ['tr-bigmove'], function() {
 
		del(['.git'])
		del(['.gitattributes'])
		del(['.gitignore'])
		del(['__tabula-rasa_overwrite_files_setup']);
    
});

gulp.task('tabula-rasa', ['tr-js', 'tr-move', 'tr-functions', 'tr-footer', 'tr-del', 'tr-style', 'tr-bigmove', 'tr-del-2']);

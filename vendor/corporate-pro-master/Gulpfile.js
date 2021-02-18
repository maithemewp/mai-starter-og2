/**
 * Gulp task config file.
 */

'use strict';

var pkg     = require( './package.json' ),
    gulp    = require( 'gulp' ),
    globs   = require( 'gulp-src-ordered-globs' ),
    toolkit = require( 'gulp-wp-toolkit' ),
    zip     = require( 'gulp-zip' );

toolkit.extendConfig(
    {
        theme: {
            name: pkg.theme.name,
            themeuri: pkg.theme.uri,
            description: pkg.description,
            author: pkg.author,
            authoruri: pkg.theme.authoruri,
            version: pkg.version,
            license: pkg.license,
            licenseuri: pkg.theme.licenseuri,
            tags: pkg.theme.tags,
            textdomain: pkg.theme.textdomain,
            domainpath: pkg.theme.domainpath,
            template: pkg.theme.template,
            notes: pkg.theme.notes
        },
        src: {
            php: ['**/*.php', '!includes/tgmpa.php'],
            images: 'assets/images/**/*',
            scss: 'assets/styles/*.scss',
            css: ['**/*.css', '!node_modules/**'],
            js: ['assets/scripts/**/*.js','!assets/scripts/min/*', '!node_modules/**'],
            json: ['**/*.json', '!node_modules/**'],
            i18n: './languages/',
            zip: [
                './**/*',
                '!./*.zip',
                '!./git',
                '!./git/**/*',
                '!./node_modules',
                '!./node_modules/**/*',
            ]
        },
        js: {
            'customize': [
                'assets/scripts/customize.js',
            ],
            'jquery.fitvids': [
                'assets/scripts/jquery.fitvids.js',
            ],
            'menus': [
                'assets/scripts/menus.js',
            ],
            'modernizr': [
                'assets/scripts/modernizr.js',
            ],
            'slick': [
                'assets/scripts/slick.js',
            ],
            'theme': [
                'assets/scripts/theme.js',
            ],
        },
        css: {
            basefontsize: 10, // Used by postcss-pxtorem.
            remmediaquery: false,
            scss: {
                'style': {
                    src: 'assets/styles/style.scss',
                    dest: './',
                    outputStyle: 'expanded'
                },
                'woocommerce': {
                    src: 'assets/styles/woocommerce.scss',
                    dest: './',
                    outputStyle: 'expanded'
                }
            }
        },
        dest: {
            i18npo: './languages/',
            i18nmo: './languages/',
            images: './assets/images/',
            js: './assets/scripts/min/'
        },
        server: {
            proxy: 'https://corporate.test',
            host: 'corporate.test',
            open: 'external',
            port: '8000',
            https: {
                'key': '/Users/seothemes/.config/valet/Certificates/corporate.test.key',
                'cert': '/Users/seothemes/.config/valet/Certificates/corporate.test.crt'
            }
        }
    }
);

toolkit.extendTasks( gulp, {
    'zip': function() {
        return globs(toolkit.config.src.zip, {base: './'}).
        pipe(zip(pkg.name + '-' + pkg.version + '.zip')).
        pipe(gulp.dest('../'));
    }
} );

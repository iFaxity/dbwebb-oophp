#!/usr/bin/env node

// Simple script to build a .scss file to .css
// Using postcss for autoprefixing and minifying
const fs           = require('fs');
const path         = require('path');

const sass         = require('sass');
const autoprefixer = require('autoprefixer');
const cssnano      = require('cssnano');
const postcss      = require('postcss');

const CWD = process.cwd();
const SRC_DIR = path.join(__dirname, 'src');
const IN_FILE = path.join(SRC_DIR, 'theme.scss');
const OUT_FILE = path.join(__dirname, '../htdocs/css/theme.min.css');

function print(msg) {
    process.stdout.clearLine();
    process.stdout.cursorTo(0);
    process.stdout.write(msg);
}

function renderFile() {
    print('Rebuilding theme...');

    try {
        let { css } = sass.renderSync({
            file: IN_FILE,
            includePaths: [
                path.resolve(CWD, 'node_modules'),
            ],
        });

        // Run autoprefixer and cssnano
        postcss([ autoprefixer, cssnano ])
            .process(css.toString(), {
                from: IN_FILE,
                to: OUT_FILE,
            })
            .then(res => {
                res.warnings().forEach(warn => {
                    console.warn(warn.toString());
                });

                fs.writeFileSync(OUT_FILE, res.css, 'utf8');

                print('Theme updated');
            });
    } catch (ex) {
        print(`Error: ${ex.message}`);
    }
}

function watchRecursive(dirpath, callback) {
    const files = fs.readdirSync(dirpath);

    for (let file of files) {
        const filepath = path.join(dirpath, file);
        const stat = fs.statSync(filepath);

        if (stat.isDirectory()) {
            watchRecursive(filepath, callback);
        }
    }

    // Watch directory
    fs.watch(dirpath, callback);
}

watchRecursive(SRC_DIR, () => renderFile());
renderFile();


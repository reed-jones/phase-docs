const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");
require("laravel-mix-purgecss");
require("@phased/phase");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
// Mix.listen("configReady", function(config) {
//   const rules = config.module.rules;

//   for (let rule of rules) {
//     if (rule.use && Array.isArray(rule.use)) {
//       for (let use of rule.use) {
//         if (use.loader === "style-loader") {
//           use.loader = "vue-style-loader";
//         }
//       }
//     }
//     for (let loader in rule.loaders) {
//       if (rule.loaders[loader] === "style-loader") {
//         rule.loaders[loader] = "vue-style-loader";
//       }
//     }
//   }
//     config.module.rules = rules
// });

mix
  .options({
    processCssUrls: false,
    postCss: [tailwindcss("./tailwind.config.js")]
  })
  .webpackConfig(webpack => {
    // console.log(webpack)
    return {
      resolve: { alias: { "@": path.resolve(__dirname, "resources", "js") } }
    };
  })
  .copyDirectory("resources/fonts", "public/fonts")
  .purgeCss({
    whitelist: [
      "html",
      "body",
      "em",
      "strong",
      "ul",
      "li",
      "h1",
      "h2",
      "h3",
      "h4",
      "h5",
      "h6"
    ],
    whitelistPatternsChildren: [/^token/, /^pre/, /^code/]
  })
  .phase();

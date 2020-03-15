const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");
require("laravel-mix-purgecss");
require("@phased/phase");

mix
  .options({
    processCssUrls: false,
    postCss: [tailwindcss("./tailwind.config.js")]
  })
  .webpackConfig(webpack => {
    return {
      resolve: {
        alias: {
          "@": path.resolve(__dirname, "resources", "js"),
          "~assets": path.resolve(__dirname, "resources", "assets")
        }
      }
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
  .phase({
    codeSplit: false
  });

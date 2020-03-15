const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");
require("laravel-mix-purgecss");
require("@phased/phase");

const readPhaseRc = file => {
  if (process.env.NODE_ENV !== 'production') {
    return null
  }

  const fs = require('fs')
  try {
    return  fs.existsSync(file) && JSON.parse(fs.readFileSync(file, "utf8"));
  } catch {
    return null;
  }
}

const writePhaseRc = file => {
  if (process.env.NODE_ENV === 'production') {
    return null
  }
  try {

    const fs = require('fs')
    const phaseRc = JSON.parse(
      require("child_process").execSync('php artisan phase:routes --json --config').toString()
    )

    if (!phaseRc || !phaseRc.config) {
      return null;
    }

    const { resources, public, ...assets } = phaseRc.config.assets

    fs.writeFileSync(file, JSON.stringify({
      config: { ...phaseRc.config, assets },
      routes: phaseRc.routes
    }));
  } catch {
    return null
  }
}

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
    codeSplit: false,

    // In prod attempt to read cached config (no 'php' in path)
    phpConfig: readPhaseRc('.phaserc')
  })
  .then(() => { writePhaseRc('.phaserc') });

const mix = require("laravel-mix");

if (process.env.NODE_ENV !== "development") {
  mix.config.production = true;
}

mix.js("resources/assets/js/2fa/2fa.js", "js").setPublicPath("public/2fa/");

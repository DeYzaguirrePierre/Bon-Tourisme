const Encore = require("@symfony/webpack-encore");

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || "dev");
}

Encore.setOutputPath("public/build/")
  .setPublicPath("/build")

  .addEntry("app", "./assets/scripts/app.js")
  .addStyleEntry("app_style", "./assets/styles/app.css")

  .addEntry("swiper_base", "./assets/scripts/swiper_base.js")
  .addStyleEntry("swiper_base_style", "./assets/styles/swiper_base.css")

  .addEntry("swiper_list", "./assets/scripts/swiper_list.js")
  .addStyleEntry("swiper_list_style", "./assets/styles/swiper_list.css")

  .splitEntryChunks()
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .configureBabelPresetEnv((config) => {
    config.useBuiltIns = "usage";
    config.corejs = "3.38";
  })
  .enableSassLoader()
  .autoProvidejQuery();

module.exports = Encore.getWebpackConfig();

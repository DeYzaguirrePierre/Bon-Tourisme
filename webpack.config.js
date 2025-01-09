const Encore = require("@symfony/webpack-encore");

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || "dev");
}

Encore.setOutputPath("public/build/")
  .setPublicPath("/build")
  .addEntry("swiper", "./assets/scripts/swiper.js")
  .addStyleEntry("swiper-style", "./assets/styles/swiper.css")
  .addEntry("app", "./assets/scripts/app.js")
  .addStyleEntry("app-style", "./assets/styles/app.css")
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

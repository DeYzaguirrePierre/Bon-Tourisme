const Encore = require("@symfony/webpack-encore");

// Configure l'environnement d'exécution si non configuré
if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || "dev");
}

Encore
  // Répertoire où les assets compilés seront stockés
  .setOutputPath("public/build/")
  // Chemin public utilisé par le serveur web pour accéder au répertoire de sortie
  .setPublicPath("/build")

  // Configuration des entrées
  .addEntry("app", "./assets/app.js") // Point d'entrée principal JS

  // Fractionnement des fichiers pour optimiser le chargement
  .splitEntryChunks()
  .enableSingleRuntimeChunk()

  // Nettoyage des anciens fichiers avant la compilation
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())

  // Configuration Babel pour des polyfills modernes
  .configureBabelPresetEnv((config) => {
    config.useBuiltIns = "usage";
    config.corejs = "3.38";
  })

  // Activer le support Sass/SCSS
  .enableSassLoader()

  // Ajouter des loaders pour le CSS
  .addLoader({ test: /\.css$/, use: ["style-loader", "css-loader"] })
  .addLoader({
    test: /\.s[ac]ss$/i,
    use: ["style-loader", "css-loader", "sass-loader"],
  })

  // Fournir jQuery pour les plugins qui en dépendent
  .autoProvidejQuery();

module.exports = Encore.getWebpackConfig();

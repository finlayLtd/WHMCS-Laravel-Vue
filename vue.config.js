module.exports = {
    // Delete the prefetch plugin
    outputDir: './',
    chainWebpack: config => {
      config.plugins.delete('prefetch')
    }
  }

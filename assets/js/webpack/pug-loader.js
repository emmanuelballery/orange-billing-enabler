const pug = require('pug');
const loaderUtils = require('loader-utils');

module.exports = function (source) {
    // console.log(this.resourceQuery)
    // ?vue&type=template&id=c83ac9a8&lang=pug&

    const options = Object.assign({
        filename: this.resourcePath,
        doctype: 'html', // 'js'
        compileDebug: this.debug || false,
    }, loaderUtils.getOptions(this));

    const template = pug.compile(source, options);
    template.dependencies.forEach(this.addDependency);
    return template(options.data || {});
};

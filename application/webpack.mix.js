const mix = require('laravel-mix');
const fs = require('fs');
const path = require('path');
const config = {
	resolve: {
		extensions: [
			'.jsx',
			'.js',
			'.json',
		],
		modules: ["resources/js", "node_modules"],
		alias: {
			"@app": path.resolve(__dirname, 'resources/js/app/'),
		},
	},
};
mix.webpackConfig(config);
function deleteDirectoryRecursive(directoryPath) {
	if (fs.existsSync(directoryPath)) {
		fs.readdirSync(directoryPath).forEach((file) => {
			const filePath = path.join(directoryPath, file);
			if (fs.lstatSync(filePath).isDirectory()) {
				deleteDirectoryRecursive(filePath);
			} else {
				fs.unlinkSync(filePath);
			}
		});
		fs.rmdirSync(directoryPath);
		console.log('Directory deleted:', directoryPath);
	}
}
function listFoldersAndJsFiles(folderPath, foldersArray, jsFilesArray) {
	const files = fs.readdirSync(folderPath);
	files.forEach(file => {
		const filePath = path.join(folderPath, file);
		const normalizedPath = path.normalize(filePath).replace(/\\/g, '/');
		const stats = fs.statSync(filePath);
		const lastFolder = path.basename(normalizedPath);
		if (!['includes', 'components','Components','Includes'].includes(lastFolder)) {
			if (stats.isDirectory()) {
				foldersArray.push(normalizedPath);
				listFoldersAndJsFiles(filePath, foldersArray, jsFilesArray);
			} else if (path.extname(filePath) === '.js') {
				jsFilesArray.push(normalizedPath);
			}
		}
	});
}
const sourceFolderPath = 'resources/js';
mix.setPublicPath('../public_html/');
deleteDirectoryRecursive('../public_html/resources')
const foldersArray = [];
const jsFilesArray = [];
listFoldersAndJsFiles(sourceFolderPath, foldersArray, jsFilesArray);
for (let index = 0; index < jsFilesArray.length; index++) {
	const element = jsFilesArray[index];
	mix.js(element, element);
}
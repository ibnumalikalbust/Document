const sharp = require('sharp')
const phoneNumberFormatter = function (number) {
    // 1. Menghilangkan karakter selain angka
    let formatted = number.replace(/\D/g, '');

    // 2. Menghilangkan angka 0 di depan (prefix)
    //    Kemudian diganti dengan 62
    if (formatted.startsWith('0')) {
        formatted = '62' + formatted.substr(1);
    }
    if (number.endsWith('@g.us')) {
        return number;
    } else {
        if (!formatted.endsWith('@c.us')) {
        formatted += '@c.us';
        return formatted;
        }
    }
    
    return 'nothing';
}
const resizeImage = (buffer, width, height) => {
    if (!Buffer.isBuffer(buffer)) throw 'Input is not a Buffer'
    return new Promise(async (resolve) => {
        sharp(buffer)
            .resize(width, height, { fit: 'contain' })
            .toBuffer()
            .then(resolve)
    })
}
module.exports = {
	resizeImage,
	phoneNumberFormatter
}
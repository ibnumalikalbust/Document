const data_web = require('./config.json');
const fetch = require('node-fetch');
const ucapan = async () => {
    let getucapan = await fetch(data_web.domain + '/request/req_two.php?req=ucapan');
    let ujson = await getucapan.json();
    return ujson.message;
}
module.exports = {
    ucapan
}
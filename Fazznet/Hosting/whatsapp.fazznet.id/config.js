// connection database
const config = require('./config.json')
const mysql = require('mysql')

const koneksi = mysql.createConnection({
  host: config.host_name,
  user: config.user,
  password: config.password,
  database: config.db_name,
  charset: 'utf8mb4'
});

koneksi.connect((err) => {
	if (err) console.log(err)
})

// exports koneksi
module.exports = koneksi
/*
########## SIMPLELY ###########
YOU CAN CREATE YOUR OWN IDEA!
###############################
*/
const data_web = require('./config.json');
const koneksi = require('./config');
const express = require('express');
const app = express();
var options, http, httpServer;
if (data_web.installed == 'vps') {
    options = {
      key: fs.readFileSync(`../../server/panel/vhost/cert/${data_web.domain_without_http}/privkey.pem`),
      cert: fs.readFileSync(`../../server/panel/vhost/cert/${data_web.domain_without_http}/fullchain.pem`)
    };
    http = require("https");
    httpServer = http.createServer(options, app);
} else {
    http = require("http");
    httpServer = http.createServer(app);
}
const { Server } = require("socket.io");
const io = new Server(httpServer);
const qrcode = require('qrcode')
const { resizeImage, phoneNumberFormatter } = require('./converter')
delete require.cache[require.resolve('./ridah-ses-v5.js')]
const ridped = require('./ridah-ses-v5')
var spawn = require('child_process').spawn;
var cron = require('node-cron');
const fetch = require('node-fetch');
const request = require('request');
const fs = require('fs');
const axios = require('axios');
const base_url = data_web.domain
require('./ridah-ses-v5');
app.set('json spaces', 2);
app.use(express.json());
app.get('/', async (req, res) => {
    res.redirect(base_url + '/welcome/index.php')
})

app.get('/device/restart', async (req, res, next) => {
    process.exit(1);
    //await ridped.Start(req.query.sender, req.query.sender)
    res.status(200).json({
        "Status": 'oke!'
    })
})

app.get('/device/Start', async (req, res, next) => {
    var sessionStatus = await ridped.ApiStatus(req.query.sender);
    var session = await ridped.getSession(req.query.sender);
  //
  switch (sessionStatus.status) {
    case 'isLogged':
    case 'qrRead':
      //
      res.setHeader('Content-Type', 'application/json');
      res.status(200).json({
        "Status": sessionStatus
      });
      break;
    case 'notLogged':
    case 'CLOSED':
    case 'DISCONNECTED':
      //
      var getStart = await ridped.Start(req.query.sender, req.query.sender);
      console.log("- AuthorizationToken:", req.query.sender);
      session.state = 'STARTING';
      session.status = 'notLogged';
      //
      var Start = {
        result: "info",
        state: 'STARTING',
        status: 'notLogged',
        message: 'Sistem mulai dan tidak tersedia untuk digunakan'
      };
      //
      res.setHeader('Content-Type', 'application/json');
      res.status(200).json({
        "Status": Start
      });
      //
      break;
    default:
      res.setHeader('Content-Type', 'application/json');
      res.status(400).json({
        "Status": sessionStatus
      });
  }
})

app.get('/api/sendFiles', async (req, res, next) => {
    var sessionStatus = await ridped.ApiStatus(req.query.sender);
  switch (sessionStatus.status) {
    case 'isLogged':
      //
      var fmNo = phoneNumberFormatter(req.query.number);
      var rep = fmNo.replace('@c.us', '@s.whatsapp.net');
      if (fmNo.endsWith('@g.us')) {
          var sendFile = await ridped.sendFiles(
          req.query.sender,
          fmNo,
          req.query.url,
          req.query.ex,
          req.query.filename,
          req.query.caption
        );
        
        res.setHeader('Content-Type', 'application/json');
        return res.status(200).json({
            "Status": sendFile
        });
      }
      var checkNumberStatus = await ridped.checkNumberStatus(
        req.query.sender,
        fmNo
      );
      if (checkNumberStatus.status === 200 && checkNumberStatus.erro === false) {
        var sendFile = await ridped.sendFiles(
          req.query.sender,
          fmNo,
          req.query.url,
          req.query.ex,
          req.query.filename,
          req.query.caption
        );
      } else {
        var sendFile = checkNumberStatus;
      }
      //
      //console.log(result);
      res.setHeader('Content-Type', 'application/json');
      res.status(200).json({
        "Status": sendFile
      });
      break;
    default:
      res.setHeader('Content-Type', 'application/json');
      res.status(400).json({
        "Status": sessionStatus
      });
  }
})

app.get('/api/checknowa', async (req, res, next) => {
   console.log('- checking number');
   var sessionStatus = await ridped.ApiStatus(req.query.sender);
   switch(sessionStatus.status) {
       case 'isLogged':
           var fmNo = phoneNumberFormatter(req.query.number);
           var checkNumberStatus = await ridped.checkNumberStatus(
               req.query.sender,
               fmNo
           );
           if (checkNumberStatus.status === 200 && checkNumberStatus.erro === false) {
               res.status(200).json({
                   "status": 200,
                   "result": "terdaftar"
               });
           } else {
               res.status(200).json({
                   "status": false,
                   "result": "Nomor tidak terdaftar di whatsapp"
               });
           }
           break;
        default:
          res.status(200).json({
              "status": false,
              "result": "Nothing session"
          });
   }
});

app.get('/api/sendList', async (req, res, next) => {
    console.log('- Sending text')
    var sessionStatus = await ridped.ApiStatus(req.query.sender);
  switch (sessionStatus.status) {
    case 'isLogged':
      //
      
      var fmNo = phoneNumberFormatter(req.query.number);
      var rep = fmNo.replace('@c.us', '@s.whatsapp.net');
      if (fmNo.endsWith('@g.us')) {
          var sendList = await ridped.sendListTwo(
          req.query.sender,
          fmNo,
          req.query.text,
          req.query.footer,
          req.query.title,
          req.query.buttonText,
          req.query.title_section,
          req.query.title_rows_one,
          req.query.title_rows_two,
          req.query.title_rows_three,
          req.query.title_rows_four,
          req.query.title_rows_five,
          req.query.title_rows_six,
          req.query.title_rows_seven,
          req.query.title_rows_delapan,
          req.query.title_rows_one_keyword,
          req.query.title_rows_two_keyword,
          req.query.title_rows_three_keyword,
          req.query.title_rows_four_keyword,
          req.query.title_rows_five_keyword,
          req.query.title_rows_six_keyword,
          req.query.title_rows_seven_keyword,
          req.query.title_rows_delapan_keyword
        );
        res.setHeader('Content-Type', 'application/json');
        return res.status(200).json({
            "Status": sendList
        });
      }
      
      var checkNumberStatus = await ridped.checkNumberStatus(
        req.query.sender,
        fmNo
      );
      if (checkNumberStatus.status === 200 && checkNumberStatus.erro === false) {
        var sendList = await ridped.sendListTwo(
          req.query.sender,
          fmNo,
          req.query.text,
          req.query.footer,
          req.query.title,
          req.query.buttonText,
          req.query.title_section,
          req.query.title_rows_one,
          req.query.title_rows_two,
          req.query.title_rows_three,
          req.query.title_rows_four,
          req.query.title_rows_five,
          req.query.title_rows_six,
          req.query.title_rows_seven,
          req.query.title_rows_delapan,
          req.query.title_rows_one_keyword,
          req.query.title_rows_two_keyword,
          req.query.title_rows_three_keyword,
          req.query.title_rows_four_keyword,
          req.query.title_rows_five_keyword,
          req.query.title_rows_six_keyword,
          req.query.title_rows_seven_keyword,
          req.query.title_rows_delapan_keyword
        );
      } else {
        var sendList = checkNumberStatus;
      }
      //console.log(result);
      res.setHeader('Content-Type', 'application/json');
      res.status(200).json({
        "Status": sendList
      });
      break;
    default:
      res.setHeader('Content-Type', 'application/json');
      res.status(400).json({
        "Status": sessionStatus
      });
  }
})

app.get('/api/sendListTwo', async (req, res, next) => {
    console.log('- Sending text')
    var sessionStatus = await ridped.ApiStatus(req.query.sender);
  switch (sessionStatus.status) {
    case 'isLogged':
      //
      
      var fmNo = phoneNumberFormatter(req.query.number);
      var rep = fmNo.replace('@c.us', '@s.whatsapp.net');
      if (fmNo.endsWith('@g.us')) {
          var sendList = await ridped.sendList(
          req.query.sender,
          fmNo,
          req.query.text,
          req.query.footer,
          req.query.title,
          req.query.buttonText,
          req.query.title_section,
          req.query.title_rows_one,
          req.query.title_rows_two,
          req.query.title_rows_three,
          req.query.title_rows_four,
          req.query.title_rows_five,
          req.query.title_rows_six,
          req.query.title_rows_seven,
          req.query.title_rows_delapan,
          req.query.title_rows_one_keyword,
          req.query.title_rows_two_keyword,
          req.query.title_rows_three_keyword,
          req.query.title_rows_four_keyword,
          req.query.title_rows_five_keyword,
          req.query.title_rows_six_keyword,
          req.query.title_rows_seven_keyword,
          req.query.title_rows_delapan_keyword
        );
        res.setHeader('Content-Type', 'application/json');
        return res.status(200).json({
            "Status": sendText
        });
      }
      
      var checkNumberStatus = await ridped.checkNumberStatus(
        req.query.sender,
        fmNo
      );
      if (checkNumberStatus.status === 200 && checkNumberStatus.erro === false) {
        var sendList = await ridped.sendList(
          req.query.sender,
          fmNo,
          req.query.text,
          req.query.footer,
          req.query.title,
          req.query.buttonText,
          req.query.title_section,
          req.query.title_rows_one,
          req.query.title_rows_two,
          req.query.title_rows_three,
          req.query.title_rows_four,
          req.query.title_rows_five,
          req.query.title_rows_six,
          req.query.title_rows_seven,
          req.query.title_rows_delapan,
          req.query.title_rows_one_keyword,
          req.query.title_rows_two_keyword,
          req.query.title_rows_three_keyword,
          req.query.title_rows_four_keyword,
          req.query.title_rows_five_keyword,
          req.query.title_rows_six_keyword,
          req.query.title_rows_seven_keyword,
          req.query.title_rows_delapan_keyword
        );
      } else {
        var sendList = checkNumberStatus;
      }
      //console.log(result);
      res.setHeader('Content-Type', 'application/json');
      res.status(200).json({
        "Status": sendList
      });
      break;
    default:
      res.setHeader('Content-Type', 'application/json');
      res.status(400).json({
        "Status": sessionStatus
      });
  }
})

app.get('/api/sendText', async (req, res, next) => {
    console.log('- Sending text')
    var sessionStatus = await ridped.ApiStatus(req.query.sender);
  switch (sessionStatus.status) {
    case 'isLogged':
      //
      
      var fmNo = phoneNumberFormatter(req.query.number);
      var rep = fmNo.replace('@c.us', '@s.whatsapp.net');
      if (fmNo.endsWith('@g.us')) {
          var sendText = await ridped.sendText(
          req.query.sender,
          req.query.number,
          req.query.msg
        );
        res.setHeader('Content-Type', 'application/json');
        return res.status(200).json({
            "Status": sendText
        });
      }
      
      var checkNumberStatus = await ridped.checkNumberStatus(
        req.query.sender,
        fmNo
      );
      if (checkNumberStatus.status === 200 && checkNumberStatus.erro === false) {
        var sendText = await ridped.sendText(
          req.query.sender,
          fmNo,
          req.query.msg
        );
      } else {
        var sendText = checkNumberStatus;
      }
      //console.log(result);
      res.setHeader('Content-Type', 'application/json');
      res.status(200).json({
        "Status": sendText
      });
      break;
    default:
      res.setHeader('Content-Type', 'application/json');
      res.status(400).json({
        "Status": sessionStatus
      });
  }
})

app.get('/api/sendButton', async (req, res, next) => {
    console.log('- Sending button')
    var sessionStatus = await ridped.ApiStatus(req.query.sender);
  switch (sessionStatus.status) {
    case 'isLogged':
      //
      
      var fmNo = phoneNumberFormatter(req.query.number);
      var rep = fmNo.replace('@c.us', '@s.whatsapp.net');
      if (fmNo.endsWith('@g.us')) {
          var sendText = await ridped.sendButton(
          req.query.sender,
          fmNo,
          req.query.image,
          req.query.content,
          req.query.footer,
          req.query.external_link,
          req.query.external_link_name,
          req.query.external_telp,
          req.query.external_telp_name,
          req.query.keyword_auto_reply,
          req.query.text_button,
          req.query.keyword_auto_replytwo,
          req.query.text_button_two
        );
        
        res.setHeader('Content-Type', 'application/json');
        return res.status(200).json({
            "Status": sendText
        });
      }
      var checkNumberStatus = await ridped.checkNumberStatus(
        req.query.sender,
        fmNo
      );
      if (checkNumberStatus.status === 200 && checkNumberStatus.erro === false) {
        var sendText = await ridped.sendButton(
          req.query.sender,
          fmNo,
          req.query.image,
          req.query.content,
          req.query.footer,
          req.query.external_link,
          req.query.external_link_name,
          req.query.external_telp,
          req.query.external_telp_name,
          req.query.keyword_auto_reply,
          req.query.text_button,
          req.query.keyword_auto_replytwo,
          req.query.text_button_two
        );
      } else {
        var sendText = checkNumberStatus;
      }
      //console.log(result);
      res.setHeader('Content-Type', 'application/json');
      res.status(200).json({
        "Status": sendText
      });
      break;
    default:
      res.setHeader('Content-Type', 'application/json');
      res.status(400).json({
        "Status": sessionStatus
      });
  }
})


// GET QRCODE
app.get('/api/qrcode', async (req, res, next) => {
    console.log("- getQRCode");
    var sessionStatus = await ridped.ApiStatus(req.query.sender);
    var session = ridped.getSession(req.query.sender);
  switch (sessionStatus.status) {
    case 'isLogged':
      //
      res.setHeader('Content-Type', 'application/json');
      res.status(200).json({
        "Status": sessionStatus
      });
      break;
      //
    case 'notLogged':
    case 'qrRead':
      //
      if (req.query.View === true) {
        var xSession = session.qrcode;
        if (xSession) {
          const imageBuffer = Buffer.from(xSession, 'base64');
          //
          res.writeHead(200, {
            'Content-Type': 'image/png',
            'Content-Length': imageBuffer.length
          });
          //
          res.status(200).end(imageBuffer);
          //
        } else {
          var getQRCode = {
            result: 'error',
            state: 'NOTFOUND',
            status: 'notLogged',
            message: 'SISTEM OFFLINE'
          };
          //
          res.setHeader('Content-Type', 'application/json');
          res.status(200).json({
            "Status": getQRCode
          });
          //
        }
      } else {
        var getQRCode = {
          result: "success",
          state: session.state,
          status: session.status,
          qrcode: session.qrcode,
          message: "Menunggu pembacaan QR-Code"
        };
        //
        res.setHeader('Content-Type', 'application/json');
        res.status(200).json({
          "Status": getQRCode
        });
        //
      }
      //
      break;
    default:
      res.setHeader('Content-Type', 'application/json');
      res.status(400).json({
        "Status": sessionStatus
      });
  }
})

app.get('/device/Logout', async (req, res, next) => {
  var sessionStatus = await ridped.ApiStatus(req.query.sender);
  switch (sessionStatus.status) {
    case 'isLogged':
      //
      var LogoutSession = await ridped.logoutSession(req.query.sender);
      res.setHeader('Content-Type', 'application/json');
      res.status(200).json({
        "Status": LogoutSession
      });
      break;
    default:
      res.setHeader('Content-Type', 'application/json');
      res.status(400).json({
        "Status": sessionStatus
      });
  }
})

app.use((req, res, next) => {
    res.redirect(base_url + '/index.php?link1=404');
})

/*if (data_web.installed !== "shared_hosting") {
    koneksi.query(`SELECT * FROM device`, function (err, res){
        if (err) console.log('error db : ' + err)
        res.forEach(async rid => {
            let sender = rid.nomor
            await ridped.Start(sender, sender)
        })
    })
}*/

var minutes = 1, the_interval = minutes * 60 * 1000;
setInterval(async() => {
  console.log("I am doing my 1 minutes check");
  try {
   await fetch(base_url + '/request/expired.php');
  } catch (e) { }
    console.log("Done check");
}, the_interval);

var minutes = 2, the_interval = minutes * 60 * 1000;
setInterval(async() => {
  console.log("I am doing my 4 minutes check");
  await fetch(base_url + '/request/restartall.php');
/*koneksi.query(`SELECT * FROM device`, function (err, res){
    if (err) console.log('error db : ' + err)
    try {
    res.forEach(async rid => {
        let sender = rid.nomor
        await ridped.Start(sender, sender)
    })
    } catch (e) {
        res.forEach(async rid => {
        let sender = rid.nomor
        await ridped.Start(sender, sender)
        })
    }
})*/
    if (data_web.installed == 'shared_hosting') {
        fs.unlink('./error_log', function(err) {
            if (err) {
                console.log(err)
            } else {
                console.log('Deleted')
            }
        });
        fs.unlink('./stderr.log', function (err) {
            if (err) {
                console.log(err)
            } else {
                console.log('Deleted')
            }
        });
    }
    console.log("Done check");
}, the_interval);

var minutes = 1, the_interval = minutes * 60 * 1000;
setInterval(async() => {
  console.log("I am doing my 1 minutes check");
  try {
   await fetch(base_url + '/request/cron-blast.php');
  } catch (e) { }
    console.log("Done check");
}, the_interval);

function times(second) {
    days = Math.floor((second / 60) / 60 / 24)
    hours = Math.floor((second / 60) / 60)
    minute = Math.floor(second / 60)
    sec = Math.floor(second)
    return days + ' days, ' + hours + ' hours, ' + minute + ' minutes, ' + sec + ' seconds'
}

function formatNumb(string) {
  var numbers = string.replace(/[^0-9]/g, '');
  return numbers;
}

function sleep(ms) {
  return new Promise((resolve) => {
    setTimeout(resolve, ms);
  });
}

function main() {
  if (process.env.process_restarting) {
    delete process.env.process_restarting;
    return;
  }
  // Restart process ...
  spawn(process.argv[0], process.argv.slice(1), {
    env: { process_restarting: 1 },
    stdio: 'ignore'
  }).unref();
}

process.on('uncaughtException', function(err) {
    // handle the error safely
    console.log(err)
})

const PORT = data_web.port_app // <- default is 8440
httpServer.listen(PORT, () => {
    console.log('Port '+PORT)
})
//
// ------------------------------------------------------------------------------------------------------- //
//              
//               THX TO ADIWAJSHING BAILEYS
//               AND ALSO FOR ALL MY USERS
//                  BEST REGARD RIDPEDIA
//                 AUTHOR : Ridah (SOLO)
//           OFFICIAL WEBSITE : www.ridped.com
//             YOU GET FREE UPDATE LIFETIME!
//                MORE FEATURE COMINGSOON><
// ------------------------------------------------------------------------------------------------------- //
//
//
// Konfigurasi modul
const db = require('./config');
const data_web = require('./config.json')
const fs = require("fs-extra");
const fees = require("fs");
const QRCode = require('qrcode');
const pino = require("pino");
const axios = require('axios');
const fetch = require('node-fetch');
const echo = require('node-echo');
const { exec } = require('child_process');
const { ucapan } = require('./ucapan');
var cron = require('node-cron');
const {
  default: RIDPEDIAH,
  WASocket,
  AuthenticationState,
  BufferJSON,
  getMessage,
  WA_DEFAULT_EPHEMERAL,
  initInMemoryKeyStore,
  WAMessage,
  Contact,
  SocketConfig,
  useSingleFileAuthState,
  fetchLatestBaileysVersion,
  DisconnectReason,
  BaileysEventMap,
  GroupMetadata,
  AnyMessageContent,
  MiscMessageGenerationOptions,
  MessageType,
  MessageOptions,
  Mimetype,
  generateWAMessageFromContent,
  downloadContentFromMessage,
  downloadHistory,
  proto,
  generateWAMessageContent,
  prepareWAMessageMedia,
  WAUrlInfo
} = require('@adiwajshing/baileys');
//
// ------------------------------------------------------------------------------------------------------- //
//
async function osplatform() {
  //
  var opsys = process.platform;
  if (opsys == "darwin") {
    opsys = "MacOS";
  } else if (opsys == "win32" || opsys == "win64") {
    opsys = "Windows";
  } else if (opsys == "linux") {
    opsys = "Linux";
  }
  console.log("- sistem operasional", opsys) // I don't know what linux is.
  //console.log("-", os.type());
  //console.log("-", os.release());
  //console.log("-", os.platform());
  //
  return opsys;
}
//
// ------------------------------------------------------------------------------------------------------- //
//
async function updateStateDb(state, status, AuthorizationToken, qrcode) {
  //
  const date_now = new Date().toISOString().replace(/T/, ' ').replace(/\..+/, '');
  console.log("- Date:", date_now);
  const sql = `UPDATE device SET state="${state}", status="${status}", qrcode="${qrcode}" WHERE nomor ="${AuthorizationToken}"`;
  db.query(sql)
}

async function updateDataBot(nomor, name, status_wa, pp) {
  //
  console.log("- I'am doing update profile!!!!");
  const sql = `UPDATE device SET profile_name="${name}", status_wa="${status_wa}", pp="${pp}" WHERE nomor ="${nomor}"`;
  db.query(sql)
}
//
// ------------------------------------------------------------------------------------------------------- //
//
async function deleteSession(filePath) {
  //
  fs.unlink(filePath, function(err) {
    if (err && err.code == 'ENOENT') {
      // file doens't exist
      console.log(`- "${filePath}" tidak ada`);
    } else if (err) {
      // other errors, e.g. maybe we don't have enough permission
      console.log(`- Kesalahan menghapus file "${filePath}"`);
    } else {
      console.log(`- "${filePath}" berhasil dihapus`);
    }
  });
}
//
// ------------------------------------------------------------------------------------------------------- //
//
module.exports = class Sessions {
  //
  static async getStatusApi(sessionName, options = []) {
    Sessions.options = Sessions.options || options;
    Sessions.sessions = Sessions.sessions || [];

    var session = Sessions.getSession(sessionName);
    return session;
  } //getStatus
  //
  static async ApiStatus(SessionName) {
    console.log("- Status");
    var session = Sessions.getSession(SessionName);

    if (session) { //tambahkan saja jika tidak ada
      if (session.state == "CONNECTED") {
        return {
          result: "info",
          state: session.state,
          status: session.status,
          message: "Sistem dimulai dan tersedia untuk digunakan"
        };
      } else if (session.state == "STARTING") {
        return {
          result: "info",
          state: session.state,
          status: session.status,
          message: "Sistem mulai dan tidak tersedia untuk digunakan"
        };
      } else if (session.state == "QRCODE") {
        return {
          result: "warning",
          state: session.state,
          status: session.status,
          message: "Sistem menunggu pembacaan QR-Code"
        };
      } else if (session.state == "CLOSED") {
        return {
          result: "info",
          state: session.state,
          status: session.status,
          message: "sesi tertutup"
        };
      } else {
        return {
          result: "warning",
          state: session.state,
          status: session.status,
          message: "Sistem dimulai dan tidak tersedia untuk digunakan"
        };
      }
    } else {
      return {
        result: 'error',
        state: 'NOTFOUND',
        status: 'notLogged',
        message: 'Sistem offline'
      };
    }
  } //status
  //
  // ------------------------------------------------------------------------------------------------------- //
  //
  static async Start(SessionName, AuthorizationToken) {
    Sessions.sessions = Sessions.sessions || []; //start array

    var session = Sessions.getSession(SessionName, AuthorizationToken);

    if (session == false) {
      //create new session
      //
      session = await Sessions.addSesssion(SessionName, AuthorizationToken);
    } else if (["CLOSED"].includes(session.state) || ["DISCONNECTED"].includes(session.state)) {
      //restart session
      console.log("- State: CLOSED");
      session.state = "CLOSED";
      session.status = "notLogged";
      session.qrcode = null;
      session.qrcodedata = null;
      session.attempts = 0;
      session.message = "Sistem mulai dan tidak tersedia untuk digunakan";
      session.prossesid = null;
      session.blocklist = null;
      session.browserSessionToken = null;
      //
      console.log('- nama sesi:', session.name);
      console.log('- State:', session.state);
      console.log('- status sesi:', session.status);
      //
      session.client = Sessions.initSession(SessionName);
      Sessions.setup(SessionName);
    } else {
      console.log('- Nama sesi:', session.name);
      console.log('- State:', session.state);
      console.log('- Status sesi:', session.status);
      Sessions.setup(SessionName);
    }
    //
    await updateStateDb(session.state, session.status, session.AuthorizationToken);
    //
    return session;
  } //start
  //
  // ------------------------------------------------------------------------------------------------------- //
  //
  static async addSesssion(SessionName, AuthorizationToken) {
    console.log("- menambahkan sesi");
    var newSession = {
      AuthorizationToken: AuthorizationToken,
      name: SessionName,
      processid: null,
      qrcode: null,
      qrcodedata: null,
      client: false,
      result: null,
      tokenPatch: null,
      state: 'STARTING',
      status: 'notLogged',
      message: 'Sistem mulai dan tidak tersedia untuk digunakan',
      attempts: 0,
      blocklist: null,
      browserSessionToken: null
    }
    Sessions.sessions.push(newSession);
    console.log("- sesi baru: ", SessionName);

    //setup session
    newSession.client = Sessions.initSession(SessionName);
    Sessions.setup(SessionName);

    return newSession;
  } //addSession
  //
  // ------------------------------------------------------------------------------------------------//
  //
  static getSession(SessionName) {
    var foundSession = false;
    if (Sessions.sessions)
      Sessions.sessions.forEach(session => {
        if (SessionName == session.name) {
          foundSession = session;
        }
      });
    return foundSession;
  } //getSession
  //
  // ------------------------------------------------------------------------------------------------//
  //
  static getSessions() {
    if (Sessions.sessions) {
      return Sessions.sessions;
    } else {
      return [];
    }
  } //getSessions
  //
  // ------------------------------------------------------------------------------------------------------- //
  //
  static async initSession(SessionName) {
    var session = Sessions.getSession(SessionName);
    console.log('- Nama session:', SessionName);
    console.log('- Folder Sesi: session');
    const {
      state,
      saveState
    } = useSingleFileAuthState(`./session/ridped-md-${SessionName}.json`);
    const { version, isLatest } = await fetchLatestBaileysVersion()
    console.log("- startSock");
    const client = RIDPEDIAH({
      /** provide an auth state object to maintain the auth state */
      auth: state,
      /** version to connect with */
      version,
      /** override browser config */
      browser: ['RIDPEDIA', 'Firefox', '10.0'],
      setMaxListeners: 0,
      retryRequestDelayMs: 0,
      /** the WS url to connect to WA */
      waWebSocketUrl: 'wss://web.whatsapp.com/ws/chat',
      /** pino logger */
      logger: pino({
        level: 'silent'
      }),
      /** should the QR be printed in the terminal */
      printQRInTerminal: true,
      //
      emitOwnEvents: true,
      treatCiphertextMessagesAsReal: true,
      /** Default timeout for queries, undefined for no timeout */
      defaultQueryTimeoutMs: undefined,
      /** proxy agent */
      agent: undefined,
      /** agent used for fetch requests -- uploading/downloading media */
      fetchAgent: undefined,
      /** 
       * fetch a message from your store 
       * implement this so that messages failed to send (solves the "this message can take a while" issue) can be retried
       * */
      getMessage: undefined
      //
    });

    let attempts = 0;
    client.ev.on('connection.update', async (conn) => {

      console.log("- Connection update".blue);

      const {
        connection,
        lastDisconnect,
        isNewLogin,
        qr,
        receivedPendingNotifications
      } = conn;
      if (qr) {
        console.log('- QR Generated');

        var readQRCode = await QRCode.toDataURL(qr);
        var qrCode = readQRCode.replace('data:image/png;base64,', '');

        attempts++;

        console.log('- Jumlah upaya untuk membaca kode qr:', attempts);
        session.attempts = attempts;
        session.qrcode = readQRCode;
        session.qrcodedata = qrCode;
        session.state = "QRCODE";
        session.status = "qrRead";
        session.message = 'Sistem mulai dan tidak tersedia untuk digunakan';
        /*setInterval(async() => {
            await updateStateDb(session.state, session.status, session.AuthorizationToken, readQRCode);
        }, 90000);*/

      }
      if (attempts <= 3) {
        await updateStateDb(session.state, session.status, session.AuthorizationToken, readQRCode);
      }
      //
      if (connection === 'connecting') {
        console.log(`- Connection ${connection}`);

        session.state = "STARTING";
        session.status = 'notLogged';
        session.qrcodedata = null;
        session.message = 'Sistem mulai dan tidak tersedia untuk digunakan';

        await updateStateDb(session.state, session.status, session.AuthorizationToken, session.qrcodedata);

      } else if (connection === 'open') {
        console.log("- Connection open");

        session.state = "CONNECTED";
        session.status = 'isLogged';
        session.qrcodedata = null;
        session.message = 'Sistem mulai dan tersedia untuk digunakan';
        try {
            var status_wa = await client.fetchStatus(SessionName+'@s.whatsapp.net');
        } catch (e) {
            var status_wa = 'Nothing status';
        }
        try {
            var pp = await client.profilePictureUrl(client.user.id, 'image');
        } catch (e) {
            var pp = 'https://www.ridped.com/way/mypp2.png';
        }
        var profile_name = 'nothing';
        await updateStateDb(session.state, session.status, session.AuthorizationToken, session.qrcodedata);
        await updateDataBot(SessionName, profile_name, status_wa.status, pp);
        
      } else if (connection === 'close') {
        console.log("- Connection close".red);
        console.log(`- Output: \n ${JSON.stringify(lastDisconnect?.error.output)}`);
        console.log(`- Data: \n ${JSON.stringify(lastDisconnect?.error.data)}`);
        console.log(`- loggedOut: \n ${JSON.stringify(DisconnectReason.loggedOut)}`);
        if (lastDisconnect?.error.output.statusCode !== DisconnectReason?.loggedOut) {

          await Sessions.initSession(SessionName);
          await Sessions.setup(SessionName);

        } else if (lastDisconnect?.error.output.statusCode === DisconnectReason?.loggedOut) {

          session.state = "CLOSED";
          session.status = 'notLogged';
          session.qrcodedata = null;
          session.message = "sesi tertutup";

          deleteSession(`./session/ridped-md-${SessionName}.json`);

          await updateStateDb(session.state, session.status, session.AuthorizationToken, session.qrcodedata);

          await Sessions.initSession(SessionName);

        } else {
          console.log("- Connection close");

          session.state = "CLOSED";
          session.status = 'notLogged';
          session.qrcodedata = null;
          session.message = "sesi tertutup";
          
          await Sessions.initSession(SessionName);
          await Sessions.setup(SessionName);

        }

      } else if (typeof connection === undefined) {
        console.log("- Connection undefined");
      }

    });
    
    client.ev.on("creds.update", saveState);
    return client;
  }

  static async setup(SessionName) {
    console.log("- sistem mulai");
    var session = Sessions.getSession(SessionName);
    const {
      state,
      saveState
    } = useSingleFileAuthState(`./session/ridped-md-${SessionName}.json`);
    await session.client.then(async (client) => {
      client.ev.on('chats.set', async (e) => {
        const {
          chats,
          messages
        } = e;
        console.log('- Session:', SessionName);
        console.log(`- Chats set ${chats}, messages ${messages}`)
      });
      //
      /** upsert chats */
      client.ev.on('chats.upsert', async (chats) => {
        console.log('- Session', SessionName);
        console.log(`- Chats upsert ${chats}`);
      });
      //
      /** update the given chats */
      client.ev.on('chats.update', async (chats) => {
        console.log('- Session:', SessionName);
        console.log(`- Chats update ${JSON.stringify(chats)}`);
      });
      //
      /** delete chats with given ID */
      client.ev.on('chats.delete', async (chats) => {
        console.log('- Session:', SessionName);
        console.log(`- Chats delete: ${chats}`);
      });
      //
      /** presence of contact in a chat updated */
      client.ev.on('presence.update', async (update) => {
        const {
          id,
          presences
        } = update;
        console.log('- Session:', SessionName);
        console.log(`- Presence update ID ${JSON.stringify(id)}, presences ${JSON.stringify(presences)} `);
      });
      //
      client.ev.on('contacts.upsert', async (contacts) => {
        console.log('- Session:', SessionName);
        console.log(`- Contacts upsert: ${JSON.stringify(contacts)}`);
      });
      //
      client.ev.on('contacts.update', async (contacts) => {
        console.log('- Session:', SessionName);
        console.log(`- Contacts update: ${JSON.stringify(contacts)}`);
      });
      //
      client.ev.on('messages.upsert', async (msg) => {
        console.log('- Session:', SessionName);
        console.log(`- Messages upsert replying to: ${msg.messages[0].key.remoteJid}`);
        console.log(msg);
        const m = msg.messages[0];
        db.query(`SELECT * FROM device WHERE nomor = "${SessionName}"`, async (err, res) => {
            if (err) console.log(err);
            if (res.length == 0) return;
            const auto_read = res[0].auto_read;
            if (auto_read == '1') {
                //await client.sendReadReceipt(m.key.remoteJid, m.key.participant, [m.key.id])
            }
        })
        if (m.key.remoteJid == 'status@broadcast') return
        let type = Object.keys(m.message)
        type = (!['senderKeyDistributionMessage', 'messageContextInfo'].includes(type[0]) && type[0]) || (type.length >= 3 && type[1] !== 'messageContextInfo' && type[1]) || type[type.length - 1] 
        let body = (type === 'conversation') ? m.message.conversation : (type == 'imageMessage') ? m.message.imageMessage.caption : (type == 'videoMessage') ? m.message.videoMessage.caption : (type == 'extendedTextMessage') ? m.message.extendedTextMessage.text : (type == 'buttonsResponseMessage') ? m.message.buttonsResponseMessage.selectedButtonId : (type == 'listResponseMessage') ? m.message.listResponseMessage.singleSelectReply.selectedRowId : (type == 'templateButtonReplyMessage') ? m.message.templateButtonReplyMessage.selectedId : (type === 'messageContextInfo') ? (m.message.listResponseMessage.singleSelectReply.selectedRowId || m.message.buttonsResponseMessage.selectedButtonId || m.text) : '';
        const from = m.key.remoteJid;
        let keywords = body.toLowerCase();
        let pushname = m.pushName
        if (m.key.fromMe) return
        const arg = body.substring(body.indexOf(' ') + 1);
        let args = body.trim().split(/ +/).slice(1);
        
        db.query(`SELECT * FROM device WHERE nomor = "${SessionName}"`, async (err, res) => {
            if (err) console.log(err);
            if (res.length === 0) return;
            const webhook = res[0].link_webhook;
            const respond = await sendHook(webhook, { from: from, message: body, pushname: pushname });
            switch(respond.mode) {
                case 'chat':
                    await client.sendMessage(from, { text: respond.pesan });
                    break;
                case 'reply':
                    await client.sendMessage(from, { text: respond.pesan }, { quoted: m });
                    break;
                case 'picture':
                    await client.sendMessage(from, { image: {url: respond.data.url }, caption: respond.data.caption, mimetype: 'image/jpeg'});
                    break;
                default:
                    return;
            }
        })
        try {
            db.query(`SELECT * FROM custom_code_reply WHERE mynumb = "${SessionName}"`, async(err, res) => {
                if (err) console.log(err);
                if (res.length == 0) return;
                res.forEach(async rid => {
                    var file_name = rid.file_name;
                    var mynumb = rid.mynumb;
                    require(`./custom_code_reply/${file_name}-${mynumb}.js`)(body, args, arg, client, pushname, from, m, SessionName);
                })
            })
        } catch (e) { }
        
        // auto reply with button
        try {
        db.query(`SELECT * FROM list_button WHERE number = "${SessionName}" AND keyword = "${keywords}"`, function (erz, rez) {
            if (erz) console.log(erz);
            if (Array.isArray(rez) && !rez.length) {
                db.query(`SELECT * FROM autoreply_button WHERE make_by = "${SessionName}" AND keyword = "${keywords}"`, function (err, resu) {
                    if (err) console.log(err);
                    if (Array.isArray(resu) && !resu.length) {
                        db.query(`SELECT * FROM auto_reply WHERE nomor = "${SessionName}" AND keyword = "${keywords}"`, function (errs, remsul) {
                            if (errs) console.log(errs);
                            if (Array.isArray(remsul) && !remsul.length) {
                                db.query(`SELECT * FROM pesan_default WHERE nomor = "${SessionName}"`, async (ers, remsu) => {
                                    if (ers) console.log(ers);
                                    if (Array.isArray(remsu) && !remsu.length) return
                                    if (remsu[0].active == "0") return
                                    var pesan = remsu[0].pesan;
                                    pesan = replaceString('[name]', pushname, pesan);
                                    pesan = replaceString('[ucapan]', await ucapan(), pesan);
                                    return client.sendMessage(from, { text: pesan }, { quoted: m });
                                })
                            }
                            try{
                                remsul.forEach(async rid => {
                                    var response = rid.response
                                    response = replaceString('[name]', pushname, response);
                                    response = replaceString('[ucapan]', await ucapan(), response);
                                    return await client.sendMessage(from, { text: response }, { quoted: m });
                                })
                            } catch (e) { }
                        })
                    }
                    try{
                        resu.forEach(async rid => {
                            var response = rid.content;
                            var footer = rid.footer;
                            response = replaceString('[name]', pushname, response);
                            response = replaceString('[ucapan]', await ucapan(), response);
                            let buttonz = [
                                { urlButton: { displayText: `${rid.external_link_name}`, url: `${rid.external_link}` } },
                                { callButton: {displayText: `${rid.external_telp_name}`, phoneNumber: `${rid.external_telp}`}},
                                { quickReplyButton: { displayText: `${rid.text_button}`, id: `${rid.keyword_auto_reply}` } },
                                { quickReplyButton: { displayText: `${rid.text_button_two}`, id: `${rid.keyword_auto_replytwo}` } },
                            ]
                            if (rid.image !== '') {
                                return await client.sendMessage(from, { caption: response, templateButtons: buttonz, image: { url: rid.image }}, { quoted: m });
                            } else {
                                return await client.sendMessage(from, { text: response, templateButtons: buttonz}, { quoted: m });
                            }
                        })
                    } catch(e) { }
                })
            }
            try{
                rez.forEach(async rid => {
                    var text_small = replaceString('[name]', pushname, rid.text_small);
                    text_small = replaceString('[ucapan]', await ucapan(), text_small);
                    var footer = rid.footer;
                    var title_message = replaceString('[name]', pushname, rid.title_message);
                    title_message = replaceString('[ucapan]', await ucapan(), title_message);
                    var buttontext = rid.buttontext;
                    const sections = [
                        {
                            title: rid.title_section,
                            rows: [
                                {title: rid.title_list_1, rowId: rid.title_list_keyword_1, description: rid.title_list_desc_1},
                                {title: rid.title_list_2, rowId: rid.title_list_keyword_2, description: rid.title_list_desc_2},
                                {title: rid.title_list_3, rowId: rid.title_list_keyword_3, description: rid.title_list_desc_3},
                            ]
                        },
                    ]
                    const listMessage = {
                        text: text_small,
                        footer: footer,
                        title: title_message,
                        buttonText: buttontext,
                        sections
                    }
                    return await client.sendMessage(from, listMessage);
                })
            } catch (e) { }
        })
        
        // END
        } catch (e) { }
      });
      //
      client.ev.on('message-info.update', async (message) => {
        console.log('- Session:', SessionName);
        console.log(`- Message-info update: ${message}`);
      });
      //
      client.ev.on('groups.update', async (group) => {
        console.log('- Session:', SessionName);
        console.log(`- Grupo update: ${group}`);
      });
      //
      /** apply an action to participants in a group */
      client.ev.on('group-participants.update', async (group) => {
        const {
          id,
          participants,
          action
        } = group;
        console.log('- Session:', SessionName);
        switch (action) {
          case 'add':
            console.log('- Participante(s) Added(s): ', participants);
            break;
          case 'remove':
            console.log('- Participante(s) Removed(s): ', participants);
            break;
          case 'promote':
            console.log('- Participante(s) Promoted(s) sebagai admin: ', participants);
            break;
          case 'demote':
            console.log('- Participante(s) Demoted(s) sebagai admin: ', participants);
            break;
          default:
            console.log('- NOTHING');
            break;
        }
      });
        //
        client.ev.on('blocklist.set', async (blocklist) => {
          console.log('- Session:', SessionName);
          console.log(`- Slocklist set: ${blocklist}`);
          session.blocklist = JSON.stringify(blocklist, null, 2);
        });
        //
        client.ev.on('blocklist.update', async (blocklist) => {
          console.log('- Session:', SessionName);
          console.log(`- Slocklist update: ${blocklist}`);
          session.blocklist = JSON.stringify(blocklist, null, 2);
        });
        
        client.ev.on('creds.update', saveState);
      //
      return client;
    });
  } //setup
  //
  // ------------------------------------------------------------------------------------------------//
  //
  static async logoutSession(SessionName) {
    console.log("- sesi penutupan");
    var session = Sessions.getSession(SessionName);
    var LogoutSession = await session.client.then(async client => {
      try {
        await client.logout();
        //
        var returnLogout = {
          result: "success",
          state: session.state,
          status: session.status,
          message: "sesi terputus"
        };
        //
        session.state = "DISCONNECTED";
        session.status = 'CLOSED';
        console.log("- sesi terputus");
        //
        await deleteSession(`./session/ridped-md-${SessionName}.json`);
        //
        await updateStateDb(session.state, session.status, session.AuthorizationToken);
        //
        return returnLogout;
        //
      } catch (error) {
        return {
          result: "error",
          state: session.state,
          status: session.status,
          message: "Terjadi kesalahan saat memutuskan sesi"
        };
        //
      };
    });
    //
    await updateStateDb(session.state, session.status, session.AuthorizationToken);
    //
    return LogoutSession;
  } //LogoutSession
  // ------------------------------------------------------------------------------------------------------- //
  static async sendText(
    SessionName,
    number,
    msg
  ) {
    console.log("- mengirim pesan teks.");
    var session = Sessions.getSession(SessionName);
    const {
      state,
      saveState
    } = useSingleFileAuthState(`./session/ridped-md-${SessionName}.json`);
    var sendResult = await session.client.then(async client => {
        
      // send a simple text!
      return await client.sendMessage(number, {
        text: msg
      }).then((result) => {
        //console.log("Result: ", result); //return object success
        //
        return {
          "erro": false,
          "status": 200,
          "group": number,
          "message": "Pesan berhasil dikirim."
        };
        //
      }).catch((erro) => {
        console.error("Kesalahan saat mengirim: ", erro); //return object error
        return {
          "erro": true,
          "status": 404,
          "group": number,
          "message": "ada Kesalahan saat mengirim pesan",
          "msg": erro
        };
        //
      });
    });
    return sendResult;
  } //sendText
  
  static async sendListTwo(
    SessionName,
    number,
    text_small,
    footer_nya,
    title_nya,
    buttonText_nya,
    title_section,
    title_rows_one,
    title_rows_two,
    title_rows_three,
    title_rows_four,
    title_rows_five,
    title_rows_six,
    title_rows_seven,
    title_rows_delapan,
    title_rows_one_keyword,
    title_rows_two_keyword,
    title_rows_three_keyword,
    title_rows_four_keyword,
    title_rows_five_keyword,
    title_rows_six_keyword,
    title_rows_seven_keyword,
    title_rows_delapan_keyword
  ) {
    console.log("- mengirim pesan teks.");
    var session = Sessions.getSession(SessionName);
    const {
      state,
      saveState
    } = useSingleFileAuthState(`./session/ridped-md-${SessionName}.json`);
    var sendResult = await session.client.then(async client => {
        
        // send a list message!
        const sections = [
            {
            title: title_section,
            rows: [
                {title: title_rows_one, rowId: title_rows_one_keyword},
                {title: title_rows_two, rowId: title_rows_two_keyword},
                {title: title_rows_three, rowId: title_rows_three_keyword},
                {title: title_rows_four, rowId: title_rows_four_keyword},
                {title: title_rows_five, rowId: title_rows_five_keyword},
                {title: title_rows_six, rowId: title_rows_six_keyword},
                {title: title_rows_seven, rowId: title_rows_seven_keyword},
                {title: title_rows_delapan, rowId: title_rows_delapan_keyword}
            ]
            },
        ]
        const listMessage = {
          text: text_small,
          footer: footer_nya,
          title: title_nya,
          buttonText: buttonText_nya,
          sections
        }
        
      // send a simple text!
      return await client.sendMessage(number, listMessage).then((result) => {
        //console.log("Result: ", result); //return object success
        //
        return {
          "erro": false,
          "status": 200,
          "group": number,
          "message": "Pesan berhasil dikirim."
        };
        //
      }).catch((erro) => {
        console.error("Kesalahan saat mengirim: ", erro); //return object error
        return {
          "erro": true,
          "status": 404,
          "group": number,
          "message": "ada Kesalahan saat mengirim pesan",
          "msg": erro
        };
        //
      });
    });
    return sendResult;
  } //sendText
  
  static async sendList(
    SessionName,
    number,
    text,
    footer,
    title,
    buttonText,
    title_section,
    title_rows_one,
    title_rows_two,
    title_rows_three,
    title_rows_four,
    title_rows_five,
    title_rows_six,
    title_rows_seven,
    title_rows_delapan,
    title_rows_one_keyword,
    title_rows_two_keyword,
    title_rows_three_keyword,
    title_rows_four_keyword,
    title_rows_five_keyword,
    title_rows_six_keyword,
    title_rows_seven_keyword,
    title_rows_delapan_keyword
  ) {
    console.log("- mengirim pesan list.");
    var session = Sessions.getSession(SessionName);
    const sections = [
        {
        title: title_section,
        rows: [
            {title: title_rows_one, rowId: title_rows_one_keyword},
            {title: title_rows_two, rowId: title_rows_two_keyword},
            {title: title_rows_three, rowId: title_rows_three_keyword},
            {title: title_rows_four, rowId: title_rows_four_keyword},
            {title: title_rows_five, rowId: title_rows_five_keyword},
            {title: title_rows_six, rowId: title_rows_six_keyword},
            {title: title_rows_seven, rowId: title_rows_seven_keyword},
            {title: title_rows_delapan, rowId: title_rows_delapan_keyword}
        ]
        },
    ]
    const listMessage = {
      text: text,
      footer: footer,
      title: title,
      buttonText: buttonText,
      sections
    }
    
    const {
      state,
      saveState
    } = useSingleFileAuthState(`./session/ridped-md-${SessionName}.json`);
    var sendResult = await session.client.then(async client => {
        
      // send a simple text!
      await client.sendMessage(number, listMessage)
      return {
          "erro": false,
          "status": 200,
          "group": number,
          "message": "Pesan berhasil dikirim."
        };
    });
    return sendResult;
  } //sendText
  
  static async sendButton(
    SessionName,
    number,
    image,
    content,
    footer,
    external_link,
    external_link_name,
    external_telp,
    external_telp_name,
    keyword_auto_reply,
    text_button,
    keyword_auto_replytwo,
    text_button_two
  ) {
    console.log("- mengirim pesan teks.");
    var session = Sessions.getSession(SessionName);
    let buttonz = [
        { urlButton: { displayText: `${external_link_name}`, url: `${external_link}` } },
        { callButton: {displayText: `${external_telp_name}`, phoneNumber: `${external_telp}`}},
        { quickReplyButton: { displayText: `${text_button}`, id: `${keyword_auto_reply}` } },
        { quickReplyButton: { displayText: `${text_button_two}`, id: `${keyword_auto_replytwo}` } },
    ]
    if (!image) {
    const {
      state,
      saveState
    } = useSingleFileAuthState(`./session/ridped-md-${SessionName}.json`);
    var sendResult = await session.client.then(async client => {
        
      // send a simple text!
      return await client.sendMessage(number, {
        text: content,
        templateButtons: buttonz
      }).then((result) => {
        //console.log("Result: ", result); //return object success
        //
        return {
          "erro": false,
          "status": 200,
          "group": number,
          "message": "Pesan berhasil dikirim."
        };
        //
      }).catch((erro) => {
        console.error("Kesalahan saat mengirim: ", erro); //return object error
        return {
          "erro": true,
          "status": 404,
          "group": number,
          "message": "ada Kesalahan saat mengirim pesan",
          "msg": erro
        };
        //
      });
    });
    } else {
    var sendResult = await session.client.then(async client => {
      // send a simple text!
      return await client.sendMessage(number, {
        caption: content,
        templateButtons: buttonz,
        image: { url: image }
      }).then((result) => {
        //console.log("Result: ", result); //return object success
        //
        return {
          "erro": false,
          "status": 200,
          "group": number,
          "message": "Pesan berhasil dikirim."
        };
        //
      }).catch((erro) => {
        console.error("Kesalahan saat mengirim: ", erro); //return object error
        return {
          "erro": true,
          "status": 404,
          "group": number,
          "message": "ada Kesalahan saat mengirim pesan",
          "msg": erro
        };
        //
      });
    });
    }
    return sendResult;
  } //sendButton
  //
  // ------------------------------------------------------------------------------------------------//
  static async sendFiles(
    SessionName,
    from,
    url,
    ex,
    filename,
    caption = ''
  ) {
    console.log("- mengirim file", url);
    var session = Sessions.getSession(SessionName);
    const {
      state,
      saveState
    } = useSingleFileAuthState(`./session/ridped-md-${SessionName}.json`);
    var sendFile = await session.client.then(async (client) => {
        
      if (ex == 'pdf') {
        return await client.sendMessage(from, {
          document: { url: url},
          fileName: filename,
          mimetype: 'application/pdf'
        }).then((result) => {
          return {
            "erro": false,
            "status": 200,
            "message": "Success"
          }
        }).catch((erro) => {
          return {
            "erro": true,
            "status": 500,
            "message": "unknown error"
          }
        })
      } else if (ex == 'mp3') {
        return await client.sendMessage(from, {
          audio: { url: url},
          mimetype: 'audio/mp4'
        }).then((result) => {
          return {
            "erro": false,
            "status": 200,
            "message": "succes"
          }
        }).catch((erro) => {
          return {
            "erro": true,
            "status": 500,
            "message": "unknown error"
          }
        })
      } else if (ex == 'mp4') {
        return await client.sendMessage(from, {
          video: { url: url},
          caption: caption
        }).then((result) => {
          return {
            "erro": false,
            "status": 200,
            "message": "Success"
          }
        }).catch((erro) => {
          return {
            "erro": true,
            "status": 500,
            "message": "unknown error"
          }
        })
      } else if (ex == 'jpg' || 'png' || 'jpeg') {
        return await client.sendMessage(from, {
          image: { url: url},
          caption: caption,
          mimetype: 'image/jpeg'
        }).then((result) => {
          return {
            "erro": false,
            "status": 200,
            "message": "sukses"
          }
        }).catch((erro) => {
          return {
            "erro": true,
            "status": 500,
            "message": "unknown error"
          }
        })
      } else {
        return {
          "erro": true,
          "status": 404,
          "message": "Please check your details"
        }
      }
    });
    return sendFile;
  } //sendFile
  // ------------------------------------------------------------------------------------------------//
  static async getBlockList(SessionName) {
    console.log("- getBlockList");
    var session = Sessions.getSession(SessionName);
    const {
      state,
      saveState
    } = useSingleFileAuthState(`./session/ridped-md-${SessionName}.json`);
    var resultgetBlockList = await session.client.then(async client => {
       
      try {
        var result = session.blocklist;
        //console.log('Result: ', result); //return object success
        return result;
      } catch (erro) {
        console.error('Error when sending: ', erro); //return object error
        //
        return {
          "erro": true,
          "status": 404,
          "message": "Kesalahan saat mengambil daftar kontak yang diblokir"
        };
        //
      };
    });
    return resultgetBlockList;
  } //getBlockList
  //
  // ------------------------------------------------------------------------------------------------//

  static async getStatus(
    SessionName, number
  ) {
    console.log("- Mendapatkan status!");
    var session = Sessions.getSession(SessionName);
    const {
      state,
      saveState
    } = useSingleFileAuthState(`./session/ridped-md-${SessionName}.json`);
    var resultgetStatus = await session.client.then(async client => {
        
      return await client.fetchStatus(number).then((result) => {
        //console.log('Result: ', result); //return object success
        return result;
      }).catch((erro) => {
        console.error('Error when sending:\n', erro); //return object error
        //
        return {
          "erro": true,
          "status": 404,
          "message": "Kesalahan saat mengambil status kontak"
        };
        //
      });
    });
    return resultgetStatus;
  } //getStatus
  //
  // ------------------------------------------------------------------------------------------------//
  static async getProfilePicFromServer(
    SessionName,
    number
  ) {
    console.log("- Mendapatkan gambar profil server!");
    var session = Sessions.getSession(SessionName);
    const {
      state,
      saveState
    } = useSingleFileAuthState(`./session/ridped-md-${SessionName}.json`);
    var resultgetProfilePicFromServer = await session.client.then(async client => {
        
      return await client.profilePictureUrl(number).then((result) => {
        //console.log('Result: ', result); //return object success
        return {
          "url": result
        };
      }).catch((erro) => {
        console.error('Error when sending:\n', erro); //return object error
        //
        return {
          "erro": true,
          "status": 404,
          "message": "Kesalahan mendapatkan gambar profil dari server"
        };
        //
      });
    });
    return resultgetProfilePicFromServer;
  } //getProfilePicFromServer
  //
  // ------------------------------------------------------------------------------------------------//
  static async checkNumberStatus(
    SessionName,
    number
  ) {
    console.log("- canReceiveMessage");
    var session = Sessions.getSession(SessionName);
    const {
      state,
      saveState
    } = useSingleFileAuthState(`./session/ridped-md-${SessionName}.json`);
    var resultcheckNumberStatus = await session.client.then(async client => {
        client.ev.on('connection.update', async (rids) => {
          const {
        connection,
        lastDisconnect,
        isNewLogin,
        qr,
        receivedPendingNotifications
      } = rids;
          if (connection === 'close') {
        console.log("- Connection close".red);
        console.log(`- Output: \n ${JSON.stringify(lastDisconnect?.error.output)}`);
        console.log(`- Data: \n ${JSON.stringify(lastDisconnect?.error.data)}`);
        console.log(`- loggedOut: \n ${JSON.stringify(DisconnectReason.loggedOut)}`);
            if (lastDisconnect?.error.output.statusCode !== DisconnectReason?.loggedOut) {

            return Sessions.initSession(SessionName);

            }
          }
        
      });
      //
      
      return await client.onWhatsApp(number).then(([result]) => {
        //console.log('Result:\n', result); //return object success
        //
        if (result.exists) {
          return {
            "erro": false,
            "status": 200,
            "number": result.jid,
            "message": "Nomor tersebut terdaftar di whatsapp"
          };
          //
        } else if (!result.exists) {
          //
          return {
            "erro": true,
            "status": 404,
            "number": result.jid,
            "message": "Nomor yang dimasukkan tidak terdaftar di whatsapp"
          };
          //
        } else {
          //
          return {
            "erro": true,
            "status": 404,
            "message": "Kesalahan memverifikasi nomor yang dimasukkan "+ number
          };
          //
        }
      }).catch((erro) => {
        console.error('Error when sending:\n', erro); //return object error
        //
        return {
          "erro": true,
          "status": 404,
          "message": "Kesalahan memverifikasi nomor yang dimasukkan" + number
        };
        //
      });
    });
    return resultcheckNumberStatus;
  } //checkNumberStatus

  // ------------------------------------------------------------------------------------------------//
  // Get device info
  static async getHostDevice(SessionName) {
    console.log("- getHostDevice");
    var session = Sessions.getSession(SessionName);
    const {
      state,
      saveState
    } = useSingleFileAuthState(`./session/ridped-md-${SessionName}.json`);
    var resultgetHostDevice = await session.client.then(async client => {
        
      return await client.getHostDevice().then((result) => {
        //console.log('Result: ', result); //return object success
        //
        return {
          "erro": false,
          "status": 200,
          "message": "Data perangkat berhasil diperoleh",
          "HostDevice": {
            "user": result.wid.user,
            "connected": result.connected,
            "isResponse": result.isResponse,
            "battery": result.battery,
            "plugged": result.plugged,
            "locales": result.locales,
            "is24h": result.is24h,
            "device_manufacturer": result.phone.device_manufacturer,
            "platform": result.platform,
            "os_version": result.phone.os_version,
            "wa_version": result.phone.wa_version,
            "pushname": result.pushname
          }
        };
        //
      }).catch((erro) => {
        console.error('Error when sending: ', erro); //return object error
        //
        return {
          "erro": true,
          "status": 404,
          "message": "Kesalahan mendapatkan data dari perangkat"
        };
        //
      });
    });
    return resultgetHostDevice;
  } //getHostDevice
  //
  // ------------------------------------------------------------------------------------------------//
  // Get battery level
  static async getBatteryLevel(SessionName) {
    console.log("- getBatteryLevel");
    var session = Sessions.getSession(SessionName);
    var resultgetBatteryLevel = await session.client.then(async client => {
      return await client.getBatteryLevel().then((result) => {
        //console.log('Result: ', result); //return object success
        //
        return {
          "erro": false,
          "status": 200,
          "message": "Tingkat baterai berhasil diperoleh",
          "BatteryLevel": result

        };
        //
      }).catch((erro) => {
        console.error('Error when sending: ', erro); //return object error
        //
        return {
          "erro": true,
          "status": 404,
          "message": "Kesalahan mendapatkan level baterai"
        };
        //
      });
    });
    return resultgetBatteryLevel;
  } //getBatteryLevel
  //
}

async function sendHook(url, data) {
    var result = {
        mode: 'Tidak ada webhook untuk keyword tsb'
    };
    await axios.post(url, data).then(res => {
        if (res.data != null) result = res.data
    }).catch(err => {
        console.log(err)
    })

    return result;
}

function replaceString(oldS, newS, fullS) {
  return fullS.split(oldS).join(newS)
}
const {
  app,
  BrowserWindow,
  globalShortcut,
  Tray,
  Menu,
  Notification,
  protocol,
  session,
  screen,
} = require("electron");
const path = require("path");

let MainWindowMinimized = false;
let NotificationsEnabled = true;
let SecondWindowOpen = false;
var phpServer = require("node-php-server");
const port = 8000,
  host = "127.0.0.1";
const serverUrl = `http://${host}:${port}`;
let mainWindow;
let gameLauncherWindow;
var iconpath = path.join(__dirname, "icon.ico");
var pjson = require(__dirname + "/package.json");
let pluginName;
var devTools = true;


if (require("electron-squirrel-startup")) {
  app.quit();
}

switch (process.platform) {
  case "win32":
    pluginName = "flash/pepflashplayer.dll";
    break;
  case "darwin":
    pluginName = "flash/PepperFlashPlayer.plugin";
    break;
  case "linux":
    pluginName = "flash/libpepflashplayer.so";
    break;
}
app.commandLine.appendSwitch(
  "ppapi-flash-path",
  path.join(__dirname, pluginName)
);

const createWindow = () => {
  phpServer.createServer({
    port: port,
    hostname: host,
    base: `${__dirname}/www/public`,
    keepalive: false,
    open: false,
    bin: `${__dirname}/php/php.exe`,
    router: __dirname + "/www/server.php",
  });

  mainWindow = new BrowserWindow({
    width: 1128,
    height: 736,
    icon: iconpath,
    title: "BoomBang",
    webPreferences: {
      plugins: true,
      nodeIntegration: true,
    },
    show: false,
    frame: true,
    backgroundColor: pjson.backgroundColor,
  });

  mainWindow.loadURL(serverUrl);
  mainWindow.setMenu(null);
  devToolsMainWindow();
  mainWindow.show();

  mainWindow.webContents.on("did-finish-load", () => {});

  mainWindow.on("close", function (event) {
    if (SecondWindowOpen) {
      event.preventDefault();
      app.ShowNotification(
        "BoomBang se ha minimozado. Preciona F1 para volver a abrir pagina de inicio."
      );
      mainWindow.hide();

      MainWindowMinimized = true;

      return false;
    } else {
      return true;
    }
  });

  mainWindow.on("closed", (event) => {
    mainWindow = null;
  });

  //Game Launcher Window
  mainWindow.webContents.on("new-window", (event, url) => {
    event.preventDefault();
    console.log(url);
    if (url == "http://127.0.0.1:8000/play") {
      var win = new BrowserWindow({
        autoHideMenuBar: true,
        width: 1019,
        height: 687,
        icon: iconpath,
        title: "Play",
        webPreferences: {
          plugins: true,
          nodeIntegration: true,
        },
        show: false,
        frame: true,
        backgroundColor: pjson.backgroundColor,
        resizable: false,
      });
    } else {
      const { width, height } = screen.getPrimaryDisplay().workAreaSize;

      var win = new BrowserWindow({
        autoHideMenuBar: true,
        icon: iconpath,
        title: "Play",
        width,
        height,
        fullscreen: true,
        webPreferences: {
          plugins: true,
          nodeIntegration: true,
        },
        show: false,
        frame: true,
        backgroundColor: pjson.backgroundColor,
        resizable: false,
      });
    }

    win.on("closed", (event) => {
      win = null;
      if (MainWindowMinimized) {
        mainWindow.show();
        MainWindowMinimized = false;
      }
      SecondWindowOpen = false;
    });

    SecondWindowOpen = true;
    gameLauncherWindow = win;

    win.setResizable(false);
    win.once("ready-to-show", () => win.show());
    win.loadURL(url);
    event.newGuest = win;
  });
  globalShortcut.register("f5", function () {
    if (SecondWindowOpen) {
      gameLauncherWindow.reload();
    }
  });
  globalShortcut.register("f6", function () {
    mainWindow.reload();
  });
  globalShortcut.register("f1", function () {
    if (MainWindowMinimized) {
      mainWindow.show();
      MainWindowMinimized = false;
    }
  });
  globalShortcut.register("f2", function () {
    session.defaultSession.clearCache();
  });
};

function devToolsMainWindow(){
  if (devTools){
    let menuTemplate = [
      {
        label: "Tools",
        submenu: [
          {
            label: "DevTools",
            click(item, focusedWindow) {
              focusedWindow.toggleDevTools();
            },
          },
        ],
      },
    ];
    let menu = Menu.buildFromTemplate(menuTemplate);
    Menu.setApplicationMenu(menu);
  }
}

app.ShowNotification = (message) => {
  if (!NotificationsEnabled) {
    return;
  }
  var notif = new Notification({
    title: "BoomBang",
    body: message,
    icon: iconpath,
  });
  notif.show();
};

app.on("ready", () => {
  createWindow();
});

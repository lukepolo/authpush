import Pusher from "pusher-js";

export default class SocketService {
  constructor() {
    Pusher.logToConsole = true;
  }

  startSocket() {
    this.pusher = new Pusher("92790f94d685df8a2c16", {
      wsHost: "ws.pusherapp.com",
      httpHost: "sockjs.pusher.com",
      encrypted: true,
    });
  }

  joinChannel(channel, submitFunction) {
    this.channel = this.pusher.subscribe(channel);
    this.channel.bind("App\\Events\\Approved", (data) => {
      submitFunction(data.code);
    });
  }
}

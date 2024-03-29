import Pusher from "pusher-js";

export default class SocketService {
  constructor() {
    Pusher.logToConsole = true;
  }

  startSocket() {
    this.pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
      cluster: process.env.MIX_PUSHER_APP_CLUSTER,
      encrypted: true,
    });
  }

  joinChannel(channel, submitFunction) {
    this.channel = this.pusher.subscribe(channel);
    this.channel.bind("App\\Events\\ApprovedRequest", (data) => {
      submitFunction(data.code);
    });
  }
}

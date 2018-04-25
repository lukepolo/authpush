import TokenService from "./TokenService";
import SocketService from "./SocketService";

let socketService = new SocketService();
socketService.startSocket();

window.authpush = ({ token, input, email }) => {
  let tokenService = new TokenService(input);
  tokenService.requestApproval(token, email);
  socketService.joinChannel(
    `${token}-${email.toLowerCase()}`,
    tokenService.submitToken.bind(tokenService),
  );
};
